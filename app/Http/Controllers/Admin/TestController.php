<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use App\Season;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class TestController extends Controller
{
    public function index(){

        $products = Excel::load('testExcel.xlsx', function($reader) {
        })->get();

        foreach ($products as $product) {
            
        }  

        return $delete_array;
    }
}
