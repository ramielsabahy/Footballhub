<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFeedComment extends Model
{
    protected $table = 'hubuser_feed_comments';
    protected $primaryKey = 'id';
    protected $fillable = ['comment', 'active_status'];

    public function user()
    {
    	return $this->belongsTo('App\User')->where('active_status', '=', 1);
    }

    public function feed()
    {
    	return $this->belongsTo('App\Feed')->where('active_status', '=', 1);
    }
}
