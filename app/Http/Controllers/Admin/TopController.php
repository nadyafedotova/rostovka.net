<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use App\Season;
use App\Category;
use App\TopSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class TopController extends Controller
{
    public function index(){

        $top = TopSale::where('top', '1') -> pluck('product_id') -> toArray();

        if ( $top ) {
            $products = Product::whereIn('id', $top)
                ->with('photo','size','manufacturer')
                ->where('show_product', 1)
                ->where('accessibility', 1)
                ->orderBy(DB::raw('FIELD(`id`, '.implode(',', $top).')')) ->get();

            foreach ($products as $product){

                $product -> expires = TopSale::where('product_id', $product -> id) -> first() -> expires_at;
                $product -> product_url = $product -> category() -> first() -> link . '/' . rawurlencode($product -> name);
            }
        } else $products = [];

        return view('admin.top.main', compact('products'));

    }

    public function addToTop(Request $request){

        $product = Product::where('name', $request -> name) -> first();

        if ( $request -> days > 30 ) $request -> days = 30;

        if ( $product )
            $top = TopSale::where('product_id', $product->id) -> first();
        else return redirect() -> back() -> withErrors(['error' => "Wrong Product Name"]);

        if ( $top ) {
            $top -> expires_at = Carbon::now()->addDays($request -> days);
            $top -> top = true; 
            $top -> save();
        } else {
            $top = new TopSale;
            $top -> product_id = $product -> id;
            $top -> top = true;
            $top -> count = 1;
            $top -> expires_at = Carbon::now()->addDays($request -> days);
            $top -> save();
        }

    }

    public function update(Request $request){

        $category = Category::find($request -> id);

        $category -> title = $request -> title;
        $category -> description = $request -> description;

        $category -> save();

        return redirect()->route("adminSeo");

    }

    public function delTop(Request $request) {
        $top = TopSale::where('product_id', $request -> id) -> first();
        $top -> top = false;
        $top -> save();
    }
}
