<?php
namespace App\Helpers;
use Route;

class Utility {

	/**
	 * Get either a Gravatar URL or complete image tag for a specified email address.
	 *
	 * @param string $email The email address
	 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
	 * @param string $d Default imageset to use [ 404 | mp | identicon | monsterid | wavatar ]
	 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
	 * @param boole $img True to return a complete IMG tag False for just the URL
	 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
	 * @return String containing either just a URL or a complete image tag
	 * @source https://gravatar.com/site/implement/images/php/
	 */
	public static function get_gravatar( $email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array() ) {
	    $url = 'https://www.gravatar.com/avatar/';
	    $url .= md5( strtolower( trim( $email ) ) );
	    $url .= "?s=$s&d=$d&r=$r";
	    if ( $img ) {
	        $url = '<img src="' . $url . '"';
	        foreach ( $atts as $key => $val )
	            $url .= ' ' . $key . '="' . $val . '"';
	        $url .= ' />';
	    }
	    return $url;
	}

	
	/**
	 *
	 * @since 1.0.0
	 * 
	 * getIP - returns the IP of the visitor
	 * @return client remote address
	 *
	 *
	 */
    public static function getClientIP() {

        if (isset($_SERVER)) {

            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
                return $_SERVER["HTTP_X_FORWARDED_FOR"];

            if (isset($_SERVER["HTTP_CLIENT_IP"]))
                return $_SERVER["HTTP_CLIENT_IP"];

            return $_SERVER["REMOTE_ADDR"];
        }

        if (getenv('HTTP_X_FORWARDED_FOR'))
            return getenv('HTTP_X_FORWARDED_FOR');

        if (getenv('HTTP_CLIENT_IP'))
            return getenv('HTTP_CLIENT_IP');

        return getenv('REMOTE_ADDR');
    }

    public static function UUID() {
	    return sprintf('%04x%04x%04x%04x%04x%04x%04x%04x',

	      // 32 bits for "time_low"
	      mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),

	      // 16 bits for "time_mid"
	      mt_rand(0, 0xffff),mt_rand(0, 0xffff),mt_rand(0, 0xffff),

	      // 16 bits for "time_hi_and_version",
	      // four most significant bits holds version number 4
	      mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x0fff) | 0x4000,

