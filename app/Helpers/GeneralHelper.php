<?php

use App\Models\User;
use App\Models\Setting;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

if (!function_exists('getInfoLogin')) {
	function getInfoLogin()
    {
        $user = Auth::user();
        return $user;
	}
}

if (!function_exists('getSetting')) {
    function getSetting($options)
    {
		$result = Setting::where('options', $options)->first();
		if ($result) {
			return $result->value;
		} else {
			return '';
		}
	}
}

if (!function_exists('stripCharacter')) {
    function stripCharacter($input)
    {
        return preg_replace("/[^0-9]/", "", $input);
    }
}
