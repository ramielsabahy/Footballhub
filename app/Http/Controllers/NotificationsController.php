<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function __construct() {
        return $this->middleware('auth', ['except' => ['allPlayerNotifications']]);
    }

    // Token is required
    // Getting all the authenticated user notifications
    public function allPlayerNotifications(\Illuminate\Http\Request $request)
    {
		// Getting the request user
		$token = \JWTAuth::getToken();
		$requestUser = \JWTAuth::toUser($token);

		// Attaching the team invitations
		$requestUser->load('teamInvitations');
		foreach($requestUser->teamInvitations as $invitation) {
			$invitation->load('team');
			$invitation->team->load('owner');
			$invitation->message = "'".$invitation->team->owner->fullName."' want to invite you to his team '".$invitation->team->name."'.";
		}

		// Attaching the friendly matches invitations
		$requestUser->load('friendlyInvitations');
		foreach($requestUser->friendlyInvitations as $invitation) {
			$invitation->load('friendlyMatch');
			$invitation->friendlyMatch->load('owner');
			$invitation->message = "'".$invitation->friendlyMatch->owner->fullName."' want to invite you to his friendly match '".$invitation->friendlyMatch->matchName."'' in ".$invitation->friendlyMatch->time." at ".$invitation->friendlyMatch->place.".";
		}

		$resp = new \App\Http\Helpers\ServiceResponse();
		$resp->Message = "Notifications Retrieved Successfully";
		$resp->Status = true;
		$resp->InnerData = $requestUser;
		return response()->json($resp, 200);
    }
}
