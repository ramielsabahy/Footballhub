<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CompetitionRound extends Model
{
    protected $table = 'hub_competitionrounds';
    protected $primaryKey = 'Id';
    protected $fillable = ['CompetitionId', 'RoundId', 'Rank'];
    protected $hidden = ['created_at', 'updated_at'];

    public function Competition()
    {
        return $this->belongsTo('\App\Models\Competition', 'CompetitionId', 'Id');
    }
    
    public function Round()
    {
        return $this->belongsTo('\App\Models\Round', 'CompetitionId', 'Id');
    }
    
    public function CompetitionSeasonMatches()
    {
        return $this->hasMany('\App\Models\CompetitionSeasonMatch', 'CompetitionRoundId')
                ->with('HomeTeam')->with('VisitorTeam')->with('HomeTeam')->with('CompetitionSeasonGroup')
                ->with('MainReferee');
    } 
}