<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = "types";

    protected $fillable = ['name'];

    public function products(){

        return $this -> hasMany('App\Product','category_id','id');

    }
}
