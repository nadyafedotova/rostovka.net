<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = ['name'];

    public function products(){

        return $this -> hasMany('App\Product','season_id','id');

    }
}
