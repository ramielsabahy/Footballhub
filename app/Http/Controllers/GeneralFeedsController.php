<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Feed;
use App\User;
use App\FeedLike;

class GeneralFeedsController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth', ['except' => ['allSuspendedGeneralFeedsCMS', 'allUnSuspendedGeneralFeedsCMS', 'userGeneralFeeds', 'destroyGeneralFeed', 'getGeneralFeedById', 'allActiveGeneralFeeds', 'allInActiveGeneralFeeds', 'editGeneralFeed', 'createGeneralFeed', 'hideGeneralFeed']]);
    }


    // CMS Method
    // Get all general feeds through API call for CMS
    public function allSuspendedGeneralFeedsCMS(Request $request)
    {
        $generalFeeds = Feed::where('type', 1)->where('active_status', 0)->orderBy('id', 'desc')->get();
        $generalFeeds->load('user');

        return response()->json($generalFeeds, 200);
    }
    // CMS Method
    // Get all general feeds through API call for CMS
    public function allUnSuspendedGeneralFeedsCMS(Request $request)
    {
        $generalFeeds = Feed::where('type', 1)->where('active_status', 1)->orderBy('id', 'desc')->get();
        $generalFeeds->load('user');

        return response()->json($generalFeeds, 200);
    }

    // Players and Referees only
    // Create a general feed through API call
    public function createGeneralFeed(Request $request)
    {
        try {
            // Getting the request user
            $token = \JWTAuth::getToken();
            $requestUser = \JWTAuth::toUser($token);

            // If the user is not a player return unauthorized
            if (!\App\User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Players');
                })->where('id', '=', $requestUser->id)->get()->count() &&
                !\App\User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Referees');
                })->where('id', '=', $requestUser->id)->get()->count()) {
                $resp = new \App\Http\Helpers\ServiceResponse;
                $resp->Message = "Only players and referees can create a general feed";
                $resp->Status = false;
                $resp->InnerData = (object)[];
                return response()->json($resp, 200);
            }

            
            $post = new Feed;
            $post->type = 2;
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
                    $img->save(public_path('storage/general_feeds/'.$filenameToStore));
                } else {
                    $filenameToStore = '/storage/general_feeds/no_image.jpg';
                }

                $post->thumbnail = '/storage/general_feeds/'.$filenameToStore;
            }

            try {
                $post->save();
            }
            catch(\Exception $e) {
                $resp = new \App\Http\Helpers\ServiceResponse;
                $resp->Message = "Error occured while storing the general feed";
                $resp->Status = false;
                $resp->InnerData = (object)[];
                return response()->json($resp, 200);
            }

            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "General feed created successfully";
            $resp->Status = true;
            $resp->InnerData = $post->load('comments');
            return response()->json($resp, 200);
        } catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Image upload error";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }
    }

    // Owner only
    // Edit a general feed through API call
    public function editGeneralFeed(Request $request)
    {
        try {
            // Getting the request user
            $token = \JWTAuth::getToken();
            $requestUser = \JWTAuth::toUser($token);

            try {
                $post = Feed::findOrFail($request->id);
            } catch(\Exception $e) {
                $resp = new \App\Http\Helpers\ServiceResponse;
                $resp->Message = "General feed doesn't exist";
                $resp->Status = false;
                $resp->InnerData = (object)[];
                return response()->json($resp, 200);
            }
            // If the player is not the owner return unauthorized
            if ($requestUser->id != $post->user_id) {
                $resp = new \App\Http\Helpers\ServiceResponse;
                $resp->Message = "Unauthorized";
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
                    $img->save(public_path('storage/general_feeds/'.$filenameToStore));

                    // Deleting the previous image
                    if ($post->thumbnail != '/storage/general_feeds/no_image.jpg') {
                        Storage::delete('storage/general_feeds/'.$post->thumbnail);
                        \File::delete(public_path().$post->thumbnail);
                    }
                } else {
                    $filenameToStore = $post->thumbnail;
                }

                $post->thumbnail = '/storage/general_feeds/'.$filenameToStore;
            }

            try {
                $post->save();
                $resp = new \App\Http\Helpers\ServiceResponse;
                $resp->Message = "General feed edited successfully";
                $resp->Status = true;
                $resp->InnerData = $post->load('comments');
                return response()->json($resp, 200);
            }
            catch(\Exception $e) {
                $resp = new \App\Http\Helpers\ServiceResponse;
                $resp->Message = "Error occured while editing the general feed";
                $resp->Status = false;
                $resp->InnerData = (object)[];
                return response()->json($resp, 200);
            }
        } catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Image upload error";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }
    }

    // Authenticated only
    // Get all active general feeds through API call
    public function allActiveGeneralFeeds(Request $request)
    {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        $page_size = $request->page_size;
        $current_page = $request->current_page;

        $generalFeeds = Feed::where('type', 2)->where('active_status', '=', 1)->orderBy('id', 'desc')->skip($page_size*($current_page-1))->take($page_size)->get();
        $generalFeeds->load('user');
        $generalFeeds->load('comments');

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = $generalFeeds;

        return response()->json($resp, 200);
    }

    // Authenticated only
    // Get all inActive general feeds through API call
    public function allInActiveGeneralFeeds(Request $request)
    {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        $page_size = $request->page_size;
        $current_page = $request->current_page;

        $generalFeeds = Feed::where('type', 2)->where('active_status', '=', 0)->orderBy('id', 'desc')->skip($page_size*($current_page-1))->take($page_size)->get();
        $generalFeeds->load('user');
        $generalFeeds->load('comments');

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = $generalFeeds;

        return response()->json($resp, 200);
    }

    // Authenticated only
    // Get a general feed by id through API call
    public function getGeneralFeedById(\Illuminate\Support\Facades\Request $request)
    {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        try {
            $generalFeed = Feed::findOrFail($request::get('id'));
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "General feed doesn't exist";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        if (!$generalFeed->active_status) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "General feed doesn't exist any more";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // If the post is not a general feed
        if ($generalFeed->type != 2) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "General feed doesn't exist";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $generalFeed->load('user');
        $generalFeed->load('comments');

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = $generalFeed;

        return response()->json($resp, 200);
    }

    // Admin only
    // Destroy a general feed through API call
    public function destroyGeneralFeed(\Illuminate\Support\Facades\Request $request)
    {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        // Getting the general feed
        try {
            $generalFeed = Feed::findOrFail($request::get('id'));
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "General feed doesn't exist";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // If the post is not a general feed
        if ($generalFeed->type != 2) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "General feed doesn't exist";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // If the user is not an admin
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', $requestUser->id)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        if ($generalFeed->thumbnail != '/storage/general_feeds/no_image.jpg') {
            \File::delete(public_path().$generalFeed->thumbnail);
        }

        try {
            $generalFeed->delete();
        } catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Error occured while deleting the general feed";
            $resp->Status = false;
            $resp->InnerData = (object)[];

            return response()->json($resp, 200);
        }

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "General feed deleted successfully";
        $resp->Status = true;
        $resp->InnerData = (object)[];

        return response()->json($resp, 200);
    }

    // Admin or owner method
    // Hide a general feed through API call
    public function hideGeneralFeed(\Illuminate\Support\Facades\Request $request)
    {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        // Getting the general feed
        try {
            $generalFeed = Feed::findOrFail($request::get('id'));
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "General feed doesn't exist";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // If the post is not a general feed
        if ($generalFeed->type != 2) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "General feed doesn't exist";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // If the user is not an admin
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', $requestUser->id)->get()->count() && $requestUser->id != $generalFeed->user_id) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $generalFeed->active_status = 0;
        $generalFeed->save();

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "General feed deleted successfully";
        $resp->Status = true;
        $resp->InnerData = (object)[];

        return response()->json($resp, 200);
    }

    // Authenticated only
    // Get the user general feeds through API call
    public function userGeneralFeeds(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);
        } catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "User Not Found";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        if (!$user->active_status) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Account has been deactivated";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // If the user is not a player or a referee return not found
        if (!User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
            })->where('id', '=', $user->id)->get()->count() &&
            !User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Referees');
            })->where('id', '=', $user->id)->get()->count()) {

            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "No player or referee with the given id";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = $user->feeds;

        return response()->json($resp, 200);
    }

    public function indexActiveGeneralFeedsView()
    {
        return view('generalFeeds.indexActive');
    }

    public function indexInActiveGeneralFeedsView()
    {
        return view('generalFeeds.indexInActive');
    }

    public function showView($id)
    {
        try {
            $feed = Feed::findOrFail($id);
            $users = FeedLike::where('feed_id', $id)->get();
        }
        catch(\Exception $e) {
            return redirect(route('indexGeneralFeeds'))->with('error', 'Feed Not Found');
        }
        return view('generalFeeds.show')->with('feed', $feed)->with('users', $users);
    }
}
