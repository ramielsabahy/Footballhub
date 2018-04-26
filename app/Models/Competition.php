<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    protected $table = 'hub_competitions';
    protected $primaryKey = 'Id';
    protected $fillable = ['Name', 'ArName', 'LogoUrl', 'CompetitionTypeId', 'NumberOfTeams',
        'YellowCardsToSuspend', 'CupImageUrl'];
    protected $hidden = [];

    
    public function competitionSeasons()
    {
        return $this->hasMany('App\Models\CompetitionSeason', 'CompetitionId')->with('CompetitionSeasonGroups');
    }
    
    public function competitionRounds()
    {
        return $this->hasMany('App\Models\CompetitionRound', 'CompetitionId')->with('CompetitionSeasonMatches')
                ->with('Competition')->with('Round');
    }
}