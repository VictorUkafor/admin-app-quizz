<?php
namespace App\Helpers;

use Config;

class Helper {

	const REGULAR_USER = 'member';
	const ADMIN_USER = 'admin';
    const SUPPORT = 'support';
    const REVIEWER = 'reviewer';

    const DASHBOARD_URL = '';

	public static function formatMoney($value='')
	{
		return "$".number_format($value, 2);
	}

	function isImageUrl($l)
	{
	    $arr = explode("?", $l);

	    return preg_match("#\.(jpg|jpeg|gif|png)$# i", $arr[0]);
	}

	public static function avatarUrl($name)
	{
		return $name ? asset('uploads/avatar/' . $name) : asset('img/default-avatar.jpg');
	}

	public static function avatarThumbUrl($name)
	{
		return $name ? asset('uploads/avatar/sm/' . $name) : asset('img/default-avatar.jpg');
	}

	public static function imagePath($name)
	{
		return public_path('uploads/images/' . $name);
	}

	public static function imageUrl($name)
	{
		return asset('uploads/images/' . $name);
	}

	public static function imageThumbUrl($name)
	{
		return asset('uploads/images/sm/' . $name);
	}

	public static function videoPath($name)
	{
		return asset('uploads/videos/' . $name);
	}

	public static function splitFullname($fullname)
	{
		$parts = explode(' ', $fullname);
		$lastname = array_pop($parts);
		$firstname = implode(' ', $parts);

		$data['firstname'] = $firstname;
		$data['lastname']  = $lastname;

		return $data;
	}

	public static function getUsernameFromEmail($email)
    {
    	$now = strtotime('now');

        return substr($email, 0, strrpos($email, '@')) . '_' . $now . rand(5, 15);
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
}
