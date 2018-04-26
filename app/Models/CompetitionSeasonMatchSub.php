<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CompetitionSeasonMatchSub extends Model
{
    protected $table = 'hub_compeitionseasonmatchsub';
    protected $primaryKey = 'Id';
    protected $fillable = ['TeamPlayerOutId', 'TeamPlayerInId', 'SeasonMatchId', 'Minute',
        'IsInjured'];
    protected $hidden = ['created_at', 'updated_at'];

    public function SeasonMatch()
    {
        return $this->belongsTo('\App\Models\CompetitionSeasonMatch', 'SeasonMatchId', 'Id');
    }
    
    public function TeamPlayerOut()
    {
        return $this->belongsTo('\App\teams_users', 'TeamPlayerOutId', 'Id')->with('team')
                ->with('player');
    }
    
    public function TeamPlayerIn()
    {
        return $this->belongsTo('\App\teams_users', 'TeamPlayerInId', 'Id')->with('team')
                ->with('player');
    }
}