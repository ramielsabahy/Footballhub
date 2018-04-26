<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'hubteams';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'code', 'user_id', 'active_status'];
    protected $hidden = [];

    public function owner()
    {
        return $this->belongsTo('\App\User', 'user_id')->where('active_status', '=', 1);
    }

    public function members()
    {
        return $this->hasMany('\App\teams_users', 'team_id')->where('active_status', '=', 1);
    }

    public function invitations()
    {
        return $this->hasMany('\App\Invitation', 'team_id')->where('player_id', '!=', 0);
    }

    public function outInvitations()
    {
        return $this->hasMany('\App\Invitation', 'team_id')->where('phone_number', '!=', 0);
    }
}
