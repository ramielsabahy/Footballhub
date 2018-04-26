<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    protected $table = 'hub_rounds';
    protected $primaryKey = 'Id';
    protected $fillable = ['Name', 'ArName', 'Rank'];
    protected $hidden = [];

}