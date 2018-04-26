<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FriendlyController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth', ['except' => ['createFriendlyMatch', 'getPlayerFriendlyInvitations', 'getPlayerFriendlyMatches', 'getPlayerJoinedFriendlyMatches', 'getFriendlyMatchById', 'friendlyMembersCount', 'deleteFriendlyMatch', 'acceptFriendlyMatchInvitation', 'rejectFriendlyMatchInvitation', 'cancelFriendlyMatchInvitation', 'kickOffFriendlyMatchMember', 'leaveFriendlyMatch', 'invitePlayerToFriendlyMatch', 'CheckFriendlyMatchCanStart', 'startFriendlyMatch', 'endFriendlyMatch', 'getPlayerFriendlyScore', 'flushFriendlyMatchResults', 'getAllPlayerFriendlyMatches', 'allMatchesDT']]);
    }

	// Players only
	// place (string), time (timestamp), matchName (string), ids (list of player ids)
	// Create a friendly match through API call
    public function createFriendlyMatch(Request $request)
    {
    	// Getting the request user
		$token = \JWTAuth::getToken();
		$requestUser = \JWTAuth::toUser($token);

		// If the user is not a player return unauthorized
		if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
        	})->where('id', '=', $requestUser->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Only players can create a friendly match";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

        
        try {
	        $friendlyMatch = new \App\friendlyMatch;
	        $friendlyMatch->place = $request->place;
	        $friendlyMatch->time = $request->time;
	        $friendlyMatch->matchName = $request->matchName;
	        $friendlyMatch->status = 1;
	        $friendlyMatch->owner_id = $requestUser->id;
	        $friendlyMatch->save();
	    } catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Error occured while creating the friendly match";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
	    }

	    // Storing the owner as a member of the friendly match
	    try {
		    $member = new \App\friendlyMembers;
		    $member->player_id = $requestUser->id;
		    $member->friendly_match_id = $friendlyMatch->id;
		    $member->save();
		} catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Error occured while adding the owner to the friendly match";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

	    // Sending invitations to the list of ids
	    $ids = $request->ids;
	    foreach ($ids as $id) {
	    	// Check that the id is an id of a player
			if (\App\User::whereHas('roles', function ($query) {
	            $query->where('name', '=', 'Players');
	        	})->where('id', '=', $id)->get()->count()) {
				// Friendly match invitation creation
				if ($id != $requestUser->id) {
					$invitation = new \App\Invitation;
					$invitation->player_id = $id;
					$invitation->friendly_match_id = $friendlyMatch->id;
					$invitation->invitation_type = 2;
					$invitation->save();
				}
			}
	    }

	    // Sending invitations to the list of phone numbers
	    $phone_list = $request->phone_list;
	    foreach ($phone_list as $phone_number) {
			// Friendly match invitation creation
			if ($phone_number != $requestUser->mobileNumber) {
				$invitation = new \App\Invitation;
				$invitation->friendly_match_id = $friendlyMatch->id;
				$invitation->phone_number = $phone_number;
				$invitation->invitation_type = 2;
				$invitation->save();
			}
	    }

	    $friendlyMatch->load('owner');
	    $friendlyMatch->load('friendlyInvitations');
	    $friendlyMatch->load('friendlyOutInvitations');
	    $friendlyMatch->load('friendlyPlayers');

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Friendly match created successfully";
        $resp->Status = true;
        $resp->InnerData = $friendlyMatch;
        return response()->json($resp, 200);
    }

    // Owner of the friendly invitations only
    // Get a player friendly invitations through API call
    public function getPlayerFriendlyInvitations(\Illuminate\Support\Facades\Request $request)
    {
    	// Getting the request user
    	$token = \JWTAuth::getToken();
    	$requestUser = \JWTAuth::toUser($token);

		// If the user is not a player return unauthorized
		if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
        	})->where('id', '=', $requestUser->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Only players have friendly matche invitations";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

        $requestUser->load('friendlyInvitations');

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = $requestUser;

        return response()->json($resp, 200);
    }

  //   // Owner of the friendly matches only
  //   // Get a player friendly matches through API call
  //   public function getPlayerFriendlyMatches(\Illuminate\Support\Facades\Request $request)
  //   {
  //   	// Getting the request user
  //   	$token = \JWTAuth::getToken();
  //   	$requestUser = \JWTAuth::toUser($token);

		// // If the user is not a player return unauthorized
		// if (!\App\User::whereHas('roles', function ($query) {
  //           $query->where('name', '=', 'Players');
  //       	})->where('id', '=', $requestUser->id)->get()->count()) {
		// 	$resp = new \App\Http\Helpers\ServiceResponse;
	 //        $resp->Message = "Only players have friendly matches";
	 //        $resp->Status = false;
	 //        $resp->InnerData = (object)[];
	 //        return response()->json($resp, 200);
		// }

  //       $requestUser->load('friendlyMatches');

		// $resp = new \App\Http\Helpers\ServiceResponse;
  //       $resp->Message = "Retreived Successfully";
  //       $resp->Status = true;
  //       $resp->InnerData = $requestUser;

  //       return response()->json($resp, 200);
  //   }

    // Owner of the friendly matches only
    // Get a player friendly matches through API call
    public function getPlayerFriendlyMatches(\Illuminate\Support\Facades\Request $request)
    {
    	// Getting the request user
    	$token = \JWTAuth::getToken();
    	$requestUser = \JWTAuth::toUser($token);

		// If the user is not a player return unauthorized
		if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
        	})->where('id', '=', $requestUser->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Only players have friendly matches";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Return the friendly matches that is not ended
        $friendly_matches = \App\friendlyMatch::where('owner_id', '=', $requestUser->id)->where('status', '!=', 3)->get();

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = $friendly_matches;

        return response()->json($resp, 200);
    }

    // Owner of the joined friendly matches only
    // Get a player joined friendly matches through API call
    public function getPlayerJoinedFriendlyMatches(\Illuminate\Support\Facades\Request $request)
    {
    	// Getting the request user
    	$token = \JWTAuth::getToken();
    	$requestUser = \JWTAuth::toUser($token);

		// If the user is not a player return unauthorized
		if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
        	})->where('id', '=', $requestUser->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Only players can join friendly matches";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

        $requestUser->load('friendlyJoinedMatches');

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = $requestUser;

        return response()->json($resp, 200);
    }

    // Owner of the friendly matche only
    // friendly_match_id
    // Get a player friendly match by id through API call
    public function getFriendlyMatchById(\Illuminate\Support\Facades\Request $request)
    {
    	// Getting the request user
    	$token = \JWTAuth::getToken();
    	$requestUser = \JWTAuth::toUser($token);

		// If the user is not a player return unauthorized
		if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
        	})->where('id', '=', $requestUser->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Only players have friendly matches";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Check that the friendly match exists
		try {
			$friendly_match = \App\friendlyMatch::findOrFail($request::get('friendly_match_id'));
		} catch(\Exception $e) {
			return response()->json($e->getMessage(), 200);
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Friendly match doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

        // Check that the request user is the owner of the friendly match
		if ($friendly_match->owner_id != $requestUser->id) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "The request user must be the owner of the friendly match";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		$friendly_match->load('owner');
		$friendly_match->load('friendlyInvitations');
		$friendly_match->load('friendlyOutInvitations');
		$friendly_match->load('friendlyPlayers');
		foreach($friendly_match->friendlyPlayers as $player) {
			$player->load('player');
		}

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = $friendly_match;

        return response()->json($resp, 200);
    }

    // Owner of the friendly matche only
    // friendly_match_id
    // Get a player friendly match member count through API call
    public function friendlyMembersCount(\Illuminate\Support\Facades\Request $request)
    {
    	// Getting the request user
    	$token = \JWTAuth::getToken();
    	$requestUser = \JWTAuth::toUser($token);

		// If the user is not a player return unauthorized
		if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
        	})->where('id', '=', $requestUser->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Only players have friendly matches";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Check that the friendly match exists
		try {
			$friendly_match = \App\friendlyMatch::findOrFail($request::get('friendly_match_id'));
		} catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Friendly match doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

        // Check that the request user is the owner of the friendly match
		if ($friendly_match->owner_id != $requestUser->id) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "The request user must be the owner of the friendly match";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		$count = \App\friendlyMembers::where('friendly_match_id', '=', $friendly_match->id)->get()->count();

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = $count;

        return response()->json($resp, 200);
    }

    // Owner of the friendly matche only
    // friendly_match_id
    // Delete the friendly match through API call
    public function deleteFriendlyMatch(\Illuminate\Support\Facades\Request $request)
    {
    	// Getting the request user
    	$token = \JWTAuth::getToken();
    	$requestUser = \JWTAuth::toUser($token);

		// If the user is not a player return unauthorized
		if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
        	})->where('id', '=', $requestUser->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Only players have friendly matches";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Check that the friendly match exists
		try {
			$friendly_match = \App\friendlyMatch::findOrFail($request::get('friendly_match_id'));
		} catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Friendly match doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

        // Check that the request user is the owner of the friendly match
		if ($friendly_match->owner_id != $requestUser->id) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "The request user must be the owner of the friendly match";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Deleting the friendly match and its invitations and its players
		\App\friendlyMembers::where('friendly_match_id', '=', $friendly_match->id)->delete();
		\App\Invitation::where('friendly_match_id', '=', $friendly_match->id)->delete();
		\App\friendlyMatch::where('id', '=', $friendly_match->id)->delete();

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Deleted Successfully";
        $resp->Status = true;
        $resp->InnerData = (object)[];

        return response()->json($resp, 200);
    }

    // Owner of the friendly matche invitation only
    // friendly_match_id
    // Accept the friendly match invitation through API call
    public function acceptFriendlyMatchInvitation(\Illuminate\Support\Facades\Request $request)
    {
    	// Getting the request user
    	$token = \JWTAuth::getToken();
    	$requestUser = \JWTAuth::toUser($token);

		// If the user is not a player return unauthorized
		if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
        	})->where('id', '=', $requestUser->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Only players have friendly matche invitations";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Check that the friendly match invitation exists
		if (!\App\Invitation::where('friendly_match_id', '=', $request::get('friendly_match_id'))->where('player_id', '=', $requestUser->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Friendly match invitation doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
	    }

	    $friendly_invitation = \App\Invitation::where('friendly_match_id', '=', $request::get('friendly_match_id'))->where('player_id', '=', $requestUser->id)->get()->first();

        // Check that the request user is the owner of the friendly match invitation
		if ($friendly_invitation->player_id != $requestUser->id) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "The request user must be the owner of the friendly match invitation";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Accepting the friendly match invitation
		try {
			$friendly_member = new \App\friendlyMembers;
			$friendly_member->player_id = $requestUser->id;
			$friendly_member->friendly_match_id = $friendly_invitation->friendly_match_id;
			$friendly_member->save();

			// Deleting the invitation
			\App\Invitation::where('friendly_match_id', '=', $request::get('friendly_match_id'))->where('player_id', '=', $requestUser->id)->delete();
		} catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Can't accept the invitation right now, kindly try again later";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "You are now a member of the friendly match";
        $resp->Status = true;
        $resp->InnerData = $friendly_member;
        return response()->json($resp, 200);
    }

    // Owner of the friendly matche invitation only
    // friendly_match_id
    // Reject the friendly match invitation through API call
    public function rejectFriendlyMatchInvitation(\Illuminate\Support\Facades\Request $request)
    {
    	// Getting the request user
    	$token = \JWTAuth::getToken();
    	$requestUser = \JWTAuth::toUser($token);

		// If the user is not a player return unauthorized
		if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
        	})->where('id', '=', $requestUser->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Only players have friendly matche invitations";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Check that the friendly match invitation exists
		if (!\App\Invitation::where('friendly_match_id', '=', $request::get('friendly_match_id'))->where('player_id', '=', $requestUser->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Friendly match invitation doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
	    }

	    $friendly_invitation = \App\Invitation::where('friendly_match_id', '=', $request::get('friendly_match_id'))->where('player_id', '=', $requestUser->id)->get()->first();

        // Check that the request user is the owner of the friendly match invitation
		if ($friendly_invitation->player_id != $requestUser->id) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "The request user must be the owner of the friendly match invitation";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Rejecting the friendly match invitation
		try {
			// Deleting the invitation
			\App\Invitation::where('friendly_match_id', '=', $request::get('friendly_match_id'))->where('player_id', '=', $requestUser->id)->delete();
		} catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Can't reject the invitation right now, kindly try again later";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Rejected the friendly match successfully";
        $resp->Status = true;
        $resp->InnerData = (object)[];
        return response()->json($resp, 200);
    }

    // Owner of the friendly matche only
    // friendly_match_id, player_id
    // Cancel the friendly match invitation through API call
    public function cancelFriendlyMatchInvitation(\Illuminate\Support\Facades\Request $request)
    {
    	// Getting the request user
    	$token = \JWTAuth::getToken();
    	$requestUser = \JWTAuth::toUser($token);

		// If the user is not a player return unauthorized
		if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
        	})->where('id', '=', $requestUser->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Only players have friendly matche invitations";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Check that the friendly match invitation exists
		if (!\App\Invitation::where('friendly_match_id', '=', $request::get('friendly_match_id'))->where('player_id', '=', $request::get('player_id'))->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Friendly match invitation doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
	    }

	    // Check that the friendly match exists
	    try {
	    	\App\friendlyMatch::findOrFail($request::get('friendly_match_id'));
	    } catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Friendly match doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
	    }

        // Check that the request user is the owner of the friendly match
		if (\App\friendlyMatch::find($request::get('friendly_match_id'))->owner_id != $requestUser->id) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "The request user must be the owner of the friendly match to cancel an invitation";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Canceling the friendly match invitation
		try {
			// Deleting the invitation
			\App\Invitation::where('friendly_match_id', '=', $request::get('friendly_match_id'))->where('player_id', '=', $request::get('player_id'))->delete();
		} catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Can't cancel the invitation right now, kindly try again later";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Canceled the friendly match invitation successfully";
        $resp->Status = true;
        $resp->InnerData = (object)[];
        return response()->json($resp, 200);
    }

    // Owner of the friendly matche only
    // friendly_match_id, player_id
    // kick off a player from the members of the friendly match through API call
    public function kickOffFriendlyMatchMember(\Illuminate\Support\Facades\Request $request)
    {
    	// Getting the request user
    	$token = \JWTAuth::getToken();
    	$requestUser = \JWTAuth::toUser($token);

		// If the user is not a player return unauthorized
		if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
        	})->where('id', '=', $requestUser->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Only players have friendly matches";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Check that the friendly match member exists
		if (!\App\friendlyMembers::where('friendly_match_id', '=', $request::get('friendly_match_id'))->where('player_id', '=', $request::get('player_id'))->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Friendly match memeber doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
	    }

	    // Check that the friendly match exists
	    try {
	    	\App\friendlyMatch::findOrFail($request::get('friendly_match_id'));
	    } catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Friendly match doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
	    }

        // Check that the request user is the owner of the friendly match
		if (\App\friendlyMatch::find($request::get('friendly_match_id'))->owner_id != $requestUser->id) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "The request user must be the owner of the friendly match to kick off a player from the friendly match";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Check that the status of the friendly match is not started
		$friendly_match = \App\friendlyMatch::find($request::get('friendly_match_id'));
		if ($friendly_match->status == 2) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Cann't kick off a player while the match is already started";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// kicking off the friendly match member
		try {
			// Deleting the member
			\App\friendlyMembers::where('friendly_match_id', '=', $request::get('friendly_match_id'))->where('player_id', '=', $request::get('player_id'))->delete();
		} catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Can't kick off the player right now, kindly try again later";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Kicked off the player successfully";
        $resp->Status = true;
        $resp->InnerData = (object)[];
        return response()->json($resp, 200);
    }

    // member of the friendly matche only
    // friendly_match_id
    // Leave the friendly match through API call
    public function leaveFriendlyMatch(\Illuminate\Support\Facades\Request $request)
    {
    	// Getting the request user
    	$token = \JWTAuth::getToken();
    	$requestUser = \JWTAuth::toUser($token);

		// If the user is not a player return unauthorized
		if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
        	})->where('id', '=', $requestUser->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Only players can join friendly matches";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Check that the player is a member of the friendly match
		if (!\App\friendlyMembers::where('friendly_match_id', '=', $request::get('friendly_match_id'))->where('player_id', '=', $requestUser->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "The player is not a member of the friendly match";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
	    }

		// Check that the status of the friendly match is not started
		$friendly_match = \App\friendlyMatch::find($request::get('friendly_match_id'));
		if ($friendly_match->status == 2) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Cann't leave the match while the match is already started";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Leaving the friendly match
		try {
			// Deleting the membership
			\App\friendlyMembers::where('friendly_match_id', '=', $request::get('friendly_match_id'))->where('player_id', '=', $requestUser->id)->delete();
		} catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Can't leave the friendly match right now, kindly try again later";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Leaved the friendly match successfully";
        $resp->Status = true;
        $resp->InnerData = (object)[];
        return response()->json($resp, 200);
    }

    // Owner of the friendly matche only
    // friendly_match_id, ids, phone_list
    // Invite players to a friendly match through API call
    public function invitePlayerToFriendlyMatch(\Illuminate\Support\Facades\Request $request)
    {
    	// Getting the request user
    	$token = \JWTAuth::getToken();
    	$requestUser = \JWTAuth::toUser($token);

		// If the user is not a player return unauthorized
		if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
        	})->where('id', '=', $requestUser->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Only players have friendly matches";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// If player_id is not a player
		if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
        	})->where('id', '=', $request::get('player_id'))->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Player doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Check that the friendly match exists
		try {
			$friendly_match = \App\friendlyMatch::findOrFail($request::get('friendly_match_id'));
		} catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Friendly match doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

        // Check that the request user is the owner of the friendly match
		if ($friendly_match->owner_id != $requestUser->id) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "The request user must be the owner of the friendly match";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Check that the friendly match is not started and is not ended
		if ($friendly_match->status != 1) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Cann't invite friends to started or ended matches";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Invite players by id
		foreach($request::get('ids') as $player_id) {
			// Check that there is an empty slot to invite more players
			if ((count($friendly_match->friendlyPlayers[0]) + count($friendly_match->friendlyInvitations[0]) + count($friendly_match->friendlyOutInvitations[0])) > 30) {
				$resp = new \App\Http\Helpers\ServiceResponse;
		        $resp->Message = "You have a maximum of 30 players to invite to a friendly match including the memebers of the match";
		        $resp->Status = false;
		        $resp->InnerData = (object)[];
		        return response()->json($resp, 200);
			}

			// Check that the player is already not a member
			// Check that the player is already not invited
			if ((!\App\friendlyMembers::where('friendly_match_id', '=', $request::get('friendly_match_id'))->where('player_id', '=', $player_id)->get()->count())
				&&
				(!\App\Invitation::where('friendly_match_id', '=', $request::get('friendly_match_id'))->where('player_id', '=', $player_id)->get()->count())
			) {
				// Invite the player to the friendly match
				$invitation = new \App\Invitation;
				$invitation->player_id = $request::get('player_id');
				$invitation->friendly_match_id = $request::get('friendly_match_id');
				$invitation->invitation_type = 2;
				$invitation->save();
			}
		}

		// Invite players by phone_number
		foreach($request::get('phone_list') as $phone_number) {
			// Check that there is an empty slot to invite more players
			if ((count($friendly_match->friendlyPlayers[0]) + count($friendly_match->friendlyInvitations[0]) + count($friendly_match->friendlyOutInvitations[0])) > 30) {
				$resp = new \App\Http\Helpers\ServiceResponse;
		        $resp->Message = "You have a maximum of 30 players to invite to a friendly match including the memebers of the match";
		        $resp->Status = false;
		        $resp->InnerData = (object)[];
		        return response()->json($resp, 200);
			}

			// If registered player
			if (\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
        	})->where('mobileNumber', '=', $phone_number)->get()->count()) {
				// Already registered player, check if he has an invitation
				$player = \App\User::where('mobileNumber', '=', $phone_number)->get()->first();
				if (!\App\Invitation::where('friendly_match_id', '=', $request::get('friendly_match_id'))->where('player_id', '=', $player->id)->get()->count()) {
					// If the player doesn't have an invitation
					$invitation = new \App\Invitation;
					$invitation->player_id = $player->id;
					$invitation->friendly_match_id = $request::get('friendly_match_id');
					$invitation->invitation_type = 2;
					$invitation->save();
				}
        	} else {
        		// Check if he have an invitation
        		if (!\App\Invitation::where('friendly_match_id', '=', $request::get('friendly_match_id'))->where('phone_number', '=', $phone_number)->get()->count()) {
        			// Sending the invitation
					$invitation = new \App\Invitation;
					$invitation->phone_number = $phone_number;
					$invitation->friendly_match_id = $request::get('friendly_match_id');
					$invitation->invitation_type = 2;
					$invitation->save();
        		}
        	}
		}

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Invitations Sent Successfully";
        $resp->Status = true;
        $resp->InnerData = $invitation;

        return response()->json($resp, 200);
    }

    // owner of the friendly matche only
    // friendly_match_id
    // Check the friendly match can start through API call
    public function CheckFriendlyMatchCanStart(\Illuminate\Support\Facades\Request $request)
    {
    	// Getting the request user
    	$token = \JWTAuth::getToken();
    	$requestUser = \JWTAuth::toUser($token);

		// If the user is not a player return unauthorized
		if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
        	})->where('id', '=', $requestUser->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Only players can have friendly matches";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Check that the friendly match exists
		try {
			$friendly_match = \App\friendlyMatch::findOrFail($request::get('friendly_match_id'));
		} catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Friendly match doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

        // Check that the request user is the owner of the friendly match
		if ($friendly_match->owner_id != $requestUser->id) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "The request user must be the owner of the friendly match";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Check that the friendly match is not started and not ended
		if ($friendly_match->status != 1) {
			if ($friendly_match->status == 2) {
				$resp = new \App\Http\Helpers\ServiceResponse;
		        $resp->Message = "Cann't start a match that is already started";
		        $resp->Status = false;
		        $resp->InnerData = (object)[];
		        return response()->json($resp, 200);
	    	}
	    	else if ($friendly_match->status == 3) {
				$resp = new \App\Http\Helpers\ServiceResponse;
		        $resp->Message = "Cann't start a match that is already ended";
		        $resp->Status = false;
		        $resp->InnerData = (object)[];
		        return response()->json($resp, 200);
		    }
		}

		// If minimum the number of members of the friendly match is 2, then the match can start
		if ($friendly_match->friendlyPlayers->count() < 2) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Match cannot start because the number of players is less than 2 players total";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}
		else {
			$friendly_match->load('friendlyPlayers');
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Match can start because the number of players is greater than or equal to 2 players total";
	        $resp->Status = true;
	        $resp->InnerData = $friendly_match;
	        return response()->json($resp, 200);
		}
    }

    // owner of the friendly matche only
    // friendly_match_id
    // Start friendly match through API call
    public function startFriendlyMatch(\Illuminate\Support\Facades\Request $request)
    {
    	// Getting the request user
    	$token = \JWTAuth::getToken();
    	$requestUser = \JWTAuth::toUser($token);

		// If the user is not a player return unauthorized
		if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
        	})->where('id', '=', $requestUser->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Only players can have friendly matches";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Check that the friendly match exists
		try {
			$friendly_match = \App\friendlyMatch::findOrFail($request::get('friendly_match_id'));
		} catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Friendly match doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

        // Check that the request user is the owner of the friendly match
		if ($friendly_match->owner_id != $requestUser->id) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "The request user must be the owner of the friendly match";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Check that the friendly match is not started and not ended
		if ($friendly_match->status != 1) {
			if ($friendly_match->status == 2) {
				$resp = new \App\Http\Helpers\ServiceResponse;
		        $resp->Message = "Cann't start a match that is already started";
		        $resp->Status = false;
		        $resp->InnerData = (object)[];
		        return response()->json($resp, 200);
	    	}
	    	else if ($friendly_match->status == 3) {
				$resp = new \App\Http\Helpers\ServiceResponse;
		        $resp->Message = "Cann't start a match that is already ended";
		        $resp->Status = false;
		        $resp->InnerData = (object)[];
		        return response()->json($resp, 200);
		    }
		}

		// Deleting the invitations of the friendly match
		\App\Invitation::where('friendly_match_id', '=', $request::get('friendly_match_id'))->delete();

		// Changing the status of the friendly match to started
		try {
			$friendly_match->status = 2;
			$friendly_match->save();
		} catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Cann't start the friendly match, kindly try again later";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		$friendly_match->load('owner');
		$friendly_match->load('friendlyInvitations');
		$friendly_match->load('friendlyOutInvitations');
		$friendly_match->load('friendlyPlayers');
		foreach($friendly_match->friendlyPlayers as $player) {
			$player->load('player');
		}

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Match started successfully, best of luck";
        $resp->Status = true;
        $resp->InnerData = $friendly_match;
        return response()->json($resp, 200);
    }

    // owner of the friendly matche only
    // friendly_match_id
    // End friendly match through API call
    public function endFriendlyMatch(\Illuminate\Support\Facades\Request $request)
    {
    	// Getting the request user
    	$token = \JWTAuth::getToken();
    	$requestUser = \JWTAuth::toUser($token);

		// If the user is not a player return unauthorized
		if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
        	})->where('id', '=', $requestUser->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Only players can have friendly matches";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Check that the friendly match exists
		try {
			$friendly_match = \App\friendlyMatch::findOrFail($request::get('friendly_match_id'));
		} catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Friendly match doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

        // Check that the request user is the owner of the friendly match
		if ($friendly_match->owner_id != $requestUser->id) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "The request user must be the owner of the friendly match";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Check that the status of the friendly match is started
		if ($friendly_match->status != 2) {
			if ($friendly_match->status == 3) {
				$resp = new \App\Http\Helpers\ServiceResponse;
		        $resp->Message = "The match is already ended";
		        $resp->Status = false;
		        $resp->InnerData = (object)[];
		        return response()->json($resp, 200);
			}
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "The match is not started yet, kindly start the match first to be able to end it";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Deleting the friendly match members
		\App\friendlyMembers::where('friendly_match_id', '=', $request::get('friendly_match_id'))->delete();

		// Changing the status of the match to ended
		try {
			$friendly_match->status = 3;
			$friendly_match->save();
		} catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Cannot end the match right now, kindly try again later";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Match ended successfully";
        $resp->Status = true;
        $resp->InnerData = (object)[];
        return response()->json($resp, 200);
    }

    // Owner only
    // Get a player friendly score through API call
    public function getPlayerFriendlyScore(\Illuminate\Support\Facades\Request $request)
    {
    	// Getting the request user
    	$token = \JWTAuth::getToken();
    	$requestUser = \JWTAuth::toUser($token);

		// If the user is not a player return unauthorized
		if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
        	})->where('id', '=', $requestUser->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Only players have friendly score";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Return the friendly score of the player
        $requestUser->load('friendlyScore');

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = $requestUser;

        return response()->json($resp, 200);
    }

    // owner of the friendly matche only
    // results:[friendly_match_id, [{player_id:id, scores:[number_of_goals, number_of_assists, team_number (1 or 2)]}, ...], team_1_goal_keeper_id, team_2_goal_keeper_id, team_1_final_score, team_2_final_score]
    // Flush friendly match results through API call
    public function flushFriendlyMatchResults(\Illuminate\Support\Facades\Request $request)
    {
    	// Getting the request user
    	$token = \JWTAuth::getToken();
    	$requestUser = \JWTAuth::toUser($token);

		// Getting the results
		$results = $request::get('results');

		// If the user is not a player return unauthorized
		if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
        	})->where('id', '=', $requestUser->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Only players can have friendly matches";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Check that the friendly match exists
		try {
			$friendly_match = \App\friendlyMatch::findOrFail($results['match_id']);
		} catch(\Exception $e) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Friendly match doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

        // Check that the request user is the owner of the friendly match
		if ($friendly_match->owner_id != $requestUser->id) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "The request user must be the owner of the friendly match";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Check that the status of the friendly match is started
		if ($friendly_match->status != 2) {
			if ($friendly_match->status == 3) {
				$resp = new \App\Http\Helpers\ServiceResponse;
		        $resp->Message = "The match is already ended";
		        $resp->Status = false;
		        $resp->InnerData = (object)[];
		        return response()->json($resp, 200);
			}
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "The match is not started yet, kindly start the match first to be able to end it";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Scoring the players
		foreach ($results['player_scores'] as $data) {
			$player_id = $data['player_id'];
			// Check that the user is a player
			if (\App\User::whereHas('roles', function ($query) {
		        $query->where('name', '=', 'Players');
		    	})->where('id', '=', $player_id)->get()->count()) {
				$player = \App\User::find($player_id);
				// If friendly score doesn't exist, then create it
				if (!\App\FriendlyScore::where('player_id', '=', $player_id)->get()->count()) {
					$friendly_score = new \App\FriendlyScore;
					$friendly_score->player_id = $player_id;
					$friendly_score->save();
				}
				$friendly_score = \App\FriendlyScore::where('player_id', '=', $player_id)->get()->first();
				// Adding 1 to the total points as a starting score
				$friendly_score->total_points += 1;
				// If clean cheat, then add 1
				$team_number = $data['team_side'];
				if ($team_number == 1) {
					// Add 1 if team_2_score == 0
					if (!$results['final_score_TeamB']) {
						$friendly_score->total_points += 1;
					}
				}
				else if ($team_number == 2) {
					// Add 1 if team_1_score == 0
					if (!$results['final_score_TeamA']) {
						$friendly_score->total_points += 1;
					}
				}
				// Adding the number of goals
				$friendly_score->number_of_goals += $data['goal_scores'];
				// Adding the score of goals to the total score
				$friendly_score->total_points += ($data['goal_scores']*4);
				// Adding the number of assists
				$friendly_score->number_of_assists += $data['assest_scores'];
				// Adding the score of assists to the total score
				$friendly_score->total_points += ($data['assest_scores']*2);
				// Adding the match to the total number of matches
				$friendly_score->total_number_of_played_matches += 1;
				// Adding 1 to won matches if they won
				if ($team_number == 1) {
					if ($results['final_score_TeamA'] > $results['final_score_TeamB']) {
						$friendly_score->number_of_won_matches += 1;
					}
				}
				else if ($team_number == 2) {
					if ($results['final_score_TeamB'] > $results['final_score_TeamA']) {
						$friendly_score->number_of_won_matches += 1;
					}
				}
				$friendly_score->save();
			}
		}

		// // Scoring the first team goal keeper
		// $first_team_goal_keeper_id = $results['goal_keeper_TeamA'];
		// $first_team_goal_keeper = \App\User::find($first_team_goal_keeper_id);
		// // If friendly score doesn't exist, then create it
		// if (!\App\FriendlyScore::where('player_id', '=', $first_team_goal_keeper_id)->get()->count()) {
		// 	$friendly_score = new \App\FriendlyScore;
		// 	$friendly_score->player_id = $first_team_goal_keeper_id;
		// 	$friendly_score->save();
		// }
		// $first_team_goal_keeper_score = \App\FriendlyScore::where('player_id', '=', $first_team_goal_keeper_id)->get()->first();

		// // Adding 3 as a starting score
		// $first_team_goal_keeper_score->total_points += 3;
		// // If clean cheat, then add 5 to the score
		// if (!$results['final_score_TeamB']) {
		// 	$first_team_goal_keeper_score->total_points += 5;
		// }
		// // Each 2 goals conceived -1
		// $conceived_goals = $results['final_score_TeamB']/2;
		// $first_team_goal_keeper_score->total_points -= $conceived_goals;
		// $first_team_goal_keeper_score->save();

		// // Scoring the second team goal keeper
		// $second_team_goal_keeper_id = $results['goal_keeper_TeamB'];
		// $second_team_goal_keeper = \App\User::find($second_team_goal_keeper_id);
		// // If friendly score doesn't exist, then create it
		// if (!\App\FriendlyScore::where('player_id', '=', $second_team_goal_keeper_id)->get()->count()) {
		// 	$friendly_score = new \App\FriendlyScore;
		// 	$friendly_score->player_id = $second_team_goal_keeper_id;
		// 	$friendly_score->save();
		// }
		// $second_team_goal_keeper_score = \App\FriendlyScore::where('player_id', '=', $second_team_goal_keeper_id)->get()->first();
		// // Adding 3 as a starting score
		// $second_team_goal_keeper_score->total_points += 3;
		// // If clean cheat, then add 5 to the score
		// if (!$results['final_score_TeamA']) {
		// 	$second_team_goal_keeper_score->total_points += 5;
		// }
		// // Each 2 goals conceived -1
		// $conceived_goals = $results['final_score_TeamA']/2;
		// $second_team_goal_keeper_score->total_points -= $conceived_goals;		
		// $second_team_goal_keeper_score->save();

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Results Saved Successfully";
        $resp->Status = true;
        $resp->InnerData = (object)[];
        return response()->json($resp, 200);
    }

    // Get all player friendly matches through API call
    public function getAllPlayerFriendlyMatches(\Illuminate\Support\Facades\Request $request)
    {
    	// Getting the request user
    	$token = \JWTAuth::getToken();
    	$requestUser = \JWTAuth::toUser($token);

		// If the user is not a player return unauthorized
		if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
        	})->where('id', '=', $requestUser->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Only players have friendly matches";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Return the friendly matches that is not ended
        $friendly_matches = \App\friendlyMatch::where('owner_id', '=', $requestUser->id)->where('status', '!=', 3)->get();

        $requestUser->load('friendlyJoinedMatches');
        foreach($requestUser->friendlyJoinedMatches as $friendlyJoinedMatch) {
        	$friendlyJoinedMatch->load('friendlyMatch');
        	if ($friendlyJoinedMatch->friendlyMatch->owner_id != $requestUser->id) {
        		$friendly_matches->push($friendlyJoinedMatch->friendlyMatch);
        	}
        }

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = $friendly_matches;

        return response()->json($resp, 200);
    }

    public function matchesView(){
        return view('matches.matchIndex');
    }

    public function allMatchesDT(){
        $data = \App\friendlyMatch::all();
        

        return response()->json($data, 200);
    }
    public function invitationsView(Request $request){
    	$match = $request->match;
    	$friendlyMatch = \App\friendlyMatch::findOrFail($match);
    	$friendlyMatch->load('owner');
    	$friendlyMatch->load('friendlyInvitations');
    	$friendlyMatch->load('friendlyPlayers');
    	return view('matches.details')->with('details', $friendlyMatch);
    }
}
