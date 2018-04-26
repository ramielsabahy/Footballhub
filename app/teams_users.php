<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class teams_users extends Model
{
    protected $primaryKey = 'Id';
    protected $table = 'hubteams_users';
    protected $fillable = ['user_id', 'team_id', 'active_status'];
    protected $hidden = [];

    public function team()
    {
        return $this->belongsTo('\App\Team', 'team_id', 'id')->where('active_status', '=', 1);
    }

    public function player()
    {
        return $this->belongsTo('\App\User', 'user_id', 'id')->where('active_status', '=', 1);
    }
}
