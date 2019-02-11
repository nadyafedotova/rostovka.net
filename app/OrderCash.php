<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderCash extends Model
{
    protected $fillable = ['cashCode', 'order_id'];
}
