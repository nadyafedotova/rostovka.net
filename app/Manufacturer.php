<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $fillable = ['name','street','numberContainer','firstName','secondName','phone','discount','koorse','box', 'photo', 'description', 'show_all'];

    public function products(){

        return $this -> hasMany('App\Product','category_id','id');

    }

    public $timestamps = false;
}
