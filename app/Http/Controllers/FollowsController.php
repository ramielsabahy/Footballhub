<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Follow;

class FollowsController extends Controller
{
  // Owner Method
  // Creating the follow relationship
    public function follow(Request $request) {
      // Getting the request user
    $token = \JWTAuth::getToken();
    $requestUser = \JWTAuth::toUser($token);

      $follower = $requestUser->id;
      $following = request()->following_id;

      // Check if the follower and the following ids are of players
      if (!\App\User::whereHas('roles', function($query) {
        $query->where('name', '=', 'Players');  
      })->where('id', '=', $follower)->get()->count()) {
          $resp = new \App\Http\Helpers\ServiceResponse;
          $resp->Message = "Provide a follower_id of a playre";
          $resp->Status = false;
          $resp->InnerData = (object)[];
          return response()->json($resp, 200);
      }
      if (!\App\User::whereHas('roles', function($query) {
        $query->where('name', '=', 'Players');  
      })->where('id', '=', $following)->get()->count()) {
          $resp = new \App\Http\Helpers\ServiceResponse;
          $resp->Message = "Provide a following_id of a player";
          $resp->Status = false;
          $resp->InnerData = (object)[];
          return response()->json($resp, 200);
      }

      // Check if the request user is the follower
    if ($requestUser->id != $follower) {
          $resp = new \App\Http\Helpers\ServiceResponse;
          $resp->Message = "Unauthoirzed";
          $resp->Status = false;
          $resp->InnerData = (object)[];
          return response()->json($resp, 200);
    }

      // Check if the user is trying to follow himself
      if ($follower == $following) {
          $resp = new \App\Http\Helpers\ServiceResponse;
          $resp->Message = "Player can\'t follow himself";
          $resp->Status = false;
          $resp->InnerData = (object)[];
          return response()->json($resp, 200);
      }

      // Check if the relation already exists
      if (Follow::where('follower', '=', $follower)->where('following', '=', $following)->get()->count()) {
          $resp = new \App\Http\Helpers\ServiceResponse;
          $resp->Message = "Follow relation already exists";
          $resp->Status = false;
          $resp->InnerData = (object)[];
          return response()->json($resp, 200);
      }

      // Creating the new follow relationship
      $rel = new Follow;
      $rel->follower = $follower;
      $rel->following = $following;

      try {
        $rel->save();
      }
      catch(\Exception $e) {
          $resp = new \App\Http\Helpers\ServiceResponse;
          $resp->Message = $e->getMessage();
          $resp->Status = false;
          $resp->InnerData = (object)[];
          return response()->json($resp, 200);
      }

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Follow relation created successfully";
        $resp->Status = true;
        $resp->InnerData = $rel;
        return response()->json($resp, 200);
    }

