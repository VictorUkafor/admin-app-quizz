<?php

namespace App\Http\Controllers\Subscriptions;

use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Helpers\PaymentConfig;
use App\Helpers\SubscriptionManager;
use App\Helpers\PaymentTransactionLogger;
use Validator;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;

class ThriveCartController extends Controller
{
    const GATEWAY = 'thrivecart';
	const STATUS_COMPLETED = 'completed';
	const STATUS_CANCELLED = 'cancelled';
    const STATUS_FAILED = 'failed';

    function ipnVerification(Request $request)
    {
        $data = $request->all();

        $secretKey = "H7BB857UZPB1";
        // $pop = "";
        // $ipnFields = array();

        // foreach ($data as $key => $value) 
        // {
        //      if ($key == "cverify")
        //      {
        //      continue;
        //      }

        //      $ipnFields[] = $key;
        // }

        // sort($ipnFields);

        // foreach ($ipnFields as $field) 
        // {
        //     // if Magic Quotes are enabled $_POST[$field] will need to be
        //     // un-escaped before being appended to $pop
        //      $pop = $pop . $data[$field] . "|";
        // }

        // $pop = $pop . $secretKey;
        // $calcedVerify = sha1(mb_convert_encoding($pop, "UTF-8"));
        // $calcedVerify = strtoupper(substr($calcedVerify,0,8));
        // return $calcedVerify == $_POST["cverify"];
        
        return ($data['thrivecart_secret'] === $secretKey)? 1 : 0;
    }

    function processPayment(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'base_product' => 'required',
            'customer' => 'required',
            'order_id' => 'required',
            'event' => 'required',
            'event' => 'required',
        ]);

        if ($validator->fails())
        {
            exit('Bad Request');
        }

        $product_id = $data['base_product']; 

        if (!in_array($product_id, [25,24])) {
             exit('Product not found');
        }
        
        $email = $data['customer']['email'];
        $firstname = $data['customer']['first_name'];
        $lastname  = $data['customer']['last_name'];

        $payment_type = $data['event'];
        $order_id = $data['order_id'];
        $transaction_id = $data['invoice_id'];
        $amount =  $data['order']['total_str'];
        
        if ($payment_type === 'order.success' || $payment_type === 'order.subscription_payment')
        {
            $transaction_type = PaymentConfig::STATUS_COMPLETED;
        }
        elseif ($payment_type === 'order.refund')
        {
            $transaction_type = PaymentConfig::STATUS_REFUND;
        }

        if (empty( $transaction_type ))
        {
            Log::info('ThriveCart IPN data: ', $data);

            return false;
        }

        if (PaymentTransactionLogger::transactionExists($transaction_id) && $transaction_type !== PaymentConfig::STATUS_REFUND)
        {
            exit("Transaction ID already processed.");
        }


        $sub_data = [
            'firstname' => $firstname,
            'lastname'  => $lastname,
            'email'     => $email,
            'fullname'   => $firstname.''.$lastname,
            'txn_id' => $transaction_id,
            'order_id' => $order_id,
            'transaction_type' => $transaction_type,
            'amount' => $amount . ' ' . PaymentConfig::CURRENCY_USD,
            'payment_gateway' => self::GATEWAY,
            'payment_status' => $transaction_type
        ];

        try{
            if($this->ipnVerification($request) == 1)
            {
                //$query = $request->get('sub_type');
                $query = '';
                switch ($product_id) {
                    case '25':
                       $query = 'pro';
                        break;
                    
                    case '24':
                       $query = 'main';
                        break;
                }

                if ($transaction_type === PaymentConfig::STATUS_COMPLETED){
                    SubscriptionManager::HandleSubscriptionRequest($query, $sub_data);
                }elseif ($transaction_type === PaymentConfig::STATUS_REFUND){
                    SubscriptionManager::HandleRefundRequest($query, $sub_data);
                }

            }

            echo 'Payment Processed';
        }catch(\Exception $e)
        {
            echo $e;
            exit(1);
        }

    }

}
