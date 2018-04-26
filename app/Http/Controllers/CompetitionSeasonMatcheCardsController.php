<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\Controllers;

class CompetitionSeasonMatcheCardsController extends Controller
{
    public function cardsByMatch($id)
    {
    	try {
            $obj = \App\Models\CompetitionSeasonMatchCard::where('SeasonMatchId', '=', $id)->get();
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
    
    public function raiseCard(\Illuminate\Support\Facades\Request $request)
    {
        $card = new \App\Models\CompetitionSeasonMatchCard();
        $card->TeamPlayerId = $request::get('TeamPlayerId');
        $card->SeasonMatchId = $request::get('SeasonMatchId');
        $card->CardTypeId = $request::get('CardTypeId');
        $card->MinuteTaken = $request::get('MinuteTaken');
        $card->Comments = $request::get('Comments');
        
        $card->save();
        
        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "raised successfully";
        $resp->Status = true;
        $resp->InnerData = $card;
 
        return response()->json($resp, 200);
    }
}