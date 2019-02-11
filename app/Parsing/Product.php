<?php

namespace App\Parsing;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $connection = 'mysql2';

    protected $table = 'vri8x_shop_product';

    public function category(){

        return $this -> hasOne('App\Parsing\Ref','product', 'id');

    }

    public function manufacturer(){

        return $this -> hasOne('App\Parsing\Manufacturer','id', 'manufacturer_id');

    }

    public function options(){

        return $this -> hasMany('App\Parsing\ProductAttribute','entity', 'id');

    }



}
