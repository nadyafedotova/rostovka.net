<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model{
    protected $fillable =[
        'article','tovar_name','rostovka_count','box_count','prise','manufacturer_name','category_name','currency',
        'full_description','discount','accessibility','type_name','season_name','size_name','order_id','order_id',
        'tovar_in_order_count','this_tovar_in_order_price', 'image', 'tip'
    ];

    public function product(){

        return $this -> hasOne('App\Product','name','tovar_name');

    }
}
