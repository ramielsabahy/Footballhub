<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Feed;
use App\FeedLike;
use App\User;

class LikesController extends Controller
{
    public function __construct() {
        return $this->middleware('auth', ['except' => ['like', 'unlike', 'userLikes', 'likedBy']]);
    }

	// Authenticated only
	// API call to like a feed
    public function like(Request $request) {
		$token = \JWTAuth::getToken();
		$requestUser = \JWTAuth::toUser($token);

    	try {
    		$post = Feed::findOrFail($request->id);
    	} catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Feed Not Found";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
    	}

    	if (FeedLike::where('user_id', $requestUser->id)->where('feed_id', $request->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "User already liked the feed";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
    	}

    	$feedLike = new FeedLike;
    	$feedLike->user_id = $requestUser->id;
    	$feedLike->feed_id = $request->id;

    	try {
    		$feedLike->save();
    	} catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Error occured while liking the feed";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
    	}

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Liked Successfully";
        $resp->Status = true;
        $resp->InnerData = $feedLike;
        return response()->json($resp, 200);
    }

    // Authenticated only
    // API call to unlike a feed
    public function unlike(Request $request) {
		$token = \JWTAuth::getToken();
		$requestUser = \JWTAuth::toUser($token);

    	try {
    		$post = Feed::findOrFail($request->id);
    	} catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Feed Not Found";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
    	}

    	if (!FeedLike::where('user_id', $requestUser->id)->where('feed_id', $request->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "User already doesn't like the post";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
    	}

    	try {
    		$feedLike = FeedLike::where('user_id', $requestUser->id)->where('feed_id', $request->id)->delete();
    	} catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Error occured while unliking the feed";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
    	}

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "User unliked the feed successfully";
        $resp->Status = true;
        $resp->InnerData = (object)[];
        return response()->json($resp, 200);
    }

    // Admin and Owner only
    // API call to return the feeds a user likes
    public function userLikes(Request $request) {
		$token = \JWTAuth::getToken();
		$requestUser = \JWTAuth::toUser($token);

		try {
			$user = User::find($request->id);
		} catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "User Not Found";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		if ($requestUser->id != $request->id && \App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
        	})->where('id', '=', $requestUser->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Unauthorized";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = FeedLike::where('user_id', $request->id)->get();
        return response()->json($resp, 200);
    }

    // Authenticated users only
    // API call to return the users who likes a feed
    public function likedBy(Request $request) {
		$token = \JWTAuth::getToken();
		$requestUser = \JWTAuth::toUser($token);

		try {
			$feed = Feed::find($request->id);
		} catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Feed Not Found";
	        $resp->Status = false;
	        $resp->InnerData = [];
	        return response()->json($resp, 200);
		}

		// if (($requestUser->id != $request->id) && (!\App\User::whereHas('roles', function ($query) {
  //           $query->where('name', '=', 'Admins');
  //       	})->where('id', '=', $requestUser->id)->get()->count())) {
		// 	$resp = new \App\Http\Helpers\ServiceResponse;
	 //        $resp->Message = "Unauthorized";
	 //        $resp->Status = false;
	 //        $resp->InnerData = [];
	 //        return response()->json($resp, 200);
		// }

		$feed_likes = FeedLike::where('feed_id', $request->id)->get();
		$users = collect([]);
		foreach($feed_likes as $feed_like) {
			$feed_like->load('user');
			if ($feed_like->user->active_status) {
				$users->push($feed_like->user);
			}
		}
		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = $users;
        return response()->json($resp, 200);
    }
}
