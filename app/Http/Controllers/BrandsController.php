<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\ProductRequest;
use App\Manufacturer;
use App\Product;
use App\Season;
use App\Size;
use App\Type;
use App\TopSale;
use App\ManShow;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BrandsController extends Controller
{
    public function index(){
    	$mans = ManShow::select('manufacturer_id') -> where('user_id', Auth::id()) -> pluck('manufacturer_id');
        $forAll = Manufacturer::where('show_all', 1)->orderBy('name','asc') -> get();
        $showsMan = Manufacturer::where(function ($query) use ($mans) {
            return $query->where('show_all', 1)
                  -> orWhereIn('id', $mans);
        }) -> pluck('id');

    	$prods = Product::where('accessibility', 1)->where('show_product', 1)->groupBy( 'manufacturer_id' )->pluck( 'manufacturer_id' );
        $brands = Manufacturer::whereIn('id', $showsMan) -> whereIn('id', $prods) -> orderBy('name') -> get();
        return view('user.brands.index', compact('brands'));

    }

    public function getBrandProducts($name) {
    	$mans = ManShow::select('manufacturer_id') -> where('user_id', Auth::id()) -> pluck('manufacturer_id');
        $forAll = Manufacturer::where('show_all', 1)->orderBy('name','asc') -> get();
        $showsMan = Manufacturer::where(function ($query) use ($mans) {
            return $query->where('show_all', 1)
                  -> orWhereIn('id', $mans);
        }) -> pluck('id');
    	$brand = Manufacturer::whereIn('id', $showsMan) -> where('name', $name)->first();
    	
    	if ($brand) return view('user.brands.products', compact('brand'));
    	else return redirect()->route('root');
    }
}
