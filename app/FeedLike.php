<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedLike extends Model
{
    protected $table = "hubfeed_likes";
    protected $fillable = ["user_id", "feed_id", "active_status"];

    public function user() {
    	return $this->belongsTo('\App\User', 'user_id')->where('active_status', '=', 1);
    }

    public function feed() {
    	return $this->belongsTo('\App\Feed', 'feed_id')->where('active_status', '=', 1);
    }
}
