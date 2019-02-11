<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'link', 'title', 'description'];

    public function products(){

        return $this -> hasMany('App\Product','category_id','id');

    }

    public function child(){

        return $this -> belongsTo('App\Category','father_id','id');

    }

    public function father(){

        return $this -> hasMany('App\Category','father_id','id');

    }
}
