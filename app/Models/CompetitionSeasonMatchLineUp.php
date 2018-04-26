<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CompetitionSeasonMatchLineUp extends Model
{
    protected $table = 'hub_compeitionseasonmatchlineup';
    protected $primaryKey = 'Id';
    protected $fillable = ['SeasonMatchId', 'TeamPlayerId', 'IsSub',
        'VotersNum'];
    protected $hidden = [];

    public function SeasonMatch()
    {
        return $this->belongsTo('\App\Models\CompetitionSeasonMatch', 'SeasonMatchId', 'Id');
    }
    
    public function TeamPlayer()
    {
        return $this->belongsTo('\App\teams_users', 'TeamPlayerId', 'Id')->with('team')
                ->with('player');
    }
}