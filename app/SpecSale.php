<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecSale extends Model
{
    protected $fillable = ['user_id', 'manufacturer_id', 'percent', 'minus'];
}
