<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamsInvitations extends Model
{
    protected $table = 'hubteams_invitations';
    protected $primary = 'id';
    protected $fillable = ['user_id', 'team_id', 'status'];
    protected $hidden = [];

    public function player() {
    	return $this->belongsTo('\App\User');
    }

    public function team() {
    	return $this->belongsTo('\App\Team');
    }
}
