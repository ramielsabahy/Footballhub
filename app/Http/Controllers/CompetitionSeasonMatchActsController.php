<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;
class CompetitionSeasonMatchActsController extends Controller
{
    public function activitesByMatch($id)
    {
    	try {
            $obj = \App\Models\CompetitionSeasonMatchActivity::where('SeasonMatchId', '=', $id)->get();
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
    
    public function sendActivity(\Illuminate\Support\Facades\Request $request)
    {
        $activity = new \App\Models\CompetitionSeasonMatchActivity();
        $activity->TeamPlayerId = $request::get('TeamPlayerId');
        $activity->SeasonMatchId = $request::get('SeasonMatchId');
        $activity->ActionId = $request::get('ActionId');
        $activity->RefreeScoreValue = $request::get('RefreeScoreValue');
        $activity->Minute = $request::get('Minute');
        $activity->save();
        
        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "raised successfully";
        $resp->Status = true;
        $resp->InnerData = $activity;
 
        return response()->json($resp, 200);
    }
}