	      // 16 bits, 8 bits for "clk_seq_hi_res",
	      // 8 bits for "clk_seq_low",
	      // two most significant bits holds zero and one for variant DCE1.1
	      mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0x3fff) | 0x8000,

	      // 48 bits for "node"
	      mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
	    );
  	}


  	public static function httpify($link, $append = 'http://', $allowed = array('http://', 'https://')){
  	$found = false;
  	foreach($allowed as $protocol)
  	{
  		if(strpos($link, $protocol) !== false)
      		$found = true;
  	}

	  	if($found)
	    	return $link;

	  	return $append . $link;
	}

	// From https://gist.github.com/tlongren/5527129
	public static function slugit($str, $replace=array(), $delimiter='-')
	{
	    if ( !empty($replace) ) 
	    {
	        $str = str_replace((array)$replace, ' ', $str);
	    }

	    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	    $clean = preg_replace("/[^a-zA-Z0-9-_|+ -]/", '', $clean);
	    $clean = strtolower(trim($clean, '-'));
	    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

	    return $clean;
	}

	public static function splitName($name) {
	    $parts = array();

	    while ( strlen( trim($name)) > 0 ) {
	        $name = trim($name);
	        $string = preg_replace('#.*\s([\w-]*)$#', '$1', $name);
	        $parts[] = $string;
	        $name = trim( preg_replace('#'.$string.'#', '', $name ) );
	    }

	    if (empty($parts)) {
	        return false;
	    }

	    $parts = array_reverse($parts);
	    $name = array();
	    $name['first_name'] = $parts[0];
	    $name['middle_name'] = (isset($parts[2])) ? $parts[1] : '';
	    $name['last_name'] = (isset($parts[2])) ? $parts[2] : ( isset($parts[1]) ? $parts[1] : '');

	    return $name;
	}

	public static function isActiveRoute($route, $output = "active")
	{
    if (Route::currentRouteName() == $route) return $output;
	}


	public static function userStatus($status, $output = "")
	{
		switch ($status) {
			case 1:
					$output = 'text-success';
				break;
			case 0:
					$output = 'text-danger';
				break;
		}
    	return $output;
	}


	public static function unixdatetime_to_text($unixdatetime="") {
		if(empty($unixdatetime)) {
		    return 'Classified';
		} else {
		    return strftime("%B %d, %Y at %I:%M %p", $unixdatetime); 
		}
	}


	public static function timeRemaining($timestamp=''){
	    // $future_date = new DateTime();
	    // $interval = $future_date->diff($date);
	    // $format = $interval->format("%d days, %h hours, %i minutes, %s seconds")
	    $date = strtotime("+1 day",$timestamp);
	    $seconds = $date-time();
	    $days = floor($seconds/86400);
	    $days = ($days > 0)? $days: 0;
	    $seconds %= 86400;
	    $hours = floor($seconds/3600);
	    $hours = ($hours > 0)? $hours: 0;
	    $seconds %= 3600;
	    $minutes = floor($seconds/60);
	    $minutes = ($minutes > 0)? $minutes: 0;
	    $seconds %= 60;
	    $seconds = ($seconds > 0)? $seconds: 0;
	    $result = "$days day(s), $hours hour(s), $minutes minute(s) and $seconds second(s) left";
	    return $result;
	}


	  //  public static function checkTimeRemaining($timestamp='')
	  // {
	  //   $date = strtotime("+1 day",$timestamp);
	  //   $seconds = $date-time();
	  //   return $seconds;
	  // }

	public static function checkTimeRemaining($timestamp='',$tomorrow='+1 day'){
	    $date = strtotime($tomorrow,$timestamp);
	    $seconds = $date-time();
	    return ($seconds > 0)? true: false;
	}


	public static function getExpire($date,$secs)
	{
		$current_time = time();
		$expire_time = 0;
		$timestamp = strtotime($date);
		// check if there is no expire timestamp in db
		if($timestamp){
		  $expire_time = $timestamp + $secs; 
		}
		return self::unixdatetime_to_text($expire_time);
	}


	public static function getActiveStatus($date,$secs)
	{
		$current_time = time();
		$timestamp = strtotime($date);
		// check if there is no expire timestamp in db
		if($timestamp){
		  $expire_time = $timestamp + $secs; 
	
			if($expire_time > $current_time){
				return true;
			}
		}
		return false;
	}


	public static function getIp(){
	    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
	        if (array_key_exists($key, $_SERVER) === true){
	            foreach (explode(',', $_SERVER[$key]) as $ip){
	                $ip = trim($ip); // just to be safe
	                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
	                    return $ip;
	                }
	            }
	        }
	    }
	}


	public static function split_name($name) {
	    $name = trim($name);
	    $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
	    $first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );
	    return array('firstname'=>$first_name, 'lastname'=>$last_name);
	}


	public static function randomPassword($cnt = 8) 
    {
	    $alphabet = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache

	    for ($i = 0; $i < $cnt; $i++) {

	        $n = rand(0, $alphaLength);

	        $pass[] = $alphabet[$n];
	    }

	    $pass = implode($pass);

	    return $pass;//turn the array into a string
	}


	public static function pageTitle($url) 
	{
        $fp = file_get_contents($url);
        if (!$fp) 
            return null;

        $res = preg_match("/<title>(.*)<\/title>/siU", $fp, $title_matches);
        if (!$res) 
            return null; 

        // Clean up title: remove EOL's and excessive whitespace.
        $title = preg_replace('/\s+/', ' ', $title_matches[1]);
        $title = trim($title);
        return $title;
    }


    public static function getSiteFavicon($url)
	{
	    $ch = curl_init('http://www.google.com/s2/favicons?domain='.$url);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    
	    $data = curl_exec($ch);
	    curl_close($ch);
	 
	    header("Content-type: image/png; charset=utf-8");
	    echo $data;
	}


	// public static function getFavicon($url)
	// {
	//     # make the URL simpler
	//     $elems = parse_url($url);
	//     $url = $elems['scheme'].'://'.$elems['host'];

	//     # load site
	//     $output = file_get_contents($url);

	//     # look for the shortcut icon inside the loaded page
	//     $regex_pattern1 = "/rel=\"shortcut icon\" (?:href=[\'\"]([^\'\"]+)[\'\"])?/";
	//     $regex_pattern2 = "/rel=\"icon\" (?:href=[\'\"]([^\'\"]+)[\'\"])?/";

	//     preg_match_all($regex_pattern1, $output1, $matches1);

	//     preg_match_all($regex_pattern2, $output2, $matches2);

	//     $matches = isset($matches1[1][0])? $matches1 : $matches2;

	//     if(isset($matches[1][0])){
	//         $favicon = $matches[1][0];

	//         # check if absolute url or relative path
	//         $favicon_elems = parse_url($favicon);

	//         # if relative
	//         if(!isset($favicon_elems['host'])){
	//             $favicon = $url . '/' . $favicon;
	//         }

	//         return $favicon;
	//     }

 //    	return false;
	// }


	public static function getFavicon($url)
	{
	   $elems = parse_url($url);
	   $url = $elems['scheme'].'://'.$elems['host'];

	   $href = false;
	   // $ch = curl_init($url);
	   // curl_setopt($ch, CURLOPT_HEADER, 0);
	   // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	   // $content = curl_exec($ch);
	   $opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
	   $context = stream_context_create($opts);

	   $content = file_get_contents($url,false,$context);
	   if (!empty($content))
	   {
	      $dom = new \DOMDocument();
	      @$dom->loadHTML($content);
	      $items = $dom->getElementsByTagName('link');
	     
	      foreach ($items as $item)
	      {  
	         $rel = $item->getAttribute('rel');

	         if ($rel == 'icon' or $rel == 'shortcut icon')
	         {
	            	$favicon = $item->getAttribute('href');
            		# check if absolute url or relative path
			        $favicon_elems = parse_url($favicon);
			        # if relative
			        if(!isset($favicon_elems['host'])){
			            $href = rtrim($url,'/').$favicon;
			        }else{
			        	$href = $favicon;
			        }

	            break;
	         }
	      }
	   }
	   return $href;
	}

	//http://www.jonasjohn.de/snippets/php/trim-array.htm
	public static function TrimArray($Input){
 
	    if (!is_array($Input))
	        return trim($Input);
	 
	    return array_map('self::TrimArray', $Input);
	}

	public static function getUrlData($url, $raw=false) // $raw - enable for raw display
	{
	    $result = false;
	   
	    $contents = self::getUrlContents($url);

	    if (isset($contents) && is_string($contents))
	    {
	        $title = null;
	        $metaTags = null;
	        $metaProperties = null;
	       
	        preg_match('/<title>([^>]*)<\/title>/si', $contents, $match );

	        if (isset($match) && is_array($match) && count($match) > 0)
	        {
	            $title = strip_tags($match[1]);
	        }
	       
	        preg_match_all('/<[\s]*meta[\s]*(name|property)="?' . '([^>"]*)"?[\s]*' . 'content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', $contents, $match);

	        $match = self::TrimArray($match);
	       
	        if (isset($match) && is_array($match) && count($match) == 4)
	        {
	            $originals = $match[0];
	            $names = $match[2];
	            $values = $match[3];
	           
	            if (count($originals) == count($names) && count($names) == count($values))
	            {
	                $metaTags = array();
	                $metaProperties = $metaTags;
	                if ($raw) {
	                    if (version_compare(PHP_VERSION, '5.4.0') == -1)
	                         $flags = ENT_COMPAT;
	                    else
	                         $flags = ENT_COMPAT | ENT_HTML401;
	                }
	               
	                for ($i=0, $limiti=count($names); $i < $limiti; $i++)
	                {
	                    if ($match[1][$i] == 'name')
	                         $meta_type = 'metaTags';
	                    else
	                         $meta_type = 'metaProperties';
	                    if ($raw)
	                        ${$meta_type}[$names[$i]] = array (
	                            'html' => htmlentities($originals[$i], $flags, 'UTF-8'),
	                            'value' => $values[$i]
	                        );
	                    else
	                        ${$meta_type}[$names[$i]] = array (
	                            'html' => $originals[$i],
	                            'value' => $values[$i]
	                        );
	                }
	            }
	        }
	       
	        $result = array (
	            'title' => $title,
	            'metaTags' => $metaTags,
	            'metaProperties' => $metaProperties,
	        );
	    }
	   
	    return $result;
	}


	protected static function getUrlContents($url, $maximumRedirections = null, $currentRedirection = 0)
	{
	    $result = false;
	   
	    $contents = @file_get_contents($url);
	   
	    // Check if we need to go somewhere else
	   
	    if (isset($contents) && is_string($contents))
	    {
	        preg_match_all('/<[\s]*meta[\s]*http-equiv="?REFRESH"?' . '[\s]*content="?[0-9]*;[\s]*URL[\s]*=[\s]*([^>"]*)"?' . '[\s]*[\/]?[\s]*>/si', $contents, $match);
	       
	        if (isset($match) && is_array($match) && count($match) == 2 && count($match[1]) == 1)
	        {
	            if (!isset($maximumRedirections) || $currentRedirection < $maximumRedirections)
	            {
	                return getUrlContents($match[1][0], $maximumRedirections, ++$currentRedirection);
	            }
	           
	            $result = false;
	        }
	        else
	        {
	            $result = $contents;
	        }
	    }
	   
	    return $contents;
	}


	//https://stackoverflow.com/questions/18702921/how-to-check-if-the-url-is-iframe-embeddable-in-php
	public static function iframeEmbedable($url='')
	{	
		if(empty($url)) return false;

		$url_headers = get_headers($url);
		foreach ($url_headers as $key => $value)
		{
		    $x_frame_options_deny = strpos(strtolower($url_headers[$key]), strtolower('X-Frame-Options: DENY'));
		    $x_frame_options_sameorigin = strpos(strtolower($url_headers[$key]), strtolower('X-Frame-Options: SAMEORIGIN'));
		    $x_frame_options_allow_from = strpos(strtolower($url_headers[$key]), strtolower('X-Frame-Options: ALLOW-FROM'));
		    if ($x_frame_options_deny !== false || $x_frame_options_sameorigin !== false || $x_frame_options_allow_from !== false)
		    {
		        //'url prevent iframe!';
		        return false;
		    }
		}
		return true;
	}


	public static function getSlugFromUrl($url='')
	{
		if(empty($url)) return false;

		$url = parse_url($url);

    	$split = explode('/', $url['path']);

    	return isset($split[2])? $split[2] : false;
	}


	public static function truncate($string,$length=80,$append="...") {
	  $string = trim($string);

	  if(strlen($string) > $length) {
	    $string = wordwrap($string, $length);
	    $string = explode("\n", $string, 2);
	    $string = $string[0] . $append;
	  }

	  return $string;
	}



	public static function getURLQueryParam($url){
		parse_str(parse_url($url, PHP_URL_QUERY), $output);
		return $output;
	}
	

	public static function getRequest($url='')
    {
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => ''
        ]);
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);

        return $resp;
    }

   
}

?>