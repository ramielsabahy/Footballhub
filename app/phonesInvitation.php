<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class phonesInvitation extends Model
{
    protected $primary = 'id';
    protected $table = 'hubphones_invitations';
    protected $fillable = ['team_id', 'mobileNumber'];
    protected $hidden = [];

    public function team()
    {
    	return $this->belongsTo('\App\Team', 'team_id');
    }
}
