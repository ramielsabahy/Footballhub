<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Feed;

class FootballHubFeedsController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth', ['except' => ['allSuspendedFootballHubFeedsCMS', 'allUnSuspendedFootballHubFeedsCMS', 'destroyFootballHubFeed', 'getFootballHubFeedById', 'allFootballHubFeeds', 'editFootballHubFeed', 'createFootballHubFeed', 'allFootballHubFeedsCMS']]);
    }

    // CMS Method
    // Get all general feeds through API call for CMS
    public function allSuspendedFootballHubFeedsCMS(Request $request)
    {
        $generalFeeds = Feed::where('type', 2)->where('active_status', 0)->orderBy('id', 'desc')->get();
        $generalFeeds->load('user');

        return response()->json($generalFeeds, 200);
    }
    // CMS Method
    // Get all general feeds through API call for CMS
    public function allUnSuspendedFootballHubFeedsCMS(Request $request)
    {
        $generalFeeds = Feed::where('type', 2)->where('active_status', 1)->orderBy('id', 'desc')->get();
        $generalFeeds->load('user');

        return response()->json($generalFeeds, 200);
    }

    // Admins only
    // Create a football hub feed through API call
    public function createFootballHubFeed(Request $request)
    {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        // If the user is not an admin return unauthorized
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', $requestUser->id)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Only admins can create a football hub feed";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        
        $post = new Feed;
        $post->type = 1;
        $post->user_id = $requestUser->id;
        $post->body = $request->body;
        $post->feed_type = $request->feed_type;

        if ($post->feed_type == 1) {
            if ($request->input('thumbnail')) {
                $img = Image::make($request->input('thumbnail'));
                $data = $request->input('thumbnail');
                $type = explode(';', $data)[0];
                $extension = explode('/', $type)[1];
                $filenameToStore = 'thumbnail_'.time().'.'.$extension;
                $img->save(public_path('storage/football_hub_feeds/'.$filenameToStore));
            } else {
                $filenameToStore = '/storage/football_hub_feeds/no_image.jpg';
            }

            $post->thumbnail = '/storage/football_hub_feeds/'.$filenameToStore;
        }

        try {
            $post->save();
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Error occured while storing the football hub feed`";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Football Hub Feed Created Successfully";
        $resp->Status = true;
        $resp->InnerData = $post->load('comments');
        return response()->json($resp, 200);
    }

    // Admins only
    // Edit a football hub feed through API call
    public function editFootballHubFeed(Request $request)
    {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        // If the user is not an admin return unauthorized
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', $requestUser->id)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Only admins can edit a football hub feed";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        try {
            $post = \App\Feed::findOrFail($request->id);
        } catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Football hub feed doesn't exist";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // if the post is not a football hub feed
        if ($post->type != 1) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Football hub feed doesn't exist";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $post->body = empty($request->body) ? $post->body : $request->body;
        $post->feed_type = empty($request->feed_type) ? $post->feed_type : $request->feed_type;

        if ($post->feed_type == 1) {
            if ($request->input('thumbnail')) {
                $img = Image::make($request->input('thumbnail'));
                $data = $request->input('thumbnail');
                $type = explode(';', $data)[0];
                $extension = explode('/', $type)[1];
                $filenameToStore = 'thumbnail_'.time().'.'.$extension;
                $img->save(public_path('storage/football_hub_feeds/'.$filenameToStore));

                // Deleting the previous image
                if ($post->thumbnail != '/storage/football_hub_feeds/no_image.jpg') {
                    \File::delete(public_path().$post->thumbnail);
                }
            } else {
                $filenameToStore = $post->thumbnail;
            }

            $post->thumbnail = '/storage/football_hub_feeds/'.$filenameToStore;
        }

        try {
            $post->save();
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Football hub feed edited successfully";
            $resp->Status = true;
            $resp->InnerData = $post->load('comments');
            return response()->json($resp, 200);
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Error occured while editing the football hub feed";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }
    }

    // Admins, Players and Referees only
    // Get all football hub feeds through API call
    public function allFootballHubFeeds(Request $request)
    {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        $page_size = $request->page_size;
        $current_page = $request->current_page;

        $footballHubFeeds = Feed::where('type', 1)->orderBy('id', 'desc')->skip($page_size*($current_page-1))->take($page_size)->get();
        $footballHubFeeds->load('user');
        $footballHubFeeds->load('comments');

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retrieved Successfully";
        $resp->Status = true;
        $resp->InnerData = $footballHubFeeds;

        return response()->json($resp, 200);
    }
    // CMS Method
    // Get all football hub feeds through API call for CMS
    public function allFootballHubFeedsCMS(Request $request)
    {
        $footballHubFeeds = Feed::where('type', 1)->orderBy('id', 'desc')->get();
        $footballHubFeeds->load('user');

        return response()->json($footballHubFeeds, 200);
    }

    // Authenticated only
    // Get a football hub by id through API call
    public function getFootballHubFeedById(\Illuminate\Support\Facades\Request $request)
    {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        try {
            $footballHubFeed = Feed::findOrFail($request::get('id'));
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Football hub feed doesn't exist";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // If the post is not a football hub feed
        if ($footballHubFeed->type != 1) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Football hub feed doesn't exist";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $footballHubFeed->load('user');
        $footballHubFeed->load('comments');

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retrieved Successfully";
        $resp->Status = true;
        $resp->InnerData = $footballHubFeed;

        return response()->json($resp, 200);
    }

    // Admins only
    // Destroy a football hub feed through API call
    public function destroyFootballHubFeed(\Illuminate\Support\Facades\Request $request)
    {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        // If the user is not an admin return unauthorized
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', $requestUser->id)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Only admins can edit a football hub feed";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // Getting the football hub feed
        try {
            $footballHubFeed = Feed::findOrFail($request::get('id'));
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Football hub feed doesn't exist";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // If the post is not a football hub feed
        if ($footballHubFeed->type != 1) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Football hub feed doesn't exist";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        if ($footballHubFeed->thumbnail != '/storage/football_hub_feeds/no_image.jpg') {
            \File::delete(public_path().$footballHubFeed->thumbnail);
        }

        try {
            $footballHubFeed->delete();
        } catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Error occured while deleting the football hub feed`";
            $resp->Status = false;
            $resp->InnerData = (object)[];

            return response()->json($resp, 200);
        }

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Football hub feed deleted successfully";
        $resp->Status = true;
        $resp->InnerData = (object)[];

        return response()->json($resp, 200);
    }

    public function indexView()
    {
        return view('footballHubFeeds.index');
    }
    public function indexUnsuspendedView()
    {
        return view('footballHubFeeds.indexUnsuspended');
    }

    public function editView($id)
    {
        return view('footballHubFeeds.edit')->with('footballHubFeed', Feed::find($id));
    }

    public function createView()
    {
        return view('footballHubFeeds.create');
    }

    public function showView($id)
    {
        try {
            $feed = Feed::findOrFail($id);
            $users = \App\FeedLike::where('feed_id', $id)->get();
        }
        catch(\Exception $e) {
            return redirect(route('indexFootballHubFeeds'))->with('error', 'Feed Not Found');
        }
        return view('footballHubFeeds.show')->with('feed', $feed)->with('users', $users);
    }
}
