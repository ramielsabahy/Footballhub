<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class friendlyMatch extends Model
{
    protected $table = 'hubfriendly_matches';
    protected $primaryKey = 'id';
    protected $fillable = ['place', 'time', 'matchName', 'status', 'owner_id'];
    protected $hidden = [];

    // status
    // 1 created but not started yet
    // 2 started match
    // 3 ended match

    public function owner() {
        return $this->belongsTo('\App\User', 'owner_id');
    }

    public function friendlyInvitations() {
        return $this->hasMany('\App\Invitation', 'friendly_match_id')->where('player_id', '!=', 0);
    }

    public function friendlyOutInvitations() {
        return $this->hasMany('\App\Invitation', 'friendly_match_id')->where('phone_number', '!=', 0);
    }

    public function friendlyPlayers() {
        return $this->hasMany('\App\friendlyMembers', 'friendly_match_id');
    }
}
