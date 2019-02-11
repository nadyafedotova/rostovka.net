<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Requests\ProductRequest;
use App\Manufacturer;
use App\Product;
use App\ProductPhotos;
use App\Season;
use App\Size;
use App\Type;
use App\ManShow;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index($name = ""){

        $manufactures = Manufacturer::orderBy('name','asc') -> get();
        $seasons = Season::where('id', '!=', 5) ->orderBy('name','asc') -> get();
        $types = Type::where('id', '!=', 28)->orderBy('name','asc') -> get();

        $countries = Product::where('show_product', '=', 1) -> whereNotNull('manufacturer_country') -> groupBy('manufacturer_country') -> select('manufacturer_country') -> get();

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

        $manufacturerGetParam = null;
        $articleGetParam = null;

        if(isset($_GET['manufacturer']))
            $manufacturerGetParam = $_GET['manufacturer'];
        if(isset($_GET['article']))
            $articleGetParam = $_GET['article'];

        if(isset($_GET['manufacturer']))
        $manufacturerId = Manufacturer:: where('name', "like", "%".$_GET['manufacturer']."%")
            -> pluck('id')->toArray();
        else $manufacturerId = Manufacturer::all() -> pluck('id')->toArray();

        $page = 1;
        if(isset($_GET['page'])){

            $page = $_GET['page'];

        }

        if($name != "") {
            if( isset($_GET['article'])) {
                $products = Product::with('category', 'manufacturer', 'photo')->
                where('article', "like", "%" . $_GET['article'] . "%")->
                where('name', "like", "%" . $name . "%")->
                whereIn('manufacturer_id', $manufacturerId)->
                orderBy('id', 'desc')->skip(($page - 1) * 15) -> take(15) -> get();

                $productCount = ceil(Product::with('category', 'manufacturer', 'photo')->
                    where('article', "like", "%" . $_GET['article'] . "%")->
                    where('name', "like", "%" . $name . "%")->
                    whereIn('manufacturer_id', $manufacturerId)-> count() / 15);

            }else {
                $products = Product::with('category', 'manufacturer', 'photo')->
                where('name', "like", "%" . $name . "%")->
                whereIn('manufacturer_id', $manufacturerId)->
                orderBy('id', 'desc')->skip(($page - 1) * 15) -> take(15) -> get();

                $productCount = ceil(Product::with('category', 'manufacturer', 'photo')->
                    where('name', "like", "%" . $name . "%")->
                    whereIn('manufacturer_id', $manufacturerId) -> count() / 15);
            }
        }
        else{
            if(isset($_GET['article'])){
                $products = Product::with('category', 'manufacturer', 'photo')->
                where('article', "like", "%" . $_GET['article'] . "%")->
                whereIn('manufacturer_id', $manufacturerId)->
                orderBy('id', 'desc')->skip(($page - 1) * 15) -> take(15) -> get();

                $productCount = ceil(Product::with('category', 'manufacturer', 'photo')->
                    where('article', "like", "%" . $_GET['article'] . "%")->
                    whereIn('manufacturer_id', $manufacturerId) -> count() / 15);
            }else {
                $products = Product::with('category', 'manufacturer', 'photo')->
                whereIn('manufacturer_id', $manufacturerId)->
                orderBy('id', 'desc')->skip(($page - 1) * 15)->take(15)->get();

                $productCount = ceil(Product::with('category', 'manufacturer', 'photo')->
                    whereIn('manufacturer_id', $manufacturerId) -> count() / 15);
            }
        }


        return view('admin.product.products', compact('products', 'manufactures', 'seasons', 'types', 'countries', 'colors', 'productCount', 'manufacturerGetParam', 'articleGetParam'));
    }

    public function finder(Request $request){

        $products = Product::where('name','like', '%'.$request->name.'%') -> with('photo', 'manufacturer', 'category')->get();

        foreach ($products as $product){

            if($product -> manufacturer ->koorse != "" && $product -> manufacturer ->koorse != 0){

                $product->prise_default *= $product -> manufacturer ->koorse;

            }

        }


        return $products;


    }

    public function colors() {
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
        return $colors;
    }


    public function delete(Request $request){

        if(Product::find($request -> id) -> photo)
        File::delete('images/products/'. Product::find($request -> id) -> photo -> photo_url);

        Product::find($request -> id) -> delete();
        ProductPhotos::where('product_id', $request -> id) -> delete();

    }

    public function update(ProductRequest $request){

        $product = Product::find($request -> id);

        if($product){

            $product -> fill($request ->all());

            if($request -> image_url){

                File::delete('../image/products/'. $product -> photo() -> photo_url);

                $request->image_url->move('../image/products', "product_" . Carbon::now() . '.png');

                $productPhoto = ProductPhotos::where('product_id','=', $product -> id) -> first();

                $productPhoto -> photo_url = "product_" . Carbon::now() . '.png';

                $productPhoto -> save();

            }

            $product -> save();

            return response('done', 200);

        }else return response('wrong product id', 404);

    }

    public function edit($id){

        $manufacturer = Manufacturer::all();
        $categories = Category::all();
        $types = Type::all();
        $seasons = Season::all();
        $sizes = Size::all();
        $product = Product::with('photo') -> find($id);

        if($product )

            return view('admin.product.productedit', compact('manufacturer', 'categories', 'types', 'seasons', 'sizes', 'product'));

        else return response('Wrong product id', 404);

    }

    public function tovarMultiUpdate(Request $request){

        //dd($request -> all());

        if(!$request -> save){

            return response('products not check',404);

        }

        if(!is_null($request -> discount)){

            if($request -> availability == "грн") {

                $products = Product::whereIn('id', $request->save)->with('manufacturer')->get();

                foreach ($products as $product){

                    if ($product -> manufacturer -> discount != "" && $product -> manufacturer -> discount != 0) {

                        $hrivna_discount = explode("грн", $product -> manufacturer -> discount);

                        if (isset($hrivna_discount[1])) {

                            if(($hrivna_discount[1] + $product->prise) < $request -> discount )

                                return response("discount can't be more as prise of one product + manufacturer discount", 404);

                        }

                        $prozent_discount = explode("%", $product -> manufacturer -> discount);

                        if (isset($prozent_discount[1])) {

                            if(( $product->prise - ($product->prise * ($prozent_discount[0] / 100)) + $product->prise) < $request -> discount )

                                return response("discount can't be more as prise of one product + manufacturer discount", 404);

                        }

                    }

                }

            }

            if($request -> availability == "%" && $request -> discount > 100){

                return response("discount can't be more as 100%", 404);

            }

        }


        $products = Product::whereIn('id', $request -> save) ->with('manufacturer') -> get();

        $manufacturers = Manufacturer::all();

        foreach ($request -> save as $item){

            foreach ($products as $product){

                if($item == $product -> id){

                    if(!is_null($request -> discount)){

                        $product->discount = $request -> discount.$request -> availability;

                        $priseWithDiscount = $product->prise_default;

                        $manufacturersInfoToProduct = $manufacturers->find($product->manufacturer_id);


                        if ($manufacturersInfoToProduct->koorse != "" && $manufacturersInfoToProduct->koorse != 0 && $product->currency == "дол") {

                            $priseWithDiscount *= $manufacturersInfoToProduct->koorse;

                        }

                        if ($manufacturersInfoToProduct->discount != "" && $manufacturersInfoToProduct->discount != 0) {


                            $hrivna_discount = explode("грн", $manufacturersInfoToProduct->discount);

                            if (isset($hrivna_discount[1])) {

                                $priseWithDiscount = $priseWithDiscount - $hrivna_discount[0];
                            }

                            $prozent_discount = explode("%", $manufacturersInfoToProduct->discount);

                            if (isset($prozent_discount[1])) {

                                $priseWithDiscount = $priseWithDiscount - ($priseWithDiscount * ($prozent_discount[0] / 100));
                            }

                        }

                        if ($product->discount != "" && $product->discount != 0) {


                            $hrivna_discount = explode("грн", $product->discount);

                            if (isset($hrivna_discount[1])) {

                                $priseWithDiscount = $priseWithDiscount - $hrivna_discount[0];
                            }

                            $prozent_discount = explode("%", $product->discount);


                            if (isset($prozent_discount[1])) {

                                $priseWithDiscount = $priseWithDiscount - ($priseWithDiscount * ($prozent_discount[0] / 100));
                            }

                        }

                        $product->prise = $priseWithDiscount;


                    }


                    if($request ->price) {

                        $priseWithDiscount = $request->price;

                        $manufacturersInfoToProduct = $manufacturers->find($product->manufacturer_id);


                        if ($manufacturersInfoToProduct->koorse != "" && $manufacturersInfoToProduct->koorse != 0 && $product->currency == "дол") {

                            $priseWithDiscount *= $manufacturersInfoToProduct->koorse;

                        }

                        if ($manufacturersInfoToProduct->discount != "" && $manufacturersInfoToProduct->discount != 0) {


                            $hrivna_discount = explode("грн", $manufacturersInfoToProduct->discount);

                            if (isset($hrivna_discount[1])) {

                                $priseWithDiscount = $priseWithDiscount - $hrivna_discount[0];
                            }

                            $prozent_discount = explode("%", $manufacturersInfoToProduct->discount);

                            if (isset($prozent_discount[1])) {

                                $priseWithDiscount = $priseWithDiscount - ($priseWithDiscount * ($prozent_discount[0] / 100));
                            }

                        }

                        if ($product->discount != "" && $product->discount != 0) {


                            $hrivna_discount = explode("грн", $product->discount);

                            if (isset($hrivna_discount[1])) {

                                $priseWithDiscount = $priseWithDiscount - $hrivna_discount[0];
                            }

                            $prozent_discount = explode("%", $product->discount);


                            if (isset($prozent_discount[1])) {

                                $priseWithDiscount = $priseWithDiscount - ($priseWithDiscount * ($prozent_discount[0] / 100));
                            }

                        }

                        $product->prise = $priseWithDiscount;
                        $product->prise_default = $request->price;

                    }

                    if($request->pricePurchase)
                    $product->prise_zakup = $request->pricePurchase;

                    if($request -> exist == 1) {

                        $product->show_product = 1;
                        $product->accessibility = 1;
                    }
                    if($request -> exist == 2) {

                        $product->show_product = 0;
                        $product->accessibility = 0;
                    }

                    $product -> save();


                }

            }
            //$insertArray = ['prise' => ]


        }
        return response('done');

    }
}
