<?php

namespace App\Parsing;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $connection = 'mysql2';

    protected $table = 'vri8x_shop_product_attribute_eav';


    public function values(){

        return $this -> hasMany('App\Parsing\ProductAttributeOptions','id', 'value');

    }

}
