<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductNovelty extends Model
{
    protected $fillable = ['nov_id', 'product_id'];

    public function product(){

        return $this -> belongsTo('App\Product');

    }
}
