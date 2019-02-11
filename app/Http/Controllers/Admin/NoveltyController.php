<?php

namespace App\Http\Controllers\Admin;

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
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class NoveltyController extends Controller
{
    public function index(){

    	$novelties = ProductNovelty::groupBy('nov_id') -> orderBy('nov_id', 'desc') -> get();

        foreach ($novelties as $novelty) {
            if ( $novelty -> created_at ) {
            
                $list = ProductNovelty::where('created_at', '>=', $novelty -> created_at -> format('Y-m-d')) 
                    -> where('created_at', '<', $novelty -> created_at -> addDays(1) -> format('Y-m-d'))
                    -> groupBy('nov_id') -> get();

                if ($list -> count() > 1)
                    $novelty -> num = $list -> where('nov_id', $novelty -> nov_id) -> keys() -> first() + 1;

            }
        }

        foreach ($novelties as $novelty) {
            $novelty -> count = ProductNovelty::where('nov_id', $novelty -> nov_id) -> count();
        }

        return view('admin.product.novelty', compact('novelties'));
    }

    public function delete(Request $request) {
        $novelty = ProductNovelty::where('nov_id', $request -> id) -> get();
        if ( $novelty ) 
            foreach ($novelty as $nov) $nov -> delete();
    }
}
