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
use App\ProductNovelty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class NoveltyController extends Controller
{
    public function index(){
    	// $lastId = ProductNovelty::latest('id')->first();

    	// $novelty = Product::whereIn('id', ProductNovelty::where('nov_id', $lastId -> nov_id)->pluck('product_id'))->where('accessibility', 1)->where('show_product', 1)->get();

    	$novelty = ProductNovelty::latest('id')->first();

    	return redirect() -> route(' novSpec ', [$novelty -> nov_id]);
    }

    public function specific($id){

    	$novelty = ProductNovelty::where('nov_id', $id)->first();
        $num = null;

        if ( $novelty -> created_at ) {
        
            $list = ProductNovelty::where('created_at', '>=', $novelty -> created_at -> format('Y-m-d')) 
                -> where('created_at', '<', $novelty -> created_at -> addDays(1) -> format('Y-m-d'))
                -> groupBy('nov_id') -> get();

            if ($list -> count() > 1)
                $num = $list -> where('nov_id', $novelty -> nov_id) -> keys() -> first() + 1;

        }
        if ($novelty)
    	   return view('user.novelty.index', compact('novelty', 'num'));
        else {
            $novelty = ProductNovelty::latest('id')->first();
            return redirect() -> route(' novSpec ', [$novelty -> nov_id]);
        }
    }
}
