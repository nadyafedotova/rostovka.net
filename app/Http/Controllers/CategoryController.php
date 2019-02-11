<?php

namespace App\Http\Controllers;

use App\Category;
use App\Manufacturer;
use App\Product;
use App\Season;
use App\SpecSale;
use App\Size;
use App\Type;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function show($id){

        $category = Category::find($id);

        return redirect('/' . $category -> link);

        if($category) {
            //if ($id != 4) {
                $category = Category::find($id);

                return view('user.category_page.category', compact('category'));
            //}else return view('user.category_page.category', compact('category'));
        }else return redirect() ->back();


    }

    public function showByName($link){

        $category = Category::where('link', $link) -> first();

        if($category) {
            //if ($category -> id != 4) {

                return view('user.category_page.category', compact('category'));
            //}else return view('user.category_page.category', compact('category'));
        }else return abort(404);


    }

    public function showByName2($link) {

        $category = Category::where('link', $link) -> first();

        if($category) {
            //if ($category -> id != 4) {
                return view('user.category_page.category2', compact('category'));
            //}else return view('user.category_page.category2', compact('category'));
        }else return abort(404);

    }

    public function showByName1($link){
        $colors = Product::where('show_product', '=', 1) -> whereNotNull('color') -> groupBy('color') -> select('color') -> get();

        $tmpColors = [];

        foreach ($colors as $color) {
            $color = mb_strtolower($color->color);
            if(strpos($color, '-') !== false) {
                $color = explode('-', $color);
            } else if(strpos($color, ', ') !== false) {
                $color = explode(', ', $color);
            } else if(strpos($color, ',') !== false) {
                $color = explode(',', $color);
            } else $color = array( $color );

            foreach ($color as $col) {
                array_push($tmpColors, $col);
            }
        }

        sort($tmpColors);
        $colors = array_unique($tmpColors);

        dd($colors);

    }
}
