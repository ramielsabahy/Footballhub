<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\User;

class UsersController extends Controller
{
    public function __construct() {
        return $this->middleware('auth', ['except' => ['createUser', 'createAdmin', 'editUser', 'editAdmin', 'allSuspendedAdmins', 'allUnSuspendedAdmins', 'getUserById', 'getAdminById', 'suspendUser', 'UnSuspendUser', 'suspendAdmin', 'unSuspendAdmin', 'allSuspendedUsersDT', 'allUnSuspendedUsersDT', 'getUsersByFullname', 'allSuspendedAdminsDT', 'allUnSuspendedAdminsDT', 'createAdminCMS', 'createUserCMS']]);
    }

   // Create a user through API call
   public function createUser(Request $request)
   {
        $fullName = request()->fullName;
        $email = request()->email;
        // checking the email is not used before
        if (\App\User::where('email', $email)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Email is used by another user";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }
        $name = request()->name;
        $password = request()->password;
        $mobileNumber = request()->mobileNumber;
        $facebook_id = request()->facebook_id;
        if (\App\User::where('facebook_id', $facebook_id)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "You already have an account, login to your account.";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }
        $facebook_token = request()->facebook_token;
        $user_type = request()->user_type;

        try {
            $user = User::create([
                'fullName' => $fullName,
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
                'mobileNumber' => $mobileNumber,
                'facebook_id' => $facebook_id,
                'facebook_token' => $facebook_token
            ]);
            $friendlyScore = new \App\FriendlyScore;
            $friendlyScore->player_id = $user->id;
            $friendlyScore->save();
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = $e->getMessage();
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $role = \App\Role::where('name', '=', 'Players')->first();
        $user->roles()->attach($role->id);
        $role = \App\Role::where('name', '=', 'Referees')->first();
        $user->roles()->attach($role->id);

        $user->load('roles');
        // if ($user_type == 1) {
        //     // Player profile
        // } else if ($user_type == 2) {
        //     // Referee profile
        // }

        // generate token
        $token = \JWTAuth::fromUser($user);

        // return response
        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "User Created Successfully";
        $resp->Status = true;
        $resp->InnerData = compact('token', 'user');
        return response()->json($resp, 200);
   }

  

   // Admin only can create other admins
   // Create an admin through API call
   public function createAdmin(Request $request)
   {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        // If the user is not an admin return unauthorized
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', $requestUser->id)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $fullName = request()->fullName;
        $email = request()->email;
        // checking the email is not used before
        if (\App\User::where('email', $email)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Email is used by another user";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }
        $name = request()->name;
        $password = request()->password;
        $mobileNumber = request()->mobileNumber;

        try {
            $user = User::create([
                'fullName' => $fullName,
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
                'mobileNumber' => $mobileNumber,
                'user_photo' => '/storage/profile_images/'.'no_image.jpg'
            ]);
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = $e->getMessage();
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $role = \App\Role::where('name', '=', 'Admins')->first();
        $user->roles()->attach($role->id);

        // generate token
        $token = \JWTAuth::fromUser($user);

        $user->load('roles');

        // return response
        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Admin Created Successfully";
        $resp->Status = true;
        $resp->InnerData = compact('token', 'user');
        return response()->json($resp, 200);
   }

    // Owner Method
    // Edit a user through API call
    public function editUser(\Illuminate\Support\Facades\Request $request)
    {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        // If the player doesn't exist return failure
        try {
            $user = \App\User::findOrFail(intval($request::get('id')));
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "User Not Found";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // If the player is not editing his own account return unauthorized
        if ($request::get('id') != $requestUser->id) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // Getting the data from the request
        $fullName = $request::get('fullName');
        $email = $request::get('email');
        // checking the email is not used before
        if (\App\User::where('email', $email)->where('id', '!=', $request::get('id'))->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Email is used by another user";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }
        $name = $request::get('name');
        $password = $request::get('password');
        $mobileNumber = $request::get('mobileNumber');
        $location = $request::get('location');
        $favourite_club = $request::get('favourite_club');
        $user_photo = $request::get('user_photo');
        $date_of_birth = $request::get('date_of_birth');
        $height = $request::get('height');
        $weight = $request::get('weight');

        if ($user_photo) {
            // Uploaded photo
            $img = Image::make($user_photo);
            $data = $user_photo;
            $type = explode(';', $data)[0];
            $extension = explode('/', $type)[1];
            $filenameToStore = 'profile_image_'.time().'.'.$extension;
            $img->save(public_path('storage/profile_images/'.$filenameToStore));
            // Check if there exist a previous photo
            if ($user->user_photo != '/storage/profile_images/no_image.jpg') {
                Storage::delete('storage/profile_images/'.$user->user_photo);
                \File::delete(public_path().$user->user_photo);
            }
            $user->user_photo = '/storage/profile_images/'.$filenameToStore;
        }

        // Editing the data
        $user->fullName = empty($fullName) ? $user->fullName : $fullName;
        $user->email = empty($email) ? $user->email : $email;
        $user->name = empty($name) ? $user->name : $name;
        $user->password = empty($password) ? $user->password : bcrypt($password);
        $user->mobileNumber = empty($mobileNumber) ? $user->mobileNumber : $mobileNumber;
        $location = empty($location) ? $user->location : $location;
        $favourite_club = empty($favourite_club) ? $user->favourite_club : $favourite_club;
        $date_of_birth = empty($date_of_birth) ? $user->date_of_birth : $date_of_birth;
        $height = empty($height) ? $user->height : $height;
        $weight = empty($weight) ? $user->weight : $weight;

        try {
            $user->save();
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = $e->getMessage();
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $user->load('roles');
        // if ($request::get('user_type') == 1) {
        //     // Player profile
        // } else if ($request::get('user_type') == 2) {
        //     // Referee profile
        // }

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "User Edited Successfully";
        $resp->Status = true;
        $resp->InnerData = $user;
        return response()->json($resp, 200);
    }

   // Admin only can edit other admins
   // Edit an admin through API call
    public function editAdmin(\Illuminate\Support\Facades\Request $request)
    {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        // If the admin doesn't exist return failure
        try {
            $user = \App\User::findOrFail(intval($request::get('id')));
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Admin Not Found";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // If the user is not an admin return unauthorized
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', $requestUser->id)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthoirzed";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // Getting the data from the request
        $fullName = $request::get('fullName');
        $email = $request::get('email');
        // checking the email is not used before
        if (\App\User::where('email', $email)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Email is used by another user";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }
        $name = $request::get('name');
        $password = $request::get('password');
        $mobileNumber = $request::get('mobileNumber');
        $location = $request::get('location');
        $user_photo = $request::get('user_photo');

        if ($user_photo) {
            // Uploaded photo
            $img = Image::make($user_photo);
            $data = $user_photo;
            $type = explode(';', $data)[0];
            $extension = explode('/', $type)[1];
            $filenameToStore = 'profile_image_'.time().'.'.$extension;
            $img->save(public_path('storage/profile_images/'.$filenameToStore));
            // Check if there exist a previous photo
            if ($user->user_photo != '/storage/profile_images/no_image.jpg') {
                Storage::delete('storage/profile_images/'.$user->user_photo);
                \File::delete(public_path().$user->user_photo);
            }
            $user->user_photo = '/storage/profile_images/'.$filenameToStore;
        }

        // Editing the data
        $user->fullName = empty($fullName) ? $user->fullName : $fullName;
        $user->email = empty($email) ? $user->email : $email;
        $user->name = empty($name) ? $user->name : $name;
        $user->password = empty($password) ? $user->password : bcrypt($password);
        $user->mobileNumber = empty($mobileNumber) ? $user->mobileNumber : $mobileNumber;
        $user->location = empty($location) ? $user->location : $location;

        try {
            $user->save();
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = $e->getMessage();
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $user->load('roles');

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Admin Edited Successfully";
        $resp->Status = true;
        $resp->InnerData = $user;
        return response()->json($resp, 200);
    }

    // Authenticated Method
    // Getting all the unsuspended users
    public function allUnSuspendedUsers(\Illuminate\Http\Request $request)
    {
        // Check that the user making the request is an admin
        $token = \JWTAuth::getToken();
        $user = \JWTAuth::toUser($token);
        // if (!\App\User::whereHas('roles', function ($query) {
        //     $query->where('name', '=', 'Admins');
        //     })->where('id', '=', $user->id)->get()->count()
        // ) {
        //     $resp = new \App\Http\Helpers\ServiceResponse;
        //     $resp->Message = "Unauthorized";
        //     $resp->Status = false;
        //     $resp->InnerData = (object)[];
        //     return response()->json($resp, 200);
        // }

        $data = \App\User::where('active_status', '=', 1)->whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players')->orWhere('name', '=', 'Referees');
        })->with('roles')->get();
        $data->load('roles');

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = $data;

        return response()->json($resp, 200);
    }

    // Admin Method
    // Getting all the suspended admins
    public function allSuspendedAdmins(\Illuminate\Http\Request $request)
    {
        // Check that the user making the request is an admin
        $token = \JWTAuth::getToken();
        $user = \JWTAuth::toUser($token);
        if (!\App\User::where('active_status', '=', 0)->whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', $user->id)->get()->count()
        ) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $data = \App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
        })->with('roles')->get();
        $data->load('roles');

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = $data;

        return response()->json($resp, 200);
    }

    // Admin Method
    // Getting all the unsuspended admins
    public function allUnSuspendedAdmins(\Illuminate\Http\Request $request)
    {
        // Check that the user making the request is an admin
        $token = \JWTAuth::getToken();
        $user = \JWTAuth::toUser($token);
        if (!\App\User::where('active_status', '=', 1)->whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', $user->id)->get()->count()
        ) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $data = \App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
        })->with('roles')->get();
        $data->load('roles');

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = $data;

        return response()->json($resp, 200);
    }

    // Get users by fullName
    public function getUsersByFullname(\Illuminate\Support\Facades\Request $request)
    {
        $data = \App\User::where('active_status', '=', 1)->whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players')->orWhere('name', '=', 'Referees');
        })->where('fullName', 'like', $request::get('fullName').'%')->with('roles')->get();
        if (!$data->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "No Users Exist With This Name";
            $resp->Status = false;
            $resp->InnerData = [];
            return response()->json($resp, 200);
        }

        $data->load('roles');

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Users Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = $data;
        return response()->json($resp, 200);
    }

    // Get a user by id
    public function getUserById(\Illuminate\Support\Facades\Request $request)
    {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        try {
            $data = \App\User::where('active_status', '=', 1)->whereHas('roles', function ($query) {
                $query->where('name', '=', 'Players')->orWhere('name', '=', 'Referees');
            })->where('id', '=', $request::get('id'))->with('roles')->get()->first();
        } catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "User Not Found";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }
        
        if (!$data->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "User Not Found";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $data->load('roles');
        $data->load('friendlyScore');
        $data->load('ownedTeams');
        $data->load('memberTeams');
        $data->load('friendlyMatches');
        $data->load('friendlyJoinedMatches');
        $data->isMyProfile = ($requestUser->id == $request::get('id')) ? true : false;
        $data->isFollow = (\App\Follow::where('follower', '=', $requestUser->id)->where('following', '=', $data->id)->get()->count()) ? true : false;

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "User Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = $data;
        return response()->json($resp, 200);
    }

    // Admin Method
    // Get an admin by id
    public function getAdminById(\Illuminate\Support\Facades\Request $request)
    {
        // Check that the user making the request is an admin
        $token = \JWTAuth::getToken();
        $user = \JWTAuth::toUser($token);
        if (!\App\User::where('active_status', '=', 1)->whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', $user->id)->get()->count()
        ) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $data = \App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
        })->where('id', '=', $request::get('id'))->with('roles')->get();
        
        if (!$data->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Admin Not Found";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $data->load('roles');

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Admin Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = $data;
        return response()->json($resp, 200);
    }

    // Admin or Owner Method
    // Suspending a user
    public function suspendUser(\Illuminate\Support\Facades\Request $request) 
    {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        try {
            $user = \App\User::findOrFail($request::get('id'));
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = 'User Not Found';
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // If the user is not an admin and the player is not destroying his own account return unauthorized
        if ($request::get('id') != $requestUser->id && !\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', $requestUser->id)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // Suspending the user
        try {
            // // Delete the User with his invitations
            // \App\Invitation::where('player_id', '=', $request::get('id'))->delete();
        	// $user->destroy($request::get('id'));
            $user->active_status = 0;
            $user->load('feeds');
            $user->load('comments');
            $user->load('likes');
            $user->load('ownedTeams');
            $user->load('memberTeams');
            foreach($user->feeds as $feed) {
                $feed->active_status = 0;
                $feed->save();
            }
            foreach($user->comments as $comment) {
                $comment->feed_status = 0;
                $comment->save();
            }
            foreach($user->likes as $like) {
                $like->active_status = 0;
                $like->save();
            }
            foreach($user->ownedTeams as $team) {
                $team->active_status = 0;
                $team->save();
            }
            foreach($user->memberTeams as $team) {
                $team->active_status = 0;
                $team->save();
            }
            $user->save(); 
    	}
    	catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = $e->getMessage();
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "User Suspended Successfully";
        $resp->Status = true;
        $resp->InnerData = $user;
        return response()->json($resp, 200);
    }

    // Admin Method
    // Unsuspending a user
    public function unSuspendUser(\Illuminate\Support\Facades\Request $request) 
    {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        try {
            $user = \App\User::findOrFail($request::get('id'));
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = 'User Not Found';
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // If the user is not an admin and the player is not destroying his own account return unauthorized
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', $requestUser->id)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // Suspending the user
        try {
            // // Delete the User with his invitations
            // \App\Invitation::where('player_id', '=', $request::get('id'))->delete();
            // $user->destroy($request::get('id'));
            $user->active_status = 1;
            $user->load('feeds');
            $user->load('comments');
            $user->load('likes');
            $user->load('ownedTeams');
            $user->load('memberTeams');
            foreach($user->feeds as $feed) {
                $feed->active_status = 1;
                $feed->save();
            }
            foreach($user->comments as $comment) {
                $comment->feed_status = 1;
                $comment->save();
            }
            foreach($user->likes as $like) {
                $like->active_status = 1;
                $like->save();
            }
            foreach($user->ownedTeams as $team) {
                $team->active_status = 1;
                $team->save();
            }
            foreach($user->memberTeams as $team) {
                $team->active_status = 1;
                $team->save();
            }
            $user->save(); 
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = $e->getMessage();
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "User Unsuspended Successfully";
        $resp->Status = true;
        $resp->InnerData = $user;
        return response()->json($resp, 200);
    }

    // Admin Method
    // Suspending an admin
    public function suspendAdmin(\Illuminate\Support\Facades\Request $request) 
    {
        // Check that the user making the request is an admin
        $token = \JWTAuth::getToken();
        $user = \JWTAuth::toUser($token);

        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', $user->id)->get()->count()
        ) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        try {
            $user = \App\User::findOrFail($request::get('id'));
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = 'Admin Not Found';
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // Suspend the Admin
        try {
            // $user->destroy($request::get('id'));
            $user->active_status = 0;
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = $e->getMessage();
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Admin Suspended Successfully";
        $resp->Status = true;
        $resp->InnerData = (object)[];
        return response()->json($resp, 200);
    }

    // Admin Method
    // UnSuspending an admin
    public function unSuspendAdmin(\Illuminate\Support\Facades\Request $request) 
    {
        // Check that the user making the request is an admin
        $token = \JWTAuth::getToken();
        $user = \JWTAuth::toUser($token);

        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', $user->id)->get()->count()
        ) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        try {
            $user = \App\User::findOrFail($request::get('id'));
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = 'Admin Not Found';
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // unSuspend the Admin
        try {
            // $user->destroy($request::get('id'));
            $user->active_status = 1;
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = $e->getMessage();
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Admin UnSuspended Successfully";
        $resp->Status = true;
        $resp->InnerData = (object)[];
        return response()->json($resp, 200);
    }

    // Authenticated Method
    // Getting all the suspended users
    public function allSuspendedUsers(\Illuminate\Http\Request $request)
    {
        // Check that the user making the request is an admin
        $token = \JWTAuth::getToken();
        $user = \JWTAuth::toUser($token);

        $data = \App\User::where('active_status', '=', 0)->whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players')->orWhere('name', '=', 'Referees');
        })->with('roles')->get();
        $data->load('roles');

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = $data;

        return response()->json($resp, 200);
    }

    // Admin only can view
    // Create User View
    public function createUserView()
    {
        return view('users.userCreate');
    }

    // Admin only can view
    // Create Admin View
    public function createAdminView()
    {
        return view('users.adminCreate');
    }

    // CMS Method
   // Create an admin through API call for CMS
   public function createAdminCMS(Request $request)
   {
        // Check that the user is an admin
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', request()->user_id)->get()->count()
        ) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $fullName = request()->fullName;
        $email = request()->email;
        // checking the email is not used before
        if (\App\User::where('email', $email)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Email is used by another user";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }
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
            $resp->Message = $e->getMessage();
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $role = \App\Role::where('name', '=', 'Admins')->first();
        $user->roles()->attach($role->id);

        // generate token
        $token = \JWTAuth::fromUser($user);

        // return response
        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Admin Created Successfully";
        $resp->Status = true;
        $resp->InnerData = $user;
        return response()->json($resp, 200);
   }

    // Admin only can edit other users
    // User edit view
    public function editUserView($id)
    {
        return view('users.userEdit')->with('user', User::find($id));
    }

    public function editUserCMS(\Illuminate\Support\Facades\Request $request)
    {
        // Check that the user is an admin
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', $request::get('user_id'))->get()->count()
        ) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // If the player doesn't exist return failure
        try {
            $user = \App\User::findOrFail(intval($request::get('id')));
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Player Not Found";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // Getting the data from the request
        $fullName = $request::get('fullName');
        $email = $request::get('email');
        // checking the email is not used before
        if (\App\User::where('email', $email)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Email is used by another user";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }
        $name = $request::get('name');
        $password = $request::get('password');
        $mobileNumber = $request::get('mobileNumber');

        // Editing the data
        $user->fullName = empty($fullName) ? $user->fullName : $fullName;
        $user->email = empty($email) ? $user->email : $email;
        $user->name = empty($name) ? $user->name : $name;
        $user->password = empty($password) ? $user->password : bcrypt($password);
        $user->mobileNumber = empty($mobileNumber) ? $user->mobileNumber : $mobileNumber;

        try {
            $user->save();
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = $e->getMessage();
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Player Edited Successfully";
        $resp->Status = true;
        $resp->InnerData = $user;
        return response()->json($resp, 200);
    }

    // Admin only can edit other admins
    // Admin edit view
    public function editAdminView($id)
    {
        return view('users.adminEdit')->with('user', User::find($id));
    }

    // All Suspended Users View
    public function allSuspendedUsersView() {
        return view('users.suspendedUsersIndex');
    }
    public function allSuspendedUsersDT(){
        $data = \App\User::whereHas('roles', function ($query) {
            $query->whereNotIn('name', ['Admins']);
        })->where('active_status',0)->with('roles')->get();
        $data->load('roles');
        return response()->json($data, 200);
    }

    // All UnSuspended Users View
    public function allUnsuspendedUsersView() {
        return view('users.unSuspendedUsersIndex');
    }

    public function allUnSuspendedUsersDT(){
        $data = \App\User::whereHas('roles', function ($query) {
            $query->whereNotIn('name', ['Admins']);
        })->where('active_status',1)->with('roles')->get();
        $data->load('roles');
        return response()->json($data, 200);
    }

    // All Suspended Admins View
    public function allSuspendedAdminsView() {
        return view('users.suspendedAdminsIndex');
    }
    public function allSuspendedAdminsDT(){
        $data = \App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
        })->where('active_status',0)->with('roles')->get();
        $data->load('roles');
        return response()->json($data, 200);
    }

    // All UnSuspended Admins View
    public function allUnSuspendedAdminsView() {
        return view('users.unSuspendedAdminsIndex');
    }

    public function allUnSuspendedAdminsDT(){
        $data = \App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
        })->where('active_status',1)->with('roles')->get();
        $data->load('roles');
        return response()->json($data, 200);
    }

     // CMS Method
   // Create a player through API call for CMS
   public function createUserCMS(Request $request)
   {
        // Check that the user is an admin
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', request()->user_id)->get()->count()
        ) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $fullName = request()->fullName;
        $email = request()->email;
        // checking the email is not used before
        if (\App\User::where('email', $email)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Email is used by another user";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }
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
            $friendlyScore = new \App\FriendlyScore;
            $friendlyScore->player_id = $user->id;
            $friendlyScore->save();
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = $e->getMessage();
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $role = \App\Role::where('name', '=', 'Players')->first();
        $user->roles()->attach($role->id);

        // generate token
        $token = \JWTAuth::fromUser($user);

        // return response
        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Player Created Successfully";
        $resp->Status = true;
        $resp->InnerData = $user;
        return response()->json($resp, 200);
   }
}
