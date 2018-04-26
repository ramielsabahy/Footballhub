<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'hubdevices';
    protected $primaryKey = 'id';
    protected $fillable = ['pushToken', 'mobileTypeId', 'userId'];
    protected $hidden = [];

    public function user() {
    	return $this->belongsTo('\App\User', 'userId');
    }
}
