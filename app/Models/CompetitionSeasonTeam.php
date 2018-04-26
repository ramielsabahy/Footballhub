<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CompetitionSeasonTeam extends Model
{
    protected $table = 'hub_competitionseasonteams';
    protected $primaryKey = 'Id';
    protected $fillable = ['CompetitionSeasonId', 'TeamId', 'CompeitionSeasonGroupId',
        'GoalsScored', 'GoalsConceded', 'Won', 'Lost', 'Tie', 'PositionInCompetition', 'TotalPoints'];
    protected $hidden = [];

    public function CompetitionSeason()
    {
        return $this->belongsTo('\App\Models\CompetitionSeason', 'CompetitionSeasonId', 'Id');
    }
    
    public function CompeitionSeasonGroup()
    {
        return $this->belongsTo('\App\Models\CompetitionSeasonGroup', 'CompetitionSeasonGroupId', 'Id');
    }
    
    public function Team()
    {
        return $this->belongsTo('\App\Team', 'TeamId', 'id');
    }
}