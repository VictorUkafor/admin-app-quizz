<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use App\Template;
use Auth, Validator, Storage, Log;

class TemplateController extends Controller
{
    private function generateUniqueUUID()
    {
        $uids = Template::pluck('uuid')->toArray();
        $uid = Str::uuid()->toString();
    
        for ($x = 0; $x < count($uids); $x++) {
            if ($uids[$x] === $uid) {
                $uid = Str::uuid()->toString();
                $x = 0;
            }
        }
    
        return $uid;
    }


    public function index(Request $request){
        try {

            $data = [
                "page" => "create-template"
            ];
                        
            return view('Admin.create-template', $data);

        }catch(Exception $e){
            return response()->json([
                'message' => $e->message(),
                'status' => false,
            ], 500);
        }
    }

    public function manageTemplates(Request $request){
        try {

            $data = [
                "page" => "templates"
            ];
                        
            return view('Admin.templates', $data);

        }catch(Exception $e){
            return response()->json([
                'message' => $e->message(),
                'status' => false,
            ], 500);
        }
    }


    public function create(Request $request){
        try {

            $validator = Validator::make($request->all(), [
                'json' => 'nullable',
                'name' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                    'status' => false,
                ], 400);
            }

            $uid = $this->generateUniqueUUID();

            $template = new Template;
            $template->user_id = Auth::id();
            $template->uuid = $uid;
            $template->name = $request->name; 
            $template->json = json_encode($request->json); 
            $template->save();                

            return response()->json([
                'template' => $template,
                'message' => 'Template created successfully',
                'status' => true,
            ], 201);

        }catch(Exception $e){
            return response()->json([
                'message' => $e->message(),
                'status' => false,
            ], 500);
        }
    }


    public function get(Request $request){
        try {
                        
            $templates = Template::orderBy('id', 'desc')->paginate(11);   
            
            return response()->json([
                'templates' => $templates,
                'status' => true,
            ], 200);

        }catch(Exception $e){
            return response()->json([
                'message' => $e->message(),
                'status' => false,
            ], 500);
        }
    }


    public function show($uuid){
        try {

            $template = Template::where('uuid', $uuid)->first();

            if(!$template){
                return response()->json([
                    'message' => "Template could not be found",
                    'status' => false,
                ], 404);
            }
            
            return response()->json([
                'template' => $template,
                'status' => true,
            ], 200);

        }catch(Exception $e){
            return response()->json([
                'message' => $e->message(),
                'status' => false,
            ], 500);
        }
    }


    public function edit(Request $request, $uuid){
        try {

            $validator = Validator::make($request->all(), [
                'json' => 'nullable',
                'name' => 'nullable'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                    'status' => false,
                ], 400);
            }

            $template = Template::where('uuid', $uuid)->first();

            if(!$template){
                return response()->json([
                    'message' => "Template could not be found",
                    'status' => false,
                ], 404);
            }


            $template->json = $request->json ? json_encode($request->json) : $template->json;
            $template->name = $request->name ? $request->name : $template->name;
            $template->save();   
            
            return response()->json([
                'template' => $template,
                'message' => 'Template updated successfully',
                'status' => true,
            ], 200);
            
        }catch(Exception $e){
            return response()->json([
                'message' => $e->message(),
                'status' => false,
            ], 500);
        }
    }


    public function delete($uuid){
        try {

            $template = Template::where('uuid', $uuid)->first();

            if(!$template){
                return response()->json([
                    'message' => "Template could not be found",
                    'status' => false,
                ], 404);
            }

            $template->delete();
            
            return response()->json([
                'message' => 'Template deleted successfully',
                'status' => true,
            ], 200);
            
        }catch(Exception $e){
            return response()->json([
                'message' => $e->message(),
                'status' => false,
            ], 500);
        }
    }
}
