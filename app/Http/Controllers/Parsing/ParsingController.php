<?php

namespace App\Http\Controllers\Parsing;

use App\Parsing\Category;
use App\Parsing\Manufacturer;



use App\Parsing\Product;
use App\Parsing\ProductAttribute;
use App\Parsing\ProductAttributeOptions;
use App\Parsing\Ref;
use App\ProductPhotos;
use App\Season;
use App\Size;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Manufacturer as Manuf;
use App\Type;


class ParsingController extends Controller
{
    protected $options = [];

    public function index(){
//        $inset_array = Manufacturer::pluck('name');
//
//        $date = [];
//
//        foreach($inset_array as $item){
//
//            $date[] = ['name' => $item];
//
//        }

        //dd($date);

        //Manuf::insert($date);

        //dd($date);

//        $date = [];
//
//        $parsingAttr = ProductAttributeOptions::where('attribute_id', 3)->pluck('value')->toArray();
//
//        foreach($parsingAttr as $item){
//
//            $date[] = ['name' => $item];
//
//        }
//
//
//
//
//        Season::insert($date);
//
//        dd($date);


//
//        $date = [];
//
//        $parsingAttr = ProductAttributeOptions::where('attribute_id', 2)->pluck('value')->toArray();
//
//        foreach($parsingAttr as $item){
//
//            $date[] = ['name' => $item];
//
//        }
//
//
//
//
//        Type::insert($date);
//
//        dd($date);


//
//        $date = [];
//
//        $parsingAttr = ProductAttributeOptions::where('attribute_id', 1)->pluck('value')->toArray();
//
//
//
//        foreach($parsingAttr as $item){
//
//            $explodeValue = explode('-', $item);
//            if(isset($explodeValue[1])){
//                $min = $explodeValue[0];
//                $max = $explodeValue[1];
//
//            }else {
//                $min = null;
//                $max = null;
//            }
//            $date[] = ['name' => $item, 'min' => $min, 'max' => $max];
//
//        }
//
//
//        Size::insert($date);
//
//        dd($date);



        //return view('debug', compact('insert_array'));


        ini_set('max_execution_time', 300);

        $seasons = Season::all();

        $sizes = Size::all();

        $types = Type::all();

        $skip = 66000;
        $take = 6000;




        $products = Product::skip($skip) -> take($take) -> whereNotNull('image') ->get();


        $products_attr = ProductAttribute::whereIn('entity',$products -> pluck('id') -> toArray())
            ->distinct() -> pluck('value') ->toArray();


        $products_attr_options = ProductAttributeOptions::whereIn('id',$products_attr) -> pluck('value', 'id') -> toArray();

        $test = ProductAttribute::whereIn('entity',$products -> pluck('id') -> toArray())
            ->distinct() -> get();

        $test->transform(function ($item, $key) {
            if($item -> attribute == 'season')
                $this ->options[$item -> entity]['season'] = $item -> value;
            if($item -> attribute == 'type')
                $this ->options[$item -> entity]['type'] = $item -> value;
            if($item -> attribute == 'size')
                $this ->options[$item -> entity]['size'] = $item -> value;
        });

        $categories = Ref::whereIn('product',$products -> pluck('id') -> toArray()) ->pluck('category','product') -> toArray();

        $insert_array = [];

        foreach ($products as $product){


            switch ($categories[$product -> id]){

                case 2 :
                    $sex = 'Мальчик';
                    $categoryIdForOurDB = 1;
                    break;
                case 3 :
                    $sex = 'Девочка';
                    $categoryIdForOurDB = 1;
                    break;
                case 4 :
                    $sex = 'Мужской';
                    $categoryIdForOurDB = 2;
                    break;
                case 5 :
                    $sex = 'Женский';
                    $categoryIdForOurDB = 3;
                    break;


            }


            if(isset($this ->options[ $product -> id ]['season'])) {
//                dd($products_attr_options[$this->options[$product->id]['season']],
//                    $seasons->where('name', '=', $products_attr_options[$this->options[$product->id]['season']])->first(),
//                    $seasons);
                $season = $seasons->where('name', '=', $products_attr_options[$this->options[$product->id]['season']])->first()->id;
            }
            else
                $season = 1;

            if(isset($this ->options[ $product -> id ]['size']))
                $size = $sizes -> where('name', '=', $products_attr_options[$this ->options[ $product -> id ]['size']]) -> first() -> id;
            else
                $size = 1;

            if(isset($this ->options[ $product -> id ]['type']))
                $type = $types -> where('name', '=', $products_attr_options[$this ->options[ $product -> id ]['type']]) -> first() -> id;
            else
                $type = 1;

            if ($product -> currency_id == 2){
                $currency = 'дол';
            }else
                $currency = 'грн';

//            $discount = '0%';
//
//            if($categories[$product -> id] == 5 || $categories[$product -> id] == 4 ||
//                $categories[$product -> id] == 3 ||$categories[$product -> id] == 2 || $product -> manufacturer_id == 3){
//
//                $discount = '10%';
//            }

            $manufacturer_id = $product -> manufacturer_id;

            if($manufacturer_id == null)
                $manufacturer_id = 1;


            $insert_array[] = [
                'article' => $product -> seo_alias,
                'name' => $product -> name,
                'rostovka_count' => $product -> in_ros,
                'box_count' => $product -> in_box,
                'prise' => $product -> price,
                'manufacturer_id' => $manufacturer_id,
                'category_id' => $categoryIdForOurDB,
                'show_product' => 1,
                'currency' => $currency,
                'full_description' => $product -> full_description,
                'discount' => '0%',
                'accessibility' => $product -> availability,
                //'image_url' => $product -> image,
                'type_id' => $type,
                'season_id' => $season,
                'size_id' => $size,
                'sex' =>$sex,
                'prise_zakup' => $product -> price,
                'prise_default' => $product -> price];

        }

        foreach (array_chunk($insert_array,1000) as $t) {

            \App\Product::insert($t);


        }
        $photo_insert = [];
        $j = 0;
        $products_photos = $products ->pluck('image') ->toArray();

        //dd($products_photos);


       // for ($i = $skip; $i < $skip + $take; $i++){
        for ($i = $skip; $i < 70435; $i++){

//            dump($products_photos[$j]);
//
//            dd($products_photos);

            $photo_insert[] = ['photo_url' => $products_photos[$j],
                               'product_id' => $i + 1];

        $j++;
        }

//        foreach (array_chunk($photo_insert,1000) as $t) {
//
//            ProductPhotos::insert($t);
//
//
//        }

        ProductPhotos::insert($photo_insert);



        dd('russik');

        //dd(Product::all());

    }

}