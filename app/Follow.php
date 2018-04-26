<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = 'hubfollows';

    protected $fillable = ['following', 'follower'];

    public function follower()
    {
    	return $this->belongsTo('\App\User', 'follower');
    }

    public function following()
    {
    	return $this->belongsTo('\App\User', 'following');
    }
}