    // Owner Method
    // Destroy the follow relationship
    public function unFollow(Request $request) {
      // Getting the request user
    $token = \JWTAuth::getToken();
    $requestUser = \JWTAuth::toUser($token);

      $follower = $requestUser->id;
      $following = request()->following_id;

      // Check if the follower and the following ids are of players
      if (!\App\User::whereHas('roles', function($query) {
        $query->where('name', '=', 'Players');  
      })->where('id', '=', $follower)->get()->count()) {
          $resp = new \App\Http\Helpers\ServiceResponse;
          $resp->Message = "Provide a follower_id of a player";
          $resp->Status = false;
          $resp->InnerData = (object)[];
          return response()->json($resp, 200);
      }
      if (!\App\User::whereHas('roles', function($query) {
        $query->where('name', '=', 'Players');  
      })->where('id', '=', $following)->get()->count()) {
          $resp = new \App\Http\Helpers\ServiceResponse;
          $resp->Message = "Provide a following_id of a player";
          $resp->Status = false;
          $resp->InnerData = (object)[];
          return response()->json($resp, 200);
      }

      // Check if the request user is the follower
    if ($requestUser->id != $follower) {
          $resp = new \App\Http\Helpers\ServiceResponse;
          $resp->Message = "Unauthorized";
          $resp->Status = false;
          $resp->InnerData = (object)[];
          return response()->json($resp, 200);
    }

      // Check if the user is trying to unFollow himself
      if ($follower == $following) {
          $resp = new \App\Http\Helpers\ServiceResponse;
          $resp->Message = "Player can\'t unfollow himself";
          $resp->Status = false;
          $resp->InnerData = (object)[];
          return response()->json($resp, 200);
      }

      // Check if the relation already exists
      if (Follow::where('follower', '=', $follower)->where('following', '=', $following)->get()->count()) {
        try {
          $rel = Follow::where('follower', '=', $follower)->where('following', '=', $following)->delete();
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = $e->getMessage();
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

          $resp = new \App\Http\Helpers\ServiceResponse;
          $resp->Message = "Success";
          $resp->Status = true;
          $resp->InnerData = '';
          return response()->json($resp, 200);
      }
      else {
          $resp = new \App\Http\Helpers\ServiceResponse;
          $resp->Message = "Follow relation destroyed successfully";
          $resp->Status = true;
          $resp->InnerData = (object)[];
          return response()->json($resp, 200);
      }
    }

  //   // Admin or Owner Method
  //   // List all the players that some player follow
  //   public function following(Request $request) {
  //    // Getting the request user
    // $token = \JWTAuth::getToken();
    // $requestUser = \JWTAuth::toUser($token);

    // $follower = request()->follower_id;

  //    // Check if the request user is the follower or he is an admin
    // if ($requestUser->id != $follower && !\App\User::whereHas('roles', function ($query) {
  //           $query->where('name', '=', 'Admins');
  //        })->where('id', '=', $requestUser->id)->get()->count()) {
   //        $resp = new \App\Http\Helpers\ServiceResponse;
   //        $resp->Message = "Unauthorized";
   //        $resp->Status = false;
   //        $resp->InnerData = (object)[];
   //        return response()->json($resp, 200);
    // }

  //    $players = Follow::where('follower', '=', $follower)->get();
  //       $resp = new \App\Http\Helpers\ServiceResponse;
  //       $resp->Message = "Retrieved Successfully";
  //       $resp->Status = true;
  //       $resp->InnerData = $players;
  //       return response()->json($resp, 200); 
  //   }

    // Owner Method
    // List all the players that some player follow
    public function following(Request $request) {
      // Getting the request user
    $token = \JWTAuth::getToken();
    $requestUser = \JWTAuth::toUser($token);

    $follower = $requestUser->id;

      // Check if the request user is the follower or he is an admin
    if ($requestUser->id != $follower) {
          $resp = new \App\Http\Helpers\ServiceResponse;
          $resp->Message = "Unauthorized";
          $resp->Status = false;
          $resp->InnerData = (object)[];
          return response()->json($resp, 200);
    }

      $players = collect([]);
      $followings = Follow::where('follower', '=', $follower)->get();
      foreach ($followings as $object) {
        $object->load('following');
        $players->push($object);
      }

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retrieved Successfully";
        $resp->Status = true;
        $resp->InnerData = $players;
        return response()->json($resp, 200);  
    }

  //   // Admin or Owner Method
  //   // List all the players that follow some player
  //   public function followers(Request $request) {
  //    // Getting the request user
    // $token = \JWTAuth::getToken();
    // $requestUser = \JWTAuth::toUser($token);

    // $following = request()->following_id;

  //    // Check if the request user is the following or he is an admin
    // if ($requestUser->id != $following && !\App\User::whereHas('roles', function ($query) {
  //           $query->where('name', '=', 'Admins');
  //        })->where('id', '=', $requestUser->id)->get()->count()) {
   //        $resp = new \App\Http\Helpers\ServiceResponse;
   //        $resp->Message = "Unauthorized";
   //        $resp->Status = false;
   //        $resp->InnerData = (object)[];
   //        return response()->json($resp, 200);
    // }

  //    $players = Follow::where('following', '=', $following)->get();
  //       $resp = new \App\Http\Helpers\ServiceResponse;
  //       $resp->Message = "Retrieved Successfully";
  //       $resp->Status = true;
  //       $resp->InnerData = $players;
  //       return response()->json($resp, 200);
  //   }

    // Owner Method
    // List all the players that follow some player
    public function followers(Request $request) {
      // Getting the request user
    $token = \JWTAuth::getToken();
    $requestUser = \JWTAuth::toUser($token);

    $following = $requestUser->id;

      // Check if the request user is the following or he is an admin
    if ($requestUser->id != $following) {
          $resp = new \App\Http\Helpers\ServiceResponse;
          $resp->Message = "Unauthorized";
          $resp->Status = false;
          $resp->InnerData = (object)[];
          return response()->json($resp, 200);
    }

      $players = collect([]);
      $followers = Follow::where('following', '=', $following)->get();
      foreach ($followers as $object) {
        $object->load('follower');
        $players->push($object);
      }
        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retrieved Successfully";
        $resp->Status = true;
        $resp->InnerData = $players;
        return response()->json($resp, 200);
    }
}
