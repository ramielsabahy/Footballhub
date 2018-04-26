<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\Controllers;

class CompetitionSeasonMatcheGoalsController extends Controller
{
    public function goalsByMatch($id)
    {
    	try {
            $obj = \App\Models\CompetitionSeasonMatchGoal::where('SeasonMatchId', '=', $id)->get();
            $obj->load('SeasonMatch');
            $obj->load('TeamPlayer');
    	} catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Failure";
            $resp->Status = true;
            //$resp->InnerData = $e.getMessage();
            return response()->json($resp, 200);
    	}

	$resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Success";
        $resp->Status = true;
        $resp->InnerData = $obj;
        return response()->json($obj, 200);
    }
    
    public function scoreGoal(\Illuminate\Support\Facades\Request $request)
    {
        $goal = new \App\Models\CompetitionSeasonMatchGoal();
        $goal->TeamPlayerId = $request::get('TeamPlayerId');
        $goal->SeasonMatchId = $request::get('SeasonMatchId');
        $goal->MinuteScored = $request::get('MinuteScored');
        $goal->IsPenalty = $request::get('IsPenalty');
        $goal->IsOwnGoal = $request::get('IsOwnGoal');

        $goal->save();
        
        $activity = new \App\Models\CompetitionSeasonMatchActivity();
        $activity->TeamPlayerId = $request::get('TeamPlayerId');
        $activity->SeasonMatchId = $request::get('SeasonMatchId');
        $activity->ActionId = 5;
        $activity->RefreeScoreValue = 4;
        $activity->Minute = $goal->MinuteScored;
        $activity->save();
        
        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "scored successfully";
        $resp->Status = true;
        $resp->InnerData = $goal;
 
        return response()->json($resp, 200);
    }
}