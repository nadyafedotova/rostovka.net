<?php

namespace App\Parsing;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $connection = 'mysql2';

    protected $table = 'vri8x_shop_manufacturer';
}
