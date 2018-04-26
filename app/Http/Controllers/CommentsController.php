<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Feed;
use App\UserFeedComment;

class CommentsController extends Controller
{
    public function __construct() {
        return $this->middleware('auth', ['except' => ['feedComments', 'commentOnFeed', 'editComment', 'hideComment', 'unHideComment', 'destroyComment']]);
    }

    // Authenticated only
    // Get all the comments of a feed through API call
    public function feedComments(Request $request)
    {
    	// Getting the feed if it does exist
    	try {
    		$feed = Feed::findOrFail($request->id);

    	} catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Feed doesn\'t exist";
	        $resp->Status = false;
	        $resp->InnerData = [];
	        return response()->json($resp, 200);
    	}

        if (!$feed->active_status) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Feed doesn\'t exist, the feed has been deleted";
            $resp->Status = false;
            $resp->InnerData = [];
            return response()->json($resp, 200);
        }

        $feed->load('comments');

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retrived Successfully";
        $resp->Status = true;
        $resp->InnerData = $feed->comments;
        return response()->json($resp, 200);
    }

    // Authenticated only
    // Comment on a feed
    public function commentOnFeed(Request $request)
    {
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        // Getting the feed if it does exist
        try {
            $feed = Feed::findOrFail($request->feed_id);

        } catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Feed doesn\'t exist";
            $resp->Status = false;
            $resp->InnerData = [];
            return response()->json($resp, 200);
        }

        if (!$feed->active_status) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Feed doesn\'t exist, the feed has been deleted";
            $resp->Status = false;
            $resp->InnerData = [];
            return response()->json($resp, 200);
        }

        $comment = new UserFeedComment;
        $comment_body = $request->comment;
        $comment_user = $requestUser->id;
        $comment_feed = $request->feed_id;

        // Comment can't be empty
        if (empty($comment_body)) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Comment can\'t be empty";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $comment->comment = $comment_body;
        $comment->feed_id = $comment_feed;
        $comment->user_id = $comment_user;

        try {
            $comment->save();
        } catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Error occured while storing the comment";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $comment->load('user');
        $comment->load('feed');

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Comment Saved Successfully";
        $resp->Status = true;
        $resp->InnerData = $comment;
        return response()->json($resp, 200);
    }

    // Owner only
    // edit a comment on a feed
    public function editComment(Request $request)
    {
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        // Getting the comment
        try {
            $comment = UserFeedComment::findOrFail($request->id);
        } catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Comment not found";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // The owner is not the request user
        if ($requestUser->id != $comment->user_id) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $comment->comment = empty($request->comment) ? $comment->comment : $request->comment;

        try {
            $comment->save();
        } catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Error occured while editing the comment";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $comment->load('user');
        $comment->load('feed');

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Comment Edited Successfully";
        $resp->Status = true;
        $resp->InnerData = $comment;
        return response()->json($resp, 200);
    }

    // Admin, Feed Owner and Owner only
    // hide a comment on a feed
    public function hideComment(Request $request)
    {
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        // Getting the comment
        try {
            $comment = UserFeedComment::findOrFail($request->id);
        } catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Comment not found";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // Check if the request user is the admin or the feed owner or the owner
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', $requestUser->id)->get()->count()
            && !$requestUser->id == $comment->id && !$requestUser->id == $comment->feed->id) {
            // return unauthorized
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // Hiding the comment
        try {
            $comment->active_status = 0;
            $comment->save();
        } catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Error occured while deleting the comment";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Comment Deleted Successfully";
        $resp->Status = true;
        $resp->InnerData = (object)[];
        return response()->json($resp, 200);
    }

    // Admin only
    // unHide a comment on a feed
    public function unHideComment(Request $request)
    {
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        // Getting the comment
        try {
            $comment = UserFeedComment::findOrFail($request->id);
        } catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Comment not found";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // Check if the request user is the admin or the feed owner or the owner
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', $requestUser->id)->get()->count()) {
            // return unauthorized
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // Un-hiding the comment
        try {
            $comment->active_status = 1;
            $comment->save();
        } catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Error occured while restoring the comment";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Comment Restored Successfully";
        $resp->Status = true;
        $resp->InnerData = (object)[];
        return response()->json($resp, 200);
    }

    // Admin only
    // delete a comment on a feed
    public function destroyComment(Request $request)
    {
		$token = \JWTAuth::getToken();
		$requestUser = \JWTAuth::toUser($token);

		// Getting the comment
		try {
			$comment = UserFeedComment::findOrFail($request->id);
		} catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
			$resp->Message = "Comment not found";
			$resp->Status = false;
			$resp->InnerData = (object)[];
			return response()->json($resp, 200);
		}

        // Check if the request user is the admin or the feed owner or the owner
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', $requestUser->id)->get()->count()) {
            // return unauthorized
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // Destroying the comment
        try {
            $comment->delete();
        } catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Error occured while deleting the comment";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Comment Deleted Successfully";
        $resp->Status = true;
        $resp->InnerData = (object)[];
        return response()->json($resp, 200);
    }
}
