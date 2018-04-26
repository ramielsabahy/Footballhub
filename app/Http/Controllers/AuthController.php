<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
	// Authenticating a user
	public function authenticate(Request $request) {
		// normal login
		$credentials = request()->only('email', 'password');
		// social login
		$social = request()->only('facebook_id', 'facebook_token');

		// check if user credentials are correct
		try {
			// if normal login
			if($credentials['email']) {
				$token = \JWTAuth::attempt($credentials);
			} else {
				$user = User::where('facebook_id', '=', $social['facebook_id'])->get()->first();
				$token = \JWTAuth::fromUser($user);
				$user->facebook_token = $social['facebook_token'];
				$user->save();
			}

			if (!$token) {
				// unauthorized access
				$resp = new \App\Http\Helpers\ServiceResponse;
		        $resp->Message = "Invalid Credentials";
		        $resp->Status = false;
		        $resp->InnerData = (object)[];
		        return response()->json($resp, 401);
			}
		}
		catch(\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
			// expired token
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Token Expired";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 401);
		}
		catch(\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
			// invalid token
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Token Invalid";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 401);
		}
		catch(\Tymon\JWTAuth\Exceptions\TokenBlacklistedException $e) {
			// blacklisted token
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Token Blacklisted";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 401);
		}
		catch(\Tymon\JWTAuth\Exceptions\JWTException $e) {
			// internal server error
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Internal Error Occured";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 401);
		}

		// generate a token
		$user = \JWTAuth::toUser($token);

		if (!$user->active_status) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Account Suspended";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 401);
		}

		$user->load('roles');

		$user_type = request()->user_type;
		// if ($user_type == 1) {
		// 	// player
		// } else if ($user_type == 2) {
		// 	// referee
		// }

		// successful
		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Authenticated";
        $resp->Status = true;
        $resp->InnerData = compact('token', 'user');
        return response()->json($resp, 200);
	}

	// Admin Method
	// Create an admin Through API call
	public function register(Request $request) {
		// Check that the user making the request is an admin
		$token = \JWTAuth::getToken();
		$user = \JWTAuth::toUser($token);
		if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
        	})->where('id', '=', $user->id)->get()->count()
		) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Unauthoirzed";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		$fullName = request()->fullName;
		$email = request()->email;
		$name = request()->name;
		$password = request()->password;
		$mobileNumber = request()->mobileNumber;

		try {
			$user = User::create([
				'fullName' => $fullName,
				'name' => $name,
				'email' => $email,
				'password' => bcrypt($password),
				'mobileNumber' => $mobileNumber
			]);
		}
		catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = $e->getMessage;
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		$role = \App\Role::where('name', '=', 'Admins')->first();
        $user->roles()->attach($role->id);

        $user->load('roles');

		// generate token
		$token = \JWTAuth::fromUser($user);

		// return response
		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Registered Successfully";
        $resp->Status = true;
        $resp->InnerData = compact('token', 'user');
        return response()->json($resp, 200);
	}
}
