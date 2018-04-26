<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;
class CompetitionSeasonMatcheSubsController extends Controller
{
    public function subsByMatch($id)
    {
    	try {
            $obj = \App\Models\CompetitionSeasonMatchSub::where('SeasonMatchId', '=', $id)->get();
            $obj->load('SeasonMatch');
            $obj->load('TeamPlayerOut');
            $obj->load('TeamPlayerIn');
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
    
    public function swicthPlayer(\Illuminate\Support\Facades\Request $request)
    {
        $activity = new \App\Models\CompetitionSeasonMatchSub();
        $activity->TeamPlayerOutId = $request::get('TeamPlayerOutId');
        $activity->TeamPlayerInId = $request::get('TeamPlayerInId');
        $activity->SeasonMatchId = $request::get('SeasonMatchId');
        $activity->Minute = $request::get('Minute');
        $activity->IsInjured = $request::get('IsInjured');
        $activity->save();
        
        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "switched successfully";
        $resp->Status = true;
        $resp->InnerData = $activity;
 
        return response()->json($resp, 200);
    }
}