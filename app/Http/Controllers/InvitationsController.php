<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvitationsController extends Controller
{
    public function __construct() {
        return $this->middleware('auth', ['except' => ['inviteByPhone', 'inviteById', 'checkPhoneInvitations', 'allTeamInvitations', 'allPlayerInvitations', 'acceptInvitation', 'rejectInvitation', 'cancelInvitation', 'clearTeamInvitations', 'clearPhoneInvitations', 'leaveTeam', 'playerKickOff']]);
    }

   // Team owner only
   // team_id && phone_list
   // Invite players by their phone number
   public function inviteByPhone(Request $request)
   {
    	// Getting the request user
		$token = \JWTAuth::getToken();
		$requestUser = \JWTAuth::toUser($token);

        // If the request user is not a player
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
            })->where('id', '=', $requestUser->id)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized (Only a player has the right to invite players to his team)";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

		$phone_list = request()->phone_list;
		$team_id = request()->team_id;

        // Check if team exists
        try {
        	$team = \App\Team::findOrFail($team_id);
        } catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Kindly check the id of the team cause it is not correct";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

		// If the player is not inviting to his own team return unauthorized
		if ($team->owner->id != $requestUser->id) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Unauthorized: Only the owner of the team can invite players to the team";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		foreach ($phone_list as $phone_number)
		{
			// Registered player
			if (\App\User::whereHas('roles', function ($query) {
            	$query->where('name', '=', 'Players');
            })->where('mobileNumber', '=', $phone_number)->get()->count())
			{
				$player = \App\User::where('mobileNumber', '=', $phone_number)->get()->first();
				// Check that he is not invited
				if (!\App\Invitation::where('player_id', '=', $player->id)->where('team_id', '=', $team_id)->get()->count()) {
					$team_invitation = new \App\Invitation();
					$team_invitation->player_id = $player_id;
					$team_invitation->team_id = $team_id;
					$team_invitation->invitation_type = 1;
					$team_invitation->save();
				}
			}
			// Unregistered player
			if (!\App\User::where('mobileNumber', '=', $phone_number)->get()->count()) {
				if (!\App\Invitation::where('phone_number', '=', $phone_number)->where('team_id', '=', $team_id)->get()->count()) {
					$phone_invitation = new \App\Invitation();
					$phone_invitation->phone_number = $phone_number;
					$phone_invitation->team_id = $team_id;
					$phone_invitation->invitation_type = 1;
					$phone_invitation->save();
				}
			}
		}

		// return response
		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Invitations Sent Successfully";
        $resp->Status = true;
        $resp->InnerData = \App\Invitation::where('team_id', '=', $team_id)->whereIn('phone_number', $phone_list)->get();
        return response()->json($resp, 200);
   }

   // Team owner only
   // team_id && id_list
   // id_list doesn't include the creator of the team cause he is a member by default
   // Invite players by their id
   public function inviteById(Request $request)
   {
    	// Getting the request user
		$token = \JWTAuth::getToken();
		$requestUser = \JWTAuth::toUser($token);

        // If the request user is not a player
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
            })->where('id', '=', $requestUser->id)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized (Only a player has the right to invite players to his team)";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

		$id_list = request()->id_list;
		$team_id = request()->team_id;

        // Check if team exists
        try {
        	$team = \App\Team::findOrFail($team_id);
        } catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Kindly check the id of the team cause it is not correct";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

		// If the player is not inviting to his own team return unauthorized
		if ($team->owner->id != $requestUser->id) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Unauthorized: Only the owner of the team can invite players to the team";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		foreach ($id_list as $id)
		{
			if(\App\User::whereHas('roles', function ($query) {
            	$query->where('name', '=', 'Players');
            })->where('id', '=', $id)->get()->count()) {
				$player = \App\User::find($id);
				// If record not found
				if (!\App\Invitation::where('team_id', '=', $team_id)->where('player_id', '=', $id)->get()->count()) {
					$invitation = new \App\Invitation();
					$invitation->team_id = $team_id;
					$invitation->player_id = $player->id;
					$invitation->invitation_type = 1;
					$invitation->save();
				}
			}
		}

		// return response
		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Invitations Sent Successfully";
        $resp->Status = true;
        $resp->InnerData = \App\Invitation::where('team_id', '=', $team_id)->whereIn('player_id', $id_list)->get();
        return response()->json($resp, 200);
   }

    // Newly Registered Player
    // Check if there is any phone invitations to transfer to id invitations
    public function checkPhoneInvitations(\Illuminate\Support\Facades\Request $request)
    {
    	// Getting the request user
		$token = \JWTAuth::getToken();
		$requestUser = \JWTAuth::toUser($token);

        // If the request user is not a player
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
            })->where('id', '=', $requestUser->id)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized (Only a player has phone invitations)";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $phone_number = $requestUser->mobileNumber;

        // Check the list of phone invitations
        $phone_invitations = \App\Invitation::where('phone_number', '=', $phone_number)->get();
        if ($phone_invitations->count()) {
	        foreach($phone_invitations as $phone_invitation)
	        {
	        	// Send the invitation
	        	$invitation = new \App\Invitation();
	        	$invitation->player_id = $requestUser->id;
	        	$invitation->team_id = $phone_invitation->team_id;
	        	$invitation->invitation_type = 1;
	        	$invitation->save();
	        }

	    	// Delete the phone invitations
	    	$phone_invitations = \App\Invitation::where('phone_number', '=', $phone_number);
	    	$phone_invitations->delete();

			// return response
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Invitations Sent Successfully";
	        $resp->Status = true;
	        $resp->InnerData = \App\Invitation::where('player_id', '=', $requestUser->id)->get();
	        return response()->json($resp, 200);
        }
        else {
			// return response
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "No phone invitations for this user";
	        $resp->Status = true;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
        }
    }

    // Player or Admin Method
    // team_id
    // Getting all the team invitations
    public function allTeamInvitations(\Illuminate\Http\Request $request)
    {
		// Getting the request user
		$token = \JWTAuth::getToken();
		$user = \JWTAuth::toUser($token);
		$team_id = request()->team_id;

		// Check if the team exists
		if (!\App\Team::where('id', '=', $team_id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Team doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);			
		}

		$team = \App\Team::find($team_id);

		// Check if the request user is a player or an admin
		if (!\App\User::whereHas('roles', function ($query) {
            	$query->where('name', '=', 'Admins');
        	})->where('id', '=', $user->id)->get()->count() &&
			!\App\User::whereHas('roles', function ($query) {
            	$query->where('name', '=', 'Players');
        	})->where('id', '=', $user->id)->get()->count()
		) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Unauthorized (Only Admin or player can get the team invitations)";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// If player then the team must be his team
		if (\App\User::whereHas('roles', function ($query) {
            	$query->where('name', '=', 'Players');
        	})->where('id', '=', $user->id)->get()->count() &&
			$user->id != $team->user_id) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Unauthorized (Player can only see the invitations of his own team)";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

        // get team invitations
        $team_invitations = \App\Invitation::where('team_id', '=', $team->id)->where('player_id', '!=', 0)->get();
        $phone_invitations = \App\Invitation::where('team_id', '=', $team->id)->where('phone_number', '!=', 0)->get();
		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = ['footballHub_invitations' => $team_invitations, 'phone_invitations' => $phone_invitations];

        return response()->json($resp, 200);
    }

    // Player or Admin Method
    // player_id
    // Getting all the player invitations
    public function allPlayerInvitations(\Illuminate\Http\Request $request)
    {
		// Getting the request user
		$token = \JWTAuth::getToken();
		$user = \JWTAuth::toUser($token);
		$player_id = request()->player_id;

		// Check if the player exists
		if (!\App\User::whereHas('roles', function ($query) {
            	$query->where('name', '=', 'Players');
        	})->where('id', '=', $player_id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Player doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);			
		}

		$player = \App\User::find($player_id);

		// Check if the request user is the player of the request or the request user is an admin
		if (!\App\User::whereHas('roles', function ($query) {
            	$query->where('name', '=', 'Admins');
        	})->where('id', '=', $user->id)->get()->count() &&
        	$user->id != $player_id
		) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Unauthorized (Only Admin or player that request his own invitations are authorized)";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// If player then he must request his own invitations
		if ($user->id != $player_id) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Unauthorized (Player can only see the invitations that belong to him)";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

        // get team invitations
        $player_invitations = \App\Invitation::where('player_id', '=', $player_id)->where('invitation_type', '=', 1)->where('team_id', '!=', 0)->get();
        if (!$player_invitations->count()) {
        	// check the phone invitations
        	$phone_invitations = \App\Invitation::where('phone_number', '=', $user->mobileNumber)->where('invitation_type', '=', 1)->get();
        	if (!$phone_invitations->count()) {
				$resp = new \App\Http\Helpers\ServiceResponse;
		        $resp->Message = $user->fullName." doesn't have any invitations";
		        $resp->Status = true;
		        $resp->InnerData = (object)[];
		        return response()->json($resp, 200);
        	}
        	else {
				$resp = new \App\Http\Helpers\ServiceResponse;
		        $resp->Message = $user->fullName." Phone Invitations Retreived Successfully";
		        $resp->Status = true;
		        $resp->InnerData = $phone_invitations;
		        return response()->json($resp, 200);
        	}
        }
        else {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = $user->fullName." Team Invitations Retreived Successfully";
	        $resp->Status = true;
	        $resp->InnerData = $player_invitations;
	        return response()->json($resp, 200);
        }
    }

    // Player Only
    // team_id
    // API call to accept an invitation
    public function acceptInvitation(Request $request)
    {
		// Getting the request user
		$token = \JWTAuth::getToken();
		$user = \JWTAuth::toUser($token);
		$team_id = request()->team_id;

		// Check if the request user is a player
		if (!\App\User::whereHas('roles', function ($query) {
            	$query->where('name', '=', 'Players');
        	})->where('id', '=', $user->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Request user is not a player";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);			
		}

		// Check if the team exists
		if (!\App\Team::where('id', '=', $team_id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Team doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);	
		}

		$team = \App\Team::find($team_id);

		// Check for the invitation
		if (!\App\Invitation::where('team_id', '=', $team->id)->where('player_id', '=', $user->id)->where('invitation_type', '=', 1)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "No invitation exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		$invitation = \App\Invitation::where('team_id', '=', $team->id)->where('player_id', '=', $user->id)->where('invitation_type', '=', 1)->get()->first();

		// Creating a team member
		$team_member = new \App\teams_users();
		$team_member->user_id = $user->id;
		$team_member->team_id = $team->id;
		$team_member->save();

        // Deleting the invitation
        $invitation = \App\Invitation::where('team_id', '=', $team->id)->where('player_id', '=', $user->id)->where('invitation_type', '=', 1)->delete();

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "You are now a member of the team";
        $resp->Status = true;
        $resp->InnerData = $team_member;

        return response()->json($resp, 200);
    }

    // Owner of the invitation only method
    // team_id
    // API call to reject the invitation
    public function rejectInvitation(Request $request)
    {
		// Getting the request user
		$token = \JWTAuth::getToken();
		$user = \JWTAuth::toUser($token);
		$team_id = request()->team_id;

		// Check if the request user is a player
		if (!\App\User::whereHas('roles', function ($query) {
            	$query->where('name', '=', 'Players');
        	})->where('id', '=', $user->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Request user is not a player";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);			
		}

		// Check if the team exists
		if (!\App\Team::where('id', '=', $team_id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Team doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);	
		}

		$team = \App\Team::find($team_id);

		// Check for the invitation
		if (!\App\Invitation::where('team_id', '=', $team->id)->where('player_id', '=', $user->id)->where('invitation_type', '=', 1)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "No invitation exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		$invitation = \App\Invitation::where('team_id', '=', $team->id)->where('player_id', '=', $user->id)->where('invitation_type', '=', 1);

		// Deleting the invitation
		$invitation->delete();

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Invitation Rejected Successfully";
        $resp->Status = true;
        $resp->InnerData = (object)[];

        return response()->json($resp, 200);
    }

    // Owner of the team only method
    // team_id && player_id
    // API call to cancel the invitation
    public function cancelInvitation(Request $request)
    {
		// Getting the request user
		$token = \JWTAuth::getToken();
		$user = \JWTAuth::toUser($token);

		$team_id = request()->team_id;
		$player_id = request()->player_id;

		// Check if the request user is a player
		if (!\App\User::whereHas('roles', function ($query) {
            	$query->where('name', '=', 'Players');
        	})->where('id', '=', $user->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Request user is not a player";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);			
		}

		// Check if the team exists
		if (!\App\Team::where('id', '=', $team_id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Team doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		$team = \App\Team::find($team_id);

		// Check if the request user is the owner of the team
		if ($team->user_id != $user->id) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "The request player is not the owner of the team";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Check for the invitation
		if (!\App\Invitation::where('team_id', '=', $team_id)->where('player_id', '=', $player_id)->where('invitation_type', '=', 1)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "No invitation exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		$invitation = \App\Invitation::where('team_id', '=', $team_id)->where('player_id', '=', $player_id)->where('invitation_type', '=', 1);

		// Deleting the invitation
		$invitation->delete();

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Invitation Canceled Successfully";
        $resp->Status = true;
        $resp->InnerData = (object)[];

        return response()->json($resp, 200);
    }

    // Owner of the team only method
    // team_id
    // API call to clear the phone invitations of a team
    public function clearPhoneInvitations(Request $request)
    {
		// Getting the request user
		$token = \JWTAuth::getToken();
		$user = \JWTAuth::toUser($token);

		$team_id = request()->team_id;

		// Check if the request user is a player
		if (!\App\User::whereHas('roles', function ($query) {
            	$query->where('name', '=', 'Players');
        	})->where('id', '=', $user->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Request user is not a player";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);			
		}

		// Check if the team exists
		if (!\App\Team::where('id', '=', $team_id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Team doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		$team = \App\Team::find($team_id);

		// Check if the request user is the owner of the team
		if ($team->user_id != $user->id) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "The request player is not the owner of the team";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		$phone_invitations = \App\Invitation::where('team_id', '=', $team->id)->where('invitation_type', '=', 1)->where('phone_number', '!=', 0);

		// Deleting the phone invitations
		$phone_invitations->delete();

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Phone Invitations Cleared Successfully";
        $resp->Status = true;
        $resp->InnerData = (object)[];

        return response()->json($resp, 200);
    }

    // Owner of the team only method
    // team_id
    // API call to clear the team invitations of a team
    public function clearTeamInvitations(Request $request)
    {
		// Getting the request user
		$token = \JWTAuth::getToken();
		$user = \JWTAuth::toUser($token);

		$team_id = request()->team_id;

		// Check if the request user is a player
		if (!\App\User::whereHas('roles', function ($query) {
            	$query->where('name', '=', 'Players');
        	})->where('id', '=', $user->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Request user is not a player";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);			
		}

		// Check if the team exists
		if (!\App\Team::where('id', '=', $team_id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Team doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		$team = \App\Team::find($team_id);

		// Check if the request user is the owner of the team
		if ($team->user_id != $user->id) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "The request player is not the owner of the team";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		$team_invitations = \App\Invitation::where('team_id', '=', $team->id)->where('invitation_type', '=', 1)->where('player_id', '!=', 0);

		// Deleting the phone invitations
		$team_invitations->delete();

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Team Invitations Cleared Successfully";
        $resp->Status = true;
        $resp->InnerData = (object)[];

        return response()->json($resp, 200);
    }

    // Owner of invitation only
    // team_id
    // API call to leave the team
    public function leaveTeam(Request $request)
    {
		// Getting the request user
		$token = \JWTAuth::getToken();
		$user = \JWTAuth::toUser($token);
		$user_id = $user->id;

		$team_id = request()->team_id;

		// Check if the request user is a player
		if (!\App\User::whereHas('roles', function ($query) {
            	$query->where('name', '=', 'Players');
        	})->where('id', '=', $user->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Request user is not a player";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);			
		}

		// Check if the team exists
		if (!\App\Team::where('id', '=', $team_id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Team doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Check that the request user is a member of the team
		if (!\App\teams_users::where('user_id', '=', $user->id)->where('team_id', '=', $team_id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "The player is not a member of the team";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}
		$team_member = \App\teams_users::where('team_id', '=', $team_id)->where('user_id', '=', $user_id);

		// Deleting the phone invitations
		$team_member->delete();

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "You successfully left the team";
        $resp->Status = true;
        $resp->InnerData = (object)[];

        return response()->json($resp, 200);
    }

    // Owner of the team only
    // team_id && player_id
    // API call to kickoff a player of the team
    public function playerKickOff(Request $request)
    {
		// Getting the request user
		$token = \JWTAuth::getToken();
		$user = \JWTAuth::toUser($token);
		$user_id = $user->id;

		$player_id = request()->player_id;
		$team_id = request()->team_id;

		// Check if the request user is a player
		if (!\App\User::whereHas('roles', function ($query) {
            	$query->where('name', '=', 'Players');
        	})->where('id', '=', $user->id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Request user is not a player";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);			
		}

		// Check if the player exists
		if (!\App\User::whereHas('roles', function ($query) {
            	$query->where('name', '=', 'Players');
        	})->where('id', '=', $player_id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Player doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);			
		}

		// Check if the team exists
		if (!\App\Team::where('id', '=', $team_id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "Team doesn't exist";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		$team = \App\Team::find($team_id);

		// Check that the request user is the owner of the team
		if ($team->user_id != $user->id) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "The request user is not the owner of the team";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		// Check that the player is a member of the team
		if (!\App\teams_users::where('user_id', '=', $player_id)->where('team_id', '=', $team_id)->get()->count()) {
			$resp = new \App\Http\Helpers\ServiceResponse;
	        $resp->Message = "The player is not a memeber of the team";
	        $resp->Status = false;
	        $resp->InnerData = (object)[];
	        return response()->json($resp, 200);
		}

		$team_member = \App\teams_users::where('team_id', '=', $team->id)->where('user_id', '=', $player_id);

		// Deleting the phone invitations
		$team_member->delete();

		$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "You successfully kicked-off the player";
        $resp->Status = true;
        $resp->InnerData = (object)[];

        return response()->json($resp, 200);
    }
}
