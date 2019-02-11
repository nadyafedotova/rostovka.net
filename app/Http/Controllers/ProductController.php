<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\ProductRequest;
use App\Manufacturer;
use App\Product;
use App\ProductNovelty;
use App\Season;
use App\Size;
use App\Color;
use App\Type;
use App\TopSale;
use App\SpecSale;
use App\ManShow;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function testMans() {
        $mans = ManShow::select('manufacturer_id') -> where('user_id', Auth::id()) -> pluck('manufacturer_id');
        $forAll = Manufacturer::where('show_all', 1)->orderBy('name','asc') -> get();

        Manufacturer::where(function ($query) use ($mans) {
            return $query->where('show_all', 1)
                  -> orWhereIn('id', $mans);
        }) -> pluck('id');
    }

    public function create() {

        $manufacturers = Manufacturer::all();
        $categories = Category::all();
        $types = Type::all();
        $seasons = Season::all();
        $sizes = Size::all();
        return view('admin.product.add', compact('manufacturers', 'categories', 'types', 'seasons', 'sizes'));

    }

    public function add(ProductRequest $request){



    }

    public function show($id, $number = null){

        $product = Product::find($id);

        if($product)
            return redirect('/' . $product -> category() -> first() -> link . '/' . rawurlencode($product -> name), 301);
        return redirect('/', 301);

    }

    public function check($link, $name) {
        $category = Category::where('link', $link) -> first();

        if($category) {

                $product = Product::where('category_id', $category -> id)
                    -> where('name', $name)
                    -> with('size') -> first();

                if($product) {
                    $sale = SpecSale::where('user_id', Auth::id()) -> where('manufacturer_id', $product->manufacturer_id) -> first();
                    if ($sale) {
                        if ( $sale -> percent ) $product -> prise = $product -> prise - ($product -> prise * ( $sale -> percent/100));
                        else if ( $sale -> minus ) $product -> prise = $product -> prise - $sale -> minus;

                        $product -> prise = round($product -> prise);
                        $product -> specsale = 'specsale';
                    }
                    if(Manufacturer::find($product->manufacturer_id)->box == 1)
                        $product -> rostovka_count = $product -> box_count;

                    $fphoto = $product -> photos -> groupBy('photo_url') -> first()[0] -> photo_url;
                    return view('user.product.product_inner', compact('product', 'fphoto'));
                }

                $typeFilter = Type::where('name', $name) -> get();

                if ($typeFilter -> count() > 0) {
                    return view('user.filters.index', compact('category', 'typeFilter'));
                }

                return abort(404);
        } else return abort(404);
    }

    public function showByName($link, $name, $number = null) {
        $category = Category::where('link', $link) -> first();

        if($category) {
            //if ($category -> id != 4) {

                $product = Product::where('category_id', $category -> id)
                    -> where('name', $name)
                    -> with('size') -> first();

                if($product) {
                    $sale = SpecSale::where('user_id', Auth::id()) -> where('manufacturer_id', $product->manufacturer_id) -> first();
                    if ($sale) {
                        if ( $sale -> percent ) $product -> prise = $product -> prise - ($product -> prise * ( $sale -> percent/100));
                        else if ( $sale -> minus ) $product -> prise = $product -> prise - $sale -> minus;

                        $product -> prise = round($product -> prise);
                        $product -> specsale = 'specsale';
                    }
                    if(Manufacturer::find($product->manufacturer_id)->box == 1)
                        $product -> rostovka_count = $product -> box_count;

                    $fphoto = $product -> photos -> groupBy('photo_url') -> first()[0] -> photo_url;
                } else return abort(404);
                return view('user.product.product_inner', compact('product', 'fphoto'));
            //} else return abort(404);
        } else return abort(404);
    }

    public function showByNameWithSlider($link, $name, $number = null) {
        $category = Category::where('link', $link) -> first();

        if($category) {
            //if ($category -> id != 4) {

                $product = Product::where('category_id', $category -> id)
                    -> where('name', $name)
                    -> with('size') -> first();

                if($product) {
                    if(Manufacturer::find($product->manufacturer_id)->box == 1)
                        $product -> rostovka_count = $product -> box_count;

                    $fphoto = $product -> photos -> groupBy('photo_url') -> first()[0] -> photo_url;
                } else return abort(404);
                return view('user.product.product_inner2', compact('product', 'fphoto'));
            //} else return abort(404);
        } else return abort(404);
    }

    public function getSizesMass(){

        return [Size::min('min'),Size::max('max')];

    }

    public function updateFilters(Request $request) {

        $products = [];
        $sex = $this -> getSex($request -> category_id);

        if($sex == false)
            $sex = $this->sexFilter($request->filters);

        if($sex == false)
            $sex = ['Девочка', 'Мальчик', 'Мужской', 'Женский', 'Унисекс'];

        $sizes_min = 0;
        $sizes_max = 99999;

        if($request->sizes[0]){
            $sizes_min = $request->sizes[0]['sizeValues'][0];
            $sizes_max = $request->sizes[0]['sizeValues'][1];
        }

        if(isset($request->brand_id)) {

            $max = Product::where('manufacturer_id', '=', $request->brand_id)
                ->whereIn('season_id', $this->seasonFilter($request->filters))
                ->whereIn('type_id', $this->typeFilter($request->filters))
                ->whereIn('size_id', $this->size2Filter($request->filters))
                ->whereIn('category_id', $this->categoryFilter($request->filters))
                ->whereIn('sex', $sex)
                ->where('accessibility', 1)
                ->where('show_product', 1)
                ->orderBy('prise', 'desc') -> first();

            $min = Product::where('manufacturer_id', '=', $request->brand_id)
                ->whereIn('season_id', $this->seasonFilter($request->filters))
                ->whereIn('type_id', $this->typeFilter($request->filters))
                ->whereIn('size_id', $this->size2Filter($request->filters))
                ->whereIn('category_id', $this->categoryFilter($request->filters))
                ->whereIn('sex', $sex)
                ->where('accessibility', 1)
                ->where('show_product', 1)
                ->orderBy('prise', 'asc') -> first();

            $sizes = Size::whereIn('id', Product::where('manufacturer_id', '=', $request->brand_id)
                ->whereBetween('prise', [$sizes_min, $sizes_max])
                ->whereIn('season_id', $this->seasonFilter($request->filters))
                ->whereIn('type_id', $this->typeFilter($request->filters))
                ->whereIn('category_id', $this->categoryFilter($request->filters))
                ->whereIn('sex', $sex)
                ->where('accessibility', 1)
                ->where('show_product', 1) ->distinct()
                ->groupBy('size_id')
                ->pluck('size_id'))->orderBy('min', 'asc') -> orderBy('max', 'asc') -> get();

        }

        if(isset($request->nov_id)) {

            $max = Product::whereIn('id', ProductNovelty::where('nov_id', $request->nov_id) -> pluck('product_id'))
                ->whereIn('season_id', $this->seasonFilter($request->filters))
                ->whereIn('type_id', $this->typeFilter($request->filters))
                ->whereIn('size_id', $this->size2Filter($request->filters))
                ->whereIn('category_id', $this->categoryFilter($request->filters))
                ->whereIn('sex', $sex)
                ->where('accessibility', 1)
                ->where('show_product', 1)
                ->orderBy('prise', 'desc') -> first();

            $min = Product::whereIn('id', ProductNovelty::where('nov_id', $request->nov_id) -> pluck('product_id'))
                ->whereIn('season_id', $this->seasonFilter($request->filters))
                ->whereIn('type_id', $this->typeFilter($request->filters))
                ->whereIn('size_id', $this->size2Filter($request->filters))
                ->whereIn('category_id', $this->categoryFilter($request->filters))
                ->whereIn('sex', $sex)
                ->where('accessibility', 1)
                ->where('show_product', 1)
                ->orderBy('prise', 'asc') -> first();

            $sizes = Size::whereIn('id', Product::whereIn('id', ProductNovelty::where('nov_id', $request->nov_id) -> pluck('product_id'))
                ->whereBetween('prise', [$sizes_min, $sizes_max])
                ->whereIn('season_id', $this->seasonFilter($request->filters))
                ->whereIn('type_id', $this->typeFilter($request->filters))
                ->whereIn('category_id', $this->categoryFilter($request->filters))
                ->whereIn('sex', $sex)
                ->where('accessibility', 1)
                ->where('show_product', 1) ->distinct()
                ->groupBy('size_id')
                ->pluck('size_id'))->orderBy('min', 'asc') -> orderBy('max', 'asc') -> get();

        }

        if(isset($request->category_id)) {
            if($request->category_id == 5) {

                $manufacturersDiscaunt = Manufacturer::whereNotNull('discount')-> where('discount', '!=', '0%')
                    -> where('discount', '!=', '0грн')-> where('discount', '!=', '')-> pluck('id') -> toArray();

                $productsFromManufacturers = Product::whereIn('manufacturer_id', $manufacturersDiscaunt)
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('manufacturer_id', $this->manufacturerFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->whereIn('sex', $sex)
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->pluck('id') -> toArray();


                $productsWithDiscount = Product::whereNotNull('discount', 'or')-> where('discount', '!=', '0%')
                    -> where('discount', '!=', '0грн')-> where('discount', '!=', '')
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('manufacturer_id', $this->manufacturerFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->whereIn('sex', $sex)
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->pluck('id') -> toArray();

                foreach ($productsWithDiscount as $item) {

                    if(!in_array($item, $productsFromManufacturers)) {

                        $productsFromManufacturers[] = $item;

                    }

                }

                $max = Product::whereIn('id', $productsFromManufacturers)
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('manufacturer_id', $this->manufacturerFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->whereIn('sex', $sex)
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->orderBy('prise', 'desc') -> first();

                $min = Product::whereIn('id', $productsFromManufacturers)
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('manufacturer_id', $this->manufacturerFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->whereIn('sex', $sex)
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->orderBy('prise', 'asc') -> first();

                $prods = Product::whereIn('id', $productsFromManufacturers)
                    ->whereBetween('prise', [$sizes_min, $sizes_max])
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('manufacturer_id', $this->manufacturerFilter($request->filters))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->whereIn('sex', $sex)
                    ->where('accessibility', 1)
                    ->where('show_product', 1) ->distinct()
                    ->groupBy('size_id')
                    ->pluck('size_id');

                $sizes = Size::whereIn('id', $prods)->orderBy('min', 'asc') -> orderBy('max', 'asc') -> get();

            } else {

                $max = Product::where('category_id', '=', $request->category_id)
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('manufacturer_id', $this->manufacturerFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->whereIn('sex', $sex)
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->orderBy('prise', 'desc') -> first();

                $min = Product::where('category_id', '=', $request->category_id)
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('manufacturer_id', $this->manufacturerFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->whereIn('sex', $sex)
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->orderBy('prise', 'asc') -> first();

                $sizes = Size::whereIn('id', Product::where('category_id', '=', $request->category_id)
                    ->whereBetween('prise', [$sizes_min, $sizes_max])
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('manufacturer_id', $this->manufacturerFilter($request->filters))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->whereIn('sex', $sex)
                    ->where('accessibility', 1)
                    ->where('show_product', 1) ->distinct()
                    ->groupBy('size_id')
                    ->pluck('size_id'))->orderBy('min', 'asc') -> orderBy('max', 'asc') -> get();
            }
        }

        return response(['minPrice' => $min->prise, 'maxPrice' => $max->prise, 'sizes' => $sizes]);

    }

    public function getProductsToCategory(Request $request){
    	$mans = ManShow::select('manufacturer_id') -> where('user_id', Auth::id()) -> pluck('manufacturer_id');
        $forAll = Manufacturer::where('show_all', 1)->orderBy('name','asc') -> get();
        $showsMan = Manufacturer::where(function ($query) use ($mans) {
            return $query->where('show_all', 1)
                  -> orWhereIn('id', $mans);
        }) -> pluck('id');

        $products = [];
        $sex = $this -> getSex($request -> category_id);

        if($sex == false)
            $sex = $this->sexFilter($request->filters);

        if($sex == false)
            $sex = ['Девочка', 'Мальчик', 'Мужской', 'Женский', 'Унисекс'];

        $orderType = 'desc';
        $order = 'id';

        $sizes_min = 0;
        $sizes_max = 99999;

        if($request->sizes[0]){
            $sizes_min = $request->sizes[0]['sizeValues'][0];
            $sizes_max = $request->sizes[0]['sizeValues'][1];
        }

        $topIds = TopSale::where('top', 1) -> pluck('product_id') -> toArray();

        if(isset($request -> brand_id) && isset($request -> choosedType)) {

            if ($request->choosedType== 0) {

                $products = Product::where('manufacturer_id', '=', $request->brand_id)
                    ->whereBetween('prise', [$sizes_min, $sizes_max])
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->whereIn('sex', $sex)
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->skip($request->count_on_page * ($request->page_num - 1))->take($request->count_on_page);

                $colors = $this->colorFilter($request->filters);

                if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                if($topIds)
                    $products = $this->countryFilter($products, $request->filters)
                        ->orderBy(DB::raw('FIELD(`id`, '.implode(',', $topIds).')'), 'desc')
                        ->orderBy('id', 'desc')
                        ->with('photo', 'size', 'manufacturer')->get();

                else $products = $this->countryFilter($products, $request->filters)
                    ->orderBy('id', 'desc')
                    ->with('photo', 'size', 'manufacturer')->get();

            }

            if ($request->choosedType == 1) {

                $products = Product::where('manufacturer_id', '=', $request->brand_id)
                    ->whereBetween('prise', [$sizes_min, $sizes_max])
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    //->whereIn('id', $this->sizeFilter($request->sizes))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->whereIn('sex', $sex)
                    ->whereBetween('prise', [$sizes_min, $sizes_max]);

                $colors = $this->colorFilter($request->filters);

                if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                $products = $this->countryFilter($products, $request->filters)->orderBy('prise','asc')->pluck('prise', 'id') -> toArray();


                $products = Product::whereIn('id',
                    array_slice(array_keys($products),$request->count_on_page * ($request->page_num - 1),$request->count_on_page))
                    ->with('photo', 'size', 'manufacturer')
                    ->orderBy('prise','asc')
                    ->get();



            }

            if ($request->choosedType == 2) {


                $products = Product::where('manufacturer_id', '=', $request->brand_id)
                    ->whereBetween('prise', [$sizes_min, $sizes_max])
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    //->whereIn('id', $this->sizeFilter($request->sizes))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->whereIn('sex', $sex)
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->whereBetween('prise', [$sizes_min, $sizes_max]);

                $colors = $this->colorFilter($request->filters);

                if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                $products = $this->countryFilter($products, $request->filters)->orderBy('prise','desc')->pluck('prise', 'id') -> toArray();




                $products = Product::whereIn('id',
                    array_slice(array_keys($products),$request->count_on_page * ($request->page_num - 1),$request->count_on_page))
                    ->with('photo', 'size', 'manufacturer')
                    ->orderBy('prise','desc')
                    ->get();

            }
        }

        if(isset($request -> nov_id) && isset($request -> choosedType)) {

            if ($request->choosedType== 0) {

                $products = Product::whereIn('manufacturer_id', $showsMan)
                	->whereIn('id', ProductNovelty::where('nov_id', $request->nov_id) -> pluck('product_id'))
                    ->whereBetween('prise', [$sizes_min, $sizes_max])
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->whereIn('sex', $sex)
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->skip($request->count_on_page * ($request->page_num - 1))->take($request->count_on_page);

                $colors = $this->colorFilter($request->filters);

                if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                if($topIds)
                    $products = $this->countryFilter($products, $request->filters)
                        ->orderBy(DB::raw('FIELD(`id`, '.implode(',', $topIds).')'), 'desc')
                        ->orderBy('id', 'desc')
                        ->with('photo', 'size', 'manufacturer')->get();

                 else $products = $this->countryFilter($products, $request->filters)
                    ->orderBy('id', 'desc')
                    ->with('photo', 'size', 'manufacturer')->get();

            }

            if ($request->choosedType == 1) {

                $products = Product::whereIn('manufacturer_id', $showsMan)
                	->whereIn('id', ProductNovelty::where('nov_id', $request->nov_id) -> pluck('product_id'))
                    ->whereBetween('prise', [$sizes_min, $sizes_max])
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    //->whereIn('id', $this->sizeFilter($request->sizes))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->whereIn('sex', $sex)
                    ->whereBetween('prise', [$sizes_min, $sizes_max]);

                $colors = $this->colorFilter($request->filters);

                if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                $products = $this->countryFilter($products, $request->filters)->orderBy('prise','asc')->pluck('prise', 'id') -> toArray();


                $products = Product::whereIn('id',
                    array_slice(array_keys($products),$request->count_on_page * ($request->page_num - 1),$request->count_on_page))
                    ->with('photo', 'size', 'manufacturer')
                    ->orderBy('prise','asc')
                    ->get();



            }

            if ($request->choosedType == 2) {


                $products = Product::whereIn('manufacturer_id', $showsMan)
                	->whereIn('id', ProductNovelty::where('nov_id', $request->nov_id) -> pluck('product_id'))
                    ->whereBetween('prise', [$sizes_min, $sizes_max])
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    //->whereIn('id', $this->sizeFilter($request->sizes))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->whereIn('sex', $sex)
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->whereBetween('prise', [$sizes_min, $sizes_max]);

                $colors = $this->colorFilter($request->filters);

                if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                $products = $this->countryFilter($products, $request->filters)->orderBy('prise','desc')->pluck('prise', 'id') -> toArray();




                $products = Product::whereIn('id',
                    array_slice(array_keys($products),$request->count_on_page * ($request->page_num - 1),$request->count_on_page))
                    ->with('photo', 'size', 'manufacturer')
                    ->orderBy('prise','desc')
                    ->get();

            }
        }

        if(isset($request -> category_id)) {
            if(isset($request -> choosedType) && ($request->category_id != 5)) {
                if ($request->choosedType== 0) {

                    $products = Product::whereIn('manufacturer_id', $showsMan)
                    	->where('category_id', '=', $request->category_id)
                        ->whereBetween('prise', [$sizes_min, $sizes_max])
                        ->whereIn('season_id', $this->seasonFilter($request->filters))
                        ->whereIn('type_id', $this->typeFilter($request->filters))
                        ->whereIn('manufacturer_id', $this->manufacturerFilter($request->filters))
                        ->whereIn('size_id', $this->size2Filter($request->filters))
                        //->whereIn('id', $this->sizeFilter($request->sizes))
                        ->whereIn('category_id', $this->categoryFilter($request->filters))
                        ->whereIn('sex', $sex)
                        ->where('accessibility', 1)
                        ->where('show_product', 1)
                        ->skip($request->count_on_page * ($request->page_num - 1))->take($request->count_on_page);

                    if ( isset($request -> type_id)) $products -> whereIn('type_id', $request -> type_id);

                    $colors = $this->colorFilter($request->filters);

                    if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                    if($topIds)
                        $products = $this->countryFilter($products, $request->filters)
                            ->orderBy(DB::raw('FIELD(`id`, '.implode(',', $topIds).')'), 'desc')
                            ->orderBy('id', 'desc')
                            ->with('photo', 'size', 'manufacturer')->get();
                    else $products = $this->countryFilter($products, $request->filters)
                            ->orderBy('id', 'desc')
                            ->with('photo', 'size', 'manufacturer')->get();

                }

                if ($request->choosedType == 1) {

                    $products = Product::whereIn('manufacturer_id', $showsMan)
                    	->where('category_id', '=', $request->category_id)
                        ->whereBetween('prise', [$sizes_min, $sizes_max])
                        ->whereIn('season_id', $this->seasonFilter($request->filters))
                        ->whereIn('type_id', $this->typeFilter($request->filters))
                        ->whereIn('manufacturer_id', $this->manufacturerFilter($request->filters))
                        ->whereIn('size_id', $this->size2Filter($request->filters))
                        //->whereIn('id', $this->sizeFilter($request->sizes))
                        ->whereIn('category_id', $this->categoryFilter($request->filters))
                        ->where('accessibility', 1)
                        ->where('show_product', 1)
                        ->whereIn('sex', $sex)
                        ->whereBetween('prise', [$sizes_min, $sizes_max]);

                    if ( isset($request -> type_id)) $products -> whereIn('type_id', $request -> type_id);

                    $colors = $this->colorFilter($request->filters);

                    if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                    $products = $this->countryFilter($products, $request->filters)->orderBy('prise','asc')->pluck('prise', 'id') -> toArray();


                    $products = Product::whereIn('id',
                        array_slice(array_keys($products),$request->count_on_page * ($request->page_num - 1),$request->count_on_page))
                        ->with('photo', 'size', 'manufacturer')
                        ->orderBy('prise','asc')
                        ->get();



                }

                if ($request->choosedType == 2) {

                    $products = Product::whereIn('manufacturer_id', $showsMan)
                    	->where('category_id', '=', $request->category_id)
                        ->whereBetween('prise', [$sizes_min, $sizes_max])
                        ->whereIn('season_id', $this->seasonFilter($request->filters))
                        ->whereIn('type_id', $this->typeFilter($request->filters))
                        ->whereIn('manufacturer_id', $this->manufacturerFilter($request->filters))
                        ->whereIn('size_id', $this->size2Filter($request->filters))
                        //->whereIn('id', $this->sizeFilter($request->sizes))
                        ->whereIn('category_id', $this->categoryFilter($request->filters))
                        ->whereIn('sex', $sex)
                        ->where('accessibility', 1)
                        ->where('show_product', 1)
                        ->whereBetween('prise', [$sizes_min, $sizes_max]);

                    if ( isset($request -> type_id)) $products -> whereIn('type_id', $request -> type_id);

                    $colors = $this->colorFilter($request->filters);

                    if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                    $products = $this->countryFilter($products, $request->filters)->orderBy('prise','desc')->pluck('prise', 'id') -> toArray();

                    $products = Product::whereIn('id',
                        array_slice(array_keys($products),$request->count_on_page * ($request->page_num - 1),$request->count_on_page))
                        ->with('photo', 'size', 'manufacturer')
                        ->orderBy('prise','desc')
                        ->get();

                }
            }


            if($request->category_id == 5) {
                $manufacturersDiscaunt = Manufacturer::whereNotNull('discount')-> where('discount', '!=', '0%')
                    -> where('discount', '!=', '0грн')-> where('discount', '!=', '')-> where('discount', '!=', '0')-> pluck('id') -> toArray();

                $productsFromManufacturers = Product::whereIn('manufacturer_id', $manufacturersDiscaunt)
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->pluck('id') -> toArray();


                $productsWithDiscount = Product::whereNotNull('discount', 'or')-> where('discount', '!=', '0%')
                    -> where('discount', '!=', '0грн')-> where('discount', '!=', '')
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->pluck('id') -> toArray();

                foreach ($productsWithDiscount as $item){

                    if(!in_array($item, $productsFromManufacturers)){

                        $productsFromManufacturers[] = $item;

                    }

                }

                if ($request->choosedType== 0) {

                    $products = Product::whereIn('id', $productsFromManufacturers)
                        ->whereBetween('prise', [$sizes_min, $sizes_max])
                        ->whereIn('season_id', $this->seasonFilter($request->filters))
                        ->whereIn('type_id', $this->typeFilter($request->filters))
                        ->whereIn('manufacturer_id', $this->manufacturerFilter($request->filters))
                        ->whereIn('size_id', $this->size2Filter($request->filters))
                        ->whereIn('category_id', $this->categoryFilter($request->filters))
                        ->whereIn('sex', $sex)
                        ->where('accessibility', 1)
                        ->where('show_product', 1)
                        ->skip($request->count_on_page * ($request->page_num - 1))->take($request->count_on_page);

                    $colors = $this->colorFilter($request->filters);

                    if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                    if($topIds)
                        $products = $this->countryFilter($products, $request->filters)->orderBy(DB::raw('FIELD(`id`, '.implode(',', $topIds).')'), 'desc')->orderBy('id', 'desc')
                            ->with('photo', 'size', 'manufacturer')->get();

                    else
                        $products = $this->countryFilter($products, $request->filters)->orderBy('id', 'desc')
                        ->with('photo', 'size', 'manufacturer')->get();

                }

                if ($request->choosedType == 1) {

                    $products = Product::whereIn('id', $productsFromManufacturers)
                        ->whereBetween('prise', [$sizes_min, $sizes_max])
                        ->whereIn('season_id', $this->seasonFilter($request->filters))
                        ->whereIn('type_id', $this->typeFilter($request->filters))
                        ->whereIn('manufacturer_id', $this->manufacturerFilter($request->filters))
                        ->whereIn('size_id', $this->size2Filter($request->filters))
                        ->whereIn('category_id', $this->categoryFilter($request->filters))
                        ->where('accessibility', 1)
                        ->where('show_product', 1)
                        ->whereIn('sex', $sex)
                        ->whereBetween('prise', [$sizes_min, $sizes_max]);

                    $colors = $this->colorFilter($request->filters);

                    if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                    $products = $this->countryFilter($products, $request->filters)->orderBy('prise','asc')->pluck('prise', 'id') -> toArray();


                    $products = Product::whereIn('id',
                        array_slice(array_keys($products),$request->count_on_page * ($request->page_num - 1),$request->count_on_page))
                        ->with('photo', 'size', 'manufacturer')
                        ->orderBy('prise','asc')
                        ->get();



                }

                if ($request->choosedType == 2) {


                    $products = Product::whereIn('id', $productsFromManufacturers)
                        ->whereBetween('prise', [$sizes_min, $sizes_max])
                        ->whereIn('season_id', $this->seasonFilter($request->filters))
                        ->whereIn('type_id', $this->typeFilter($request->filters))
                        ->whereIn('manufacturer_id', $this->manufacturerFilter($request->filters))
                        ->whereIn('size_id', $this->size2Filter($request->filters))
                        ->whereIn('category_id', $this->categoryFilter($request->filters))
                        ->whereIn('sex', $sex)
                        ->where('accessibility', 1)
                        ->where('show_product', 1)
                        ->whereBetween('prise', [$sizes_min, $sizes_max]);

                    $colors = $this->colorFilter($request->filters);

                    if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                    $products = $this->countryFilter($products, $request->filters)->orderBy('prise','desc')->pluck('prise', 'id') -> toArray();

                    $products = Product::whereIn('id',
                        array_slice(array_keys($products),$request->count_on_page * ($request->page_num - 1),$request->count_on_page))
                        ->with('photo', 'size', 'manufacturer')
                        ->orderBy('prise','desc')
                        ->get();

                }
            }
        }

        $sales = null;
        if (Auth::id()) $sales = SpecSale::where('user_id', Auth::id()) -> get();

        foreach ($products as $product) {

            if ( $sales && $sales -> contains ('manufacturer_id', $product -> manufacturer -> id)) {
                foreach ($sales as $sale) {
                    if ( $sale -> manufacturer_id == $product -> manufacturer -> id)
                        if ( $sale -> percent ) $product -> prise = $product -> prise - ($product -> prise * ( $sale -> percent/100));
                        else if ( $sale -> minus ) $product -> prise = $product -> prise - $sale -> minus;
                }

                $product -> prise = round($product -> prise);
                $product -> specsale = 'specsale';
            }

            $product -> full__price = $product -> prise * $product -> box_count;
            $product -> rostovka__price = $product -> prise * $product -> rostovka_count;

            if($product -> manufacturer ->koorse != "" && $product -> manufacturer ->koorse != 0 && $product->currency == 'дол'){

                $product->prise_default *= $product -> manufacturer ->koorse;
                $product->prise_default = round( $product->prise_default, 2);
            }

            if($product -> manufacturer ->box == 1 ){

                $product->rostovka__price = $product->full__price;
                $product -> rostovka_count = $product -> box_count;

            }
            if($product -> rostovka_count == 0){
                $product -> rostovka_count = $product -> box_count;
            }

            $product -> types = $product -> type -> name;
            $product -> product_url = $product -> category() -> first() -> link . '/' . rawurlencode($product -> name);

            $end = Carbon::parse($product -> created_at);
			$now = Carbon::now();
			$length = $end->diffInDays($now);
			if ( $length <= 7) $product -> prodNew = 'NEW';
			else $product -> prodNew = '';

            if ( $product -> prise_default > $product -> prise) {
                $product -> prodNew = '';
                $product -> prodSale = 'SALE';
            } else $product -> prodSale = '';

            if ( $product -> category_id == 4 ) $product -> names = (object) ['box' => 'в палете', 'rostovka' => 'упаковка'];
            else $product -> names = (object) ['box' => 'в ящике', 'rostovka' => 'минимум'];

            if(!$product -> photo) {
                $product -> photo = '';
            }
        }

        // dd(response($products));
        //return $products;
        return response($products);

    }

    public function getProductsToCategoryTest(Request $request){
      $manufacturersDiscaunt = Manufacturer::whereNotNull('discount')-> where('discount', '!=', '0%')
          -> where('discount', '!=', '0грн')-> where('discount', '!=', '')-> where('discount', '!=', '0')-> pluck('id') -> toArray();

      $productsFromManufacturers = Product::whereIn('manufacturer_id', $manufacturersDiscaunt)
          ->where('accessibility', 1)
          ->where('show_product', 1)
          ->pluck('manufacturer_id') -> toArray();

      $productsWithDiscount = Product::whereNotNull('discount', 'or')-> where('discount', '!=', '0%')
          ->where('discount', '!=', '0грн')->where('discount', '!=', '')
          ->where('accessibility', 1)
          ->where('show_product', 1)
          ->pluck('id') -> toArray();

      foreach ($productsWithDiscount as $item) {

          if(!in_array($item, $productsFromManufacturers)) {

              $productsFromManufacturers[] = $item;

          }

      }


      $products = Product::whereIn('id', $productsFromManufacturers)
          ->where('accessibility', 1)
          ->where('show_product', 1)
          ->get();






    	$mans = ManShow::select('manufacturer_id') -> where('user_id', Auth::id()) -> pluck('manufacturer_id');
        $forAll = Manufacturer::where('show_all', 1)->orderBy('name','asc') -> get();
        $showsMan = Manufacturer::where(function ($query) use ($mans) {
            return $query->where('show_all', 1)
                  -> orWhereIn('id', $mans);
        }) -> pluck('id');

        $products = [];
        $sex = $this -> getSex($request -> category_id);

        if($sex == false)
            $sex = $this->sexFilter($request->filters);

        if($sex == false)
            $sex = ['Девочка', 'Мальчик', 'Мужской', 'Женский', 'Унисекс'];

        $orderType = 'desc';
        $order = 'id';

        $sizes_min = 0;
        $sizes_max = 99999;

        if($request->sizes[0]){
            $sizes_min = $request->sizes[0]['sizeValues'][0];
            $sizes_max = $request->sizes[0]['sizeValues'][1];
        }

        $topIds = TopSale::where('top', 1) -> pluck('product_id') -> toArray();

        if(isset($request -> brand_id) && isset($request -> choosedType)) {

            if ($request->choosedType== 0) {

                $products = Product::where('manufacturer_id', '=', $request->brand_id)
                    ->whereBetween('prise', [$sizes_min, $sizes_max])
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->whereIn('sex', $sex)
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->skip($request->count_on_page * ($request->page_num - 1))->take($request->count_on_page);

                $colors = $this->colorFilter($request->filters);

                if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                if($topIds)
                    $products = $this->countryFilter($products, $request->filters)
                        ->orderBy(DB::raw('FIELD(`id`, '.implode(',', $topIds).')'), 'desc')
                        ->orderBy('id', 'desc')
                        ->with('photo', 'size', 'manufacturer')->get();

                else $products = $this->countryFilter($products, $request->filters)
                    ->orderBy('id', 'desc')
                    ->with('photo', 'size', 'manufacturer')->get();

            }

            if ($request->choosedType == 1) {

                $products = Product::where('manufacturer_id', '=', $request->brand_id)
                    ->whereBetween('prise', [$sizes_min, $sizes_max])
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    //->whereIn('id', $this->sizeFilter($request->sizes))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->whereIn('sex', $sex)
                    ->whereBetween('prise', [$sizes_min, $sizes_max]);

                $colors = $this->colorFilter($request->filters);

                if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                $products = $this->countryFilter($products, $request->filters)->orderBy('prise','asc')->pluck('prise', 'id') -> toArray();


                $products = Product::whereIn('id',
                    array_slice(array_keys($products),$request->count_on_page * ($request->page_num - 1),$request->count_on_page))
                    ->with('photo', 'size', 'manufacturer')
                    ->orderBy('prise','asc')
                    ->get();



            }

            if ($request->choosedType == 2) {


                $products = Product::where('manufacturer_id', '=', $request->brand_id)
                    ->whereBetween('prise', [$sizes_min, $sizes_max])
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    //->whereIn('id', $this->sizeFilter($request->sizes))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->whereIn('sex', $sex)
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->whereBetween('prise', [$sizes_min, $sizes_max]);

                $colors = $this->colorFilter($request->filters);

                if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                $products = $this->countryFilter($products, $request->filters)->orderBy('prise','desc')->pluck('prise', 'id') -> toArray();




                $products = Product::whereIn('id',
                    array_slice(array_keys($products),$request->count_on_page * ($request->page_num - 1),$request->count_on_page))
                    ->with('photo', 'size', 'manufacturer')
                    ->orderBy('prise','desc')
                    ->get();

            }
        }

        if(isset($request -> nov_id) && isset($request -> choosedType)) {

            if ($request->choosedType== 0) {

                $products = Product::whereIn('manufacturer_id', $showsMan)
                	->whereIn('id', ProductNovelty::where('nov_id', $request->nov_id) -> pluck('product_id'))
                    ->whereBetween('prise', [$sizes_min, $sizes_max])
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->whereIn('sex', $sex)
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->skip($request->count_on_page * ($request->page_num - 1))->take($request->count_on_page);

                $colors = $this->colorFilter($request->filters);

                if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                if($topIds)
                    $products = $this->countryFilter($products, $request->filters)
                        ->orderBy(DB::raw('FIELD(`id`, '.implode(',', $topIds).')'), 'desc')
                        ->orderBy('id', 'desc')
                        ->with('photo', 'size', 'manufacturer')->get();

                 else $products = $this->countryFilter($products, $request->filters)
                    ->orderBy('id', 'desc')
                    ->with('photo', 'size', 'manufacturer')->get();

            }

            if ($request->choosedType == 1) {

                $products = Product::whereIn('manufacturer_id', $showsMan)
                	->whereIn('id', ProductNovelty::where('nov_id', $request->nov_id) -> pluck('product_id'))
                    ->whereBetween('prise', [$sizes_min, $sizes_max])
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    //->whereIn('id', $this->sizeFilter($request->sizes))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->whereIn('sex', $sex)
                    ->whereBetween('prise', [$sizes_min, $sizes_max]);

                $colors = $this->colorFilter($request->filters);

                if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                $products = $this->countryFilter($products, $request->filters)->orderBy('prise','asc')->pluck('prise', 'id') -> toArray();


                $products = Product::whereIn('id',
                    array_slice(array_keys($products),$request->count_on_page * ($request->page_num - 1),$request->count_on_page))
                    ->with('photo', 'size', 'manufacturer')
                    ->orderBy('prise','asc')
                    ->get();



            }

            if ($request->choosedType == 2) {


                $products = Product::whereIn('manufacturer_id', $showsMan)
                	->whereIn('id', ProductNovelty::where('nov_id', $request->nov_id) -> pluck('product_id'))
                    ->whereBetween('prise', [$sizes_min, $sizes_max])
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    //->whereIn('id', $this->sizeFilter($request->sizes))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->whereIn('sex', $sex)
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->whereBetween('prise', [$sizes_min, $sizes_max]);

                $colors = $this->colorFilter($request->filters);

                if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                $products = $this->countryFilter($products, $request->filters)->orderBy('prise','desc')->pluck('prise', 'id') -> toArray();




                $products = Product::whereIn('id',
                    array_slice(array_keys($products),$request->count_on_page * ($request->page_num - 1),$request->count_on_page))
                    ->with('photo', 'size', 'manufacturer')
                    ->orderBy('prise','desc')
                    ->get();

            }
        }

        if(isset($request -> category_id)) {
            if(isset($request -> choosedType) && ($request->category_id != 5)) {
                if ($request->choosedType== 0) {

                    $products = Product::whereIn('manufacturer_id', $showsMan)
                    	->where('category_id', '=', $request->category_id)
                        ->whereBetween('prise', [$sizes_min, $sizes_max])
                        ->whereIn('season_id', $this->seasonFilter($request->filters))
                        ->whereIn('type_id', $this->typeFilter($request->filters))
                        ->whereIn('manufacturer_id', $this->manufacturerFilter($request->filters))
                        ->whereIn('size_id', $this->size2Filter($request->filters))
                        //->whereIn('id', $this->sizeFilter($request->sizes))
                        ->whereIn('category_id', $this->categoryFilter($request->filters))
                        ->whereIn('sex', $sex)
                        ->where('accessibility', 1)
                        ->where('show_product', 1)
                        ->skip($request->count_on_page * ($request->page_num - 1))->take($request->count_on_page);

                    if ( isset($request -> type_id)) $products -> whereIn('type_id', $request -> type_id);

                    $colors = $this->colorFilter($request->filters);

                    if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                    if($topIds)
                        $products = $this->countryFilter($products, $request->filters)
                            ->orderBy(DB::raw('FIELD(`id`, '.implode(',', $topIds).')'), 'desc')
                            ->orderBy('id', 'desc')
                            ->with('photo', 'size', 'manufacturer')->get();
                    else $products = $this->countryFilter($products, $request->filters)
                            ->orderBy('id', 'desc')
                            ->with('photo', 'size', 'manufacturer')->get();

                }

                if ($request->choosedType == 1) {

                    $products = Product::whereIn('manufacturer_id', $showsMan)
                    	->where('category_id', '=', $request->category_id)
                        ->whereBetween('prise', [$sizes_min, $sizes_max])
                        ->whereIn('season_id', $this->seasonFilter($request->filters))
                        ->whereIn('type_id', $this->typeFilter($request->filters))
                        ->whereIn('manufacturer_id', $this->manufacturerFilter($request->filters))
                        ->whereIn('size_id', $this->size2Filter($request->filters))
                        //->whereIn('id', $this->sizeFilter($request->sizes))
                        ->whereIn('category_id', $this->categoryFilter($request->filters))
                        ->where('accessibility', 1)
                        ->where('show_product', 1)
                        ->whereIn('sex', $sex)
                        ->whereBetween('prise', [$sizes_min, $sizes_max]);

                    if ( isset($request -> type_id)) $products -> whereIn('type_id', $request -> type_id);

                    $colors = $this->colorFilter($request->filters);

                    if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                    $products = $this->countryFilter($products, $request->filters)->orderBy('prise','asc')->pluck('prise', 'id') -> toArray();


                    $products = Product::whereIn('id',
                        array_slice(array_keys($products),$request->count_on_page * ($request->page_num - 1),$request->count_on_page))
                        ->with('photo', 'size', 'manufacturer')
                        ->orderBy('prise','asc')
                        ->get();



                }

                if ($request->choosedType == 2) {

                    $products = Product::whereIn('manufacturer_id', $showsMan)
                    	->where('category_id', '=', $request->category_id)
                        ->whereBetween('prise', [$sizes_min, $sizes_max])
                        ->whereIn('season_id', $this->seasonFilter($request->filters))
                        ->whereIn('type_id', $this->typeFilter($request->filters))
                        ->whereIn('manufacturer_id', $this->manufacturerFilter($request->filters))
                        ->whereIn('size_id', $this->size2Filter($request->filters))
                        //->whereIn('id', $this->sizeFilter($request->sizes))
                        ->whereIn('category_id', $this->categoryFilter($request->filters))
                        ->whereIn('sex', $sex)
                        ->where('accessibility', 1)
                        ->where('show_product', 1)
                        ->whereBetween('prise', [$sizes_min, $sizes_max]);

                    if ( isset($request -> type_id)) $products -> whereIn('type_id', $request -> type_id);

                    $colors = $this->colorFilter($request->filters);

                    if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                    $products = $this->countryFilter($products, $request->filters)->orderBy('prise','desc')->pluck('prise', 'id') -> toArray();

                    $products = Product::whereIn('id',
                        array_slice(array_keys($products),$request->count_on_page * ($request->page_num - 1),$request->count_on_page))
                        ->with('photo', 'size', 'manufacturer')
                        ->orderBy('prise','desc')
                        ->get();

                }
            }


            if($request->category_id == 5) {
                $manufacturersDiscaunt = Manufacturer::whereNotNull('discount')-> where('discount', '!=', '0%')
                    -> where('discount', '!=', '0грн')-> where('discount', '!=', '')-> pluck('id') -> toArray();

                $productsFromManufacturers = Product::whereIn('manufacturer_id', $manufacturersDiscaunt)
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->pluck('id') -> toArray();


                $productsWithDiscount = Product::whereNotNull('discount', 'or')-> where('discount', '!=', '0%')
                    ->where('discount', '!=', '0грн')->where('discount', '!=', '')
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->pluck('id') -> toArray();

                foreach ($productsWithDiscount as $item) {

                    if(!in_array($item, $productsFromManufacturers)) {

                        $productsFromManufacturers[] = $item;

                    }

                }

                if ($request->choosedType== 0) {

                    $products = Product::whereIn('id', $productsFromManufacturers)
                        ->whereBetween('prise', [$sizes_min, $sizes_max])
                        ->whereIn('season_id', $this->seasonFilter($request->filters))
                        ->whereIn('type_id', $this->typeFilter($request->filters))
                        ->whereIn('manufacturer_id', $this->manufacturerFilter($request->filters))
                        ->whereIn('size_id', $this->size2Filter($request->filters))
                        ->whereIn('category_id', $this->categoryFilter($request->filters))
                        ->whereIn('sex', $sex)
                        ->where('accessibility', 1)
                        ->where('show_product', 1)
                        ->skip($request->count_on_page * ($request->page_num - 1))->take($request->count_on_page);

                    $colors = $this->colorFilter($request->filters);

                    if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                    if($topIds)
                        $products = $this->countryFilter($products, $request->filters)->orderBy(DB::raw('FIELD(`id`, '.implode(',', $topIds).')'), 'desc')->orderBy('id', 'desc')
                            ->with('photo', 'size', 'manufacturer')->get();

                    else
                        $products = $this->countryFilter($products, $request->filters)->orderBy('id', 'desc')
                        ->with('photo', 'size', 'manufacturer')->get();

                }

                if ($request->choosedType == 1) {

                    $products = Product::whereIn('id', $productsFromManufacturers)
                        ->whereBetween('prise', [$sizes_min, $sizes_max])
                        ->whereIn('season_id', $this->seasonFilter($request->filters))
                        ->whereIn('type_id', $this->typeFilter($request->filters))
                        ->whereIn('manufacturer_id', $this->manufacturerFilter($request->filters))
                        ->whereIn('size_id', $this->size2Filter($request->filters))
                        ->whereIn('category_id', $this->categoryFilter($request->filters))
                        ->where('accessibility', 1)
                        ->where('show_product', 1)
                        ->whereIn('sex', $sex)
                        ->whereBetween('prise', [$sizes_min, $sizes_max]);

                    $colors = $this->colorFilter($request->filters);

                    if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                    $products = $this->countryFilter($products, $request->filters)->orderBy('prise','asc')->pluck('prise', 'id') -> toArray();


                    $products = Product::whereIn('id',
                        array_slice(array_keys($products),$request->count_on_page * ($request->page_num - 1),$request->count_on_page))
                        ->with('photo', 'size', 'manufacturer')
                        ->orderBy('prise','asc')
                        ->get();



                }

                if ($request->choosedType == 2) {


                    $products = Product::whereIn('id', $productsFromManufacturers)
                        ->whereBetween('prise', [$sizes_min, $sizes_max])
                        ->whereIn('season_id', $this->seasonFilter($request->filters))
                        ->whereIn('type_id', $this->typeFilter($request->filters))
                        ->whereIn('manufacturer_id', $this->manufacturerFilter($request->filters))
                        ->whereIn('size_id', $this->size2Filter($request->filters))
                        ->whereIn('category_id', $this->categoryFilter($request->filters))
                        ->whereIn('sex', $sex)
                        ->where('accessibility', 1)
                        ->where('show_product', 1)
                        ->whereBetween('prise', [$sizes_min, $sizes_max]);

                    $colors = $this->colorFilter($request->filters);

                    if ( $colors )
                    $products = $products -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                    $products = $this->countryFilter($products, $request->filters)->orderBy('prise','desc')->pluck('prise', 'id') -> toArray();

                    $products = Product::whereIn('id',
                        array_slice(array_keys($products),$request->count_on_page * ($request->page_num - 1),$request->count_on_page))
                        ->with('photo', 'size', 'manufacturer')
                        ->orderBy('prise','desc')
                        ->get();

                }
            }
        }

        $sales = null;
        if (Auth::id()) $sales = SpecSale::where('user_id', Auth::id()) -> get();

        foreach ($products as $product) {

            if ( $sales && $sales -> contains ('manufacturer_id', $product -> manufacturer -> id)) {
                foreach ($sales as $sale) {
                    if ( $sale -> manufacturer_id == $product -> manufacturer -> id)
                        if ( $sale -> percent ) $product -> prise = $product -> prise - ($product -> prise * ( $sale -> percent/100));
                        else if ( $sale -> minus ) $product -> prise = $product -> prise - $sale -> minus;
                }

                $product -> prise = round($product -> prise);
                $product -> specsale = 'specsale';
            }

            $product -> full__price = $product -> prise * $product -> box_count;
            $product -> rostovka__price = $product -> prise * $product -> rostovka_count;

            if($product -> manufacturer ->koorse != "" && $product -> manufacturer ->koorse != 0 && $product->currency == 'дол'){

                $product->prise_default *= $product -> manufacturer ->koorse;
                $product->prise_default = round( $product->prise_default, 2);
            }

            if($product -> manufacturer ->box == 1 ){

                $product->rostovka__price = $product->full__price;
                $product -> rostovka_count = $product -> box_count;

            }
            if($product -> rostovka_count == 0){
                $product -> rostovka_count = $product -> box_count;
            }

            $product -> types = $product -> type -> name;
            $product -> product_url = $product -> category() -> first() -> link . '/' . rawurlencode($product -> name);

            $end = Carbon::parse($product -> created_at);
			$now = Carbon::now();
			$length = $end->diffInDays($now);
			if ( $length <= 7) $product -> prodNew = 'NEW';
			else $product -> prodNew = '';

            if ( $product -> prise_default > $product -> prise) {
                $product -> prodNew = '';
                $product -> prodSale = 'SALE';
            } else $product -> prodSale = '';

            if ( $product -> category_id == 4 ) $product -> names = (object) ['box' => 'в палете', 'rostovka' => 'упаковка'];
            else $product -> names = (object) ['box' => 'в ящике', 'rostovka' => 'минимум'];

            if(!$product -> photo) {
                $product -> photo = '';
            }
        }

        // dd(response($products));
        //return $products;
        return response($products);

    }

    protected function getSex($category_id){

        if($category_id == 2)
            return array('Мужской');
        if($category_id == 3)
            return array('Женский');

        return false;

    }

    protected function sexFilter($filters){

        $sexs = [];
        if($filters && !empty($filters)) {
            foreach ($filters as $filter) {

                if ($filter[2] == 'sex') {

                    $sexs[] = $filter[1];

                }

            }
        }
        if($sexs)

            return $sexs;

        else return false;

    }

    protected function sizeFilter($filters){

        $sizes_min = 0;
        $sizes_max = 0;

        if($filters[0]){
            $sizes_min = $filters[0]['sizeValues'][0];
            $sizes_max = $filters[0]['sizeValues'][1];
        }

        if($sizes_min != 0 && $sizes_max != 0){

            return Product::whereBetween('prise', [$sizes_min, $sizes_max])
                ->pluck('id');
        }

        return Product::all() ->pluck('id');

    }


    protected function seasonFilter($filters){
        $seasons = [];
        if($filters && !empty($filters)) {
            foreach ($filters as $filter) {

                if ($filter[2] == 'season') {

                    $seasons[] = $filter[1];

                }

            }
        }
        if($seasons){
            return Season::whereIn('name', $seasons) -> pluck('id');
        }
        return Season::all() -> pluck('id');
    }

    protected function colorFilter($filters){
        $colors = [];
        if($filters && !empty($filters)) {
            foreach ($filters as $filter) {

                if ($filter[2] == 'color') {

                    $colors[] = $filter[1];

                }

            }
        }

        if($colors) {

        	$colors = Color::whereIn('name', $colors) -> pluck('words');
            return $this -> arrToColors ( $colors );
        }

        return false;
    }

    protected function arrToColors($colors) {
    	$tmpColors = [];

        foreach ($colors as $color) {
            $color = mb_strtolower($color);
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
        return array_unique($tmpColors);
    }

    protected function size2Filter($filters){
        $sizes = [];
        if($filters  && !empty($filters)) {
            foreach ($filters as $filter) {

                if ($filter[2] == 'size') {

                    $sizes[] = $filter[1];

                }

            }
        }

        if($sizes){
            return Size::whereIn('name', $sizes) -> pluck('id');
        }

        return Size::all() -> pluck('id');
    }

    protected function typeFilter($filters){
        $types = [];
        if($filters  && !empty($filters)) {
            foreach ($filters as $filter) {

                if ($filter[2] == 'tip') {

                    $types[] = $filter[1];

                }

            }
        }

        if($types){
            return Type::whereIn('name', $types) -> pluck('id');
        }

        return Type::all() -> pluck('id');
    }

    protected function categoryFilter($filters){
        $categories = [];
        if($filters  && !empty($filters)) {
            foreach ($filters as $filter) {

                if ($filter[2] == 'category') {

                    $categories[] = $filter[1];

                }

            }
        }

        if($categories){
            return Category::whereIn('name', $categories) -> pluck('id');
        }

        return Category::all() -> pluck('id');
    }

    protected function manufacturerFilter($filters){
        $manufacturers = [];
        if($filters  && !empty($filters)) {
            foreach ($filters as $filter) {

                if ($filter[2] == 'manufacturers') {

                    $manufacturers[] = $filter[1];

                }

            }
        }

        if($manufacturers){
            return Manufacturer::whereIn('name', $manufacturers) -> pluck('id');
        }
        return Manufacturer::all() -> pluck('id');
    }

    protected function countryFilter($products, $filters){
        $countries = [];
        if($filters  && !empty($filters)) {
            foreach ($filters as $filter) {

                if ($filter[2] == 'countries') {

                    $countries[] = $filter[1];

                }

            }
        }

        if($countries){
            return $products->whereIn('manufacturer_country', $countries);
        }
        return $products;
    }

    public function getPaginationPageCount(Request $request){

        $sex = $this -> getSex($request -> category_id);

        if($sex == false)
            $sex = $this->sexFilter($request->filters);

        if($sex == false)
            $sex = ['Девочка', 'Мальчик', 'Мужской', 'Женский', 'Унисекс'];

        $sizes_min = 0;
        $sizes_max = 99999;

        if($request->sizes[0]){
            $sizes_min = $request->sizes[0]['sizeValues'][0];
            $sizes_max = $request->sizes[0]['sizeValues'][1];
        }

        $products_count = 0;

        if(isset($request->category_id)) {
            if($sex == null) {
                $products_count = Product::where('category_id', '=', $request->category_id)
                    ->whereBetween('prise', [$sizes_min, $sizes_max])
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('manufacturer_id', $this->manufacturerFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->where('sex', "!=",'');

                if ( isset($request -> type_id)) $products_count -> whereIn('type_id', $request -> type_id);

                $colors = $this->colorFilter($request->filters);

                if ( $colors )
                    $products_count = $products_count -> Where(function ($query) use($colors) {
    		            foreach ( $colors as $color ) {
    		            	$query->orwhere('color', 'like',  '%' . $color .'%');
    		            }
    		        });

                $products_count = $this->countryFilter($products_count, $request->filters) -> count();
            }
            else {
                $products_count = Product::where('category_id', '=', $request->category_id)
                    ->whereBetween('prise', [$sizes_min, $sizes_max])
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('manufacturer_id', $this->manufacturerFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->whereIn('sex', $sex);

                if ( isset($request -> type_id)) $products_count -> whereIn('type_id', $request -> type_id);

                $colors = $this->colorFilter($request->filters);

                if ( $colors )
                    $products_count = $products_count -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                $products_count = $this->countryFilter($products_count, $request->filters)-> count();
            }


            if($request->category_id == 5){

                $manufacturersDiscaunt = Manufacturer::whereNotNull('discount')-> where('discount', '!=', '0%')
                    -> where('discount', '!=', '0грн')-> where('discount', '!=', '')-> pluck('id') -> toArray();

                $productsFromManufacturers = Product::whereIn('manufacturer_id', $manufacturersDiscaunt)
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->pluck('id') -> toArray();


                $productsWithDiscount = Product::whereNotNull('discount', 'or')-> where('discount', '!=', '0%')
                    -> where('discount', '!=', '0грн')-> where('discount', '!=', '')
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->pluck('id') -> toArray();

                foreach ($productsWithDiscount as $item){

                    if(!in_array($item, $productsFromManufacturers)){

                        $productsFromManufacturers[] = $item;

                    }

                }

                $products_count = Product::whereIn('id', $productsFromManufacturers)
                    ->whereBetween('prise', [$sizes_min, $sizes_max])
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('manufacturer_id', $this->manufacturerFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->whereIn('sex', $sex);

                if ( isset($request -> type_id)) $products_count -> whereIn('type_id', $request -> type_id);

                $colors = $this->colorFilter($request->filters);

                if ( $colors )
                    $products_count = $products_count -> Where(function ($query) use($colors) {
                        foreach ( $colors as $color ) {
                            $query->orwhere('color', 'like',  '%' . $color .'%');
                        }
                    });

                $products_count = $this->countryFilter($products_count, $request->filters) -> count();

            }

        }

        if(isset($request->brand_id)) {
            if($sex == null) {

                $products_count = Product::where('manufacturer_id', '=', $request->brand_id)
                    ->whereBetween('prise', [$sizes_min, $sizes_max])
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    ->where('accessibility', 1)
                    ->where('show_product', 1);

            } else {

                $products_count = Product::where('manufacturer_id', '=', $request->brand_id)
                    ->whereBetween('prise', [$sizes_min, $sizes_max])
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->whereIn('sex', $sex);

            }

            $colors = $this->colorFilter($request->filters);

            if ( $colors )
                $products_count = $products_count -> Where(function ($query) use($colors) {
                    foreach ( $colors as $color ) {
                        $query->orwhere('color', 'like',  '%' . $color .'%');
                    }
                });

            $products_count = $this->countryFilter($products_count, $request->filters)-> count();

        }

        if(isset($request->nov_id)) {

            if($sex == null) {

                $products_count = Product::whereIn('id', ProductNovelty::where('nov_id', $request->nov_id) -> pluck('product_id'))
                    ->whereBetween('prise', [$sizes_min, $sizes_max])
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    ->where('accessibility', 1)
                    ->where('show_product', 1);

            } else {

                $products_count = Product::whereIn('id', ProductNovelty::where('nov_id', $request->nov_id) -> pluck('product_id'))
                    ->whereBetween('prise', [$sizes_min, $sizes_max])
                    ->whereIn('season_id', $this->seasonFilter($request->filters))
                    ->whereIn('type_id', $this->typeFilter($request->filters))
                    ->whereIn('category_id', $this->categoryFilter($request->filters))
                    ->whereIn('size_id', $this->size2Filter($request->filters))
                    ->where('accessibility', 1)
                    ->where('show_product', 1)
                    ->whereIn('sex', $sex);

            }

            $colors = $this->colorFilter($request->filters);

            if ( $colors )
                $products_count = $products_count -> Where(function ($query) use($colors) {
                    foreach ( $colors as $color ) {
                        $query->orwhere('color', 'like',  '%' . $color .'%');
                    }
                });

            $products_count = $this->countryFilter($products_count, $request->filters)-> count();
        }

//        dd([$products_count, $request ->count_on_page]);
        $count_of_page = $products_count / $request ->count_on_page;

        return ceil($count_of_page);

    }


    public function getNewsProduct(){
    	$mans = ManShow::select('manufacturer_id') -> where('user_id', Auth::id()) -> pluck('manufacturer_id');
        $forAll = Manufacturer::where('show_all', 1)->orderBy('name','asc') -> get();
        $showsMan = Manufacturer::where(function ($query) use ($mans) {
            return $query->where('show_all', 1)
                  -> orWhereIn('id', $mans);
        }) -> pluck('id');

        $products = Product::take(12) ->with('photo','size','manufacturer')
            ->where('accessibility', 1)
            ->where('show_product', 1)
            ->whereIn('manufacturer_id', $showsMan)
            ->orderBy('id', 'desc') -> get();
        //$products = Product::take(10)  -> get();

        $sales = null;
        if (Auth::id()) $sales = SpecSale::where('user_id', Auth::id()) -> get();

        foreach ($products as $product) {

            if ( $sales && $sales -> contains ('manufacturer_id', $product -> manufacturer -> id)) {
                foreach ($sales as $sale) {
                    if ( $sale -> manufacturer_id == $product -> manufacturer -> id)
                        if ( $sale -> percent ) $product -> prise = $product -> prise - ($product -> prise * ( $sale -> percent/100));
                        else if ( $sale -> minus ) $product -> prise = $product -> prise - $sale -> minus;
                }

                $product -> prise = round($product -> prise);
                $product -> specsale = 'specsale';
            }

            $product -> full__price = $product -> prise * $product -> box_count;
            $product -> rostovka__price = $product -> prise * $product -> rostovka_count;

            if($product -> manufacturer ->koorse != "" && $product -> manufacturer ->koorse != 0 && $product->currency == 'дол'){

                $product->prise_default *= $product -> manufacturer ->koorse;
                $product->prise_default = round( $product->prise_default, 2);
            }

            if($product -> manufacturer ->box == 1 ){

                $product->rostovka__price = $product->full__price;
                $product -> rostovka_count = $product -> box_count;

            }

            $product -> types = $product -> type -> name;
            $product -> product_url = $product -> category() -> first() -> link . '/' . rawurlencode($product -> name);

            $end = Carbon::parse($product -> created_at);
			$now = Carbon::now();
			$length = $end->diffInDays($now);
			if ( $length <= 7) $product -> prodNew = 'NEW';
			else $product -> prodNew = '';

            if ( $product -> prise_default > $product -> prise) {
                $product -> prodNew = '';
                $product -> prodSale = 'SALE';
            } else $product -> prodSale = '';

            if ( $product -> category_id == 4 ) $product -> names = (object) ['box' => 'в палете', 'rostovka' => 'упаковка'];
            else $product -> names = (object) ['box' => 'в ящике', 'rostovka' => 'минимум'];
        }

        return $products;

    }

    public function getProduct(Request $request){

        $product = Product::with('photo')  ->find($request->id);

        if ($product) {
            $sales = null;
            if (Auth::id()) $sales = SpecSale::where('user_id', Auth::id()) -> get();
            if ( $sales && $sales -> contains ('manufacturer_id', $product -> manufacturer -> id)) {
                foreach ($sales as $sale) {
                    if ( $sale -> manufacturer_id == $product -> manufacturer -> id)
                        if ( $sale -> percent ) $product -> prise = $product -> prise - ($product -> prise * ( $sale -> percent/100));
                        else if ( $sale -> minus ) $product -> prise = $product -> prise - $sale -> minus;
                }

                $product -> prise = round($product -> prise);
                $product -> specsale = 'specsale';
            }

            $product ->size = $product -> size -> name;
            $product -> full__price = $product -> prise * $product -> box_count;
            $product -> rostovka__price = $product -> prise * $product -> rostovka_count;
            $product -> types = $product -> type -> name;
            $product -> product_url = $product -> category() -> first() -> link . '/' . rawurlencode($product -> name);

            if ( $product -> category_id == 4 ) $product -> names = (object) ['box' => 'в палете', 'rostovka' => 'упаковка'];
            else $product -> names = (object) ['box' => 'в ящике', 'rostovka' => 'минимум'];
        }

        return $product;
    }

    public function checkCardProducts(Request $request){

        $products = Product::with('photo')  -> whereIn('id', $request->ids) -> get();
        foreach ($products as $product) {
            $sales = null;
            if (Auth::id()) $sales = SpecSale::where('user_id', Auth::id()) -> get();
            if ( $sales && $sales -> contains ('manufacturer_id', $product -> manufacturer -> id)) {
                foreach ($sales as $sale) {
                    if ( $sale -> manufacturer_id == $product -> manufacturer -> id)
                        if ( $sale -> percent ) $product -> prise = $product -> prise - ($product -> prise * ( $sale -> percent/100));
                        else if ( $sale -> minus ) $product -> prise = $product -> prise - $sale -> minus;
                }

                $product -> prise = round($product -> prise);
                $product -> specsale = 'specsale';
            }

            $product ->size = $product -> size -> name;
            $product -> full__price = $product -> prise * $product -> box_count;
            $product -> rostovka__price = $product -> prise * $product -> rostovka_count;
            $product -> types = $product -> type -> name;
            $product -> product_url = $product -> category() -> first() -> link . '/' . rawurlencode($product -> name);

            if ( $product -> category_id == 4 ) $product -> names = (object) ['box' => 'в палете', 'rostovka' => 'упаковка'];
            else $product -> names = (object) ['box' => 'в ящике', 'rostovka' => 'минимум'];
        }
        return $products;
    }

    public function showByFilter($link, $post) {
        $category = Category::where('link', $link) -> first();

        if($category) {
            //if ($category -> id != 4) {
                $types = explode(',', $post);
                if (count($types) > 0) {
                    $typeFilter = Type::whereIn('name', $types) -> get();
                    return view('user.filters.index', compact('category', 'typeFilter'));
                } else return view('user.category_page.category', compact('category'));
            //} else return view('user.category_page.category', compact('category'));
        }else return abort(404);
    }

    public function filterProduct($name){

    	$mans = ManShow::select('manufacturer_id') -> where('user_id', Auth::id()) -> pluck('manufacturer_id');
        $forAll = Manufacturer::where('show_all', 1)->orderBy('name','asc') -> get();
        $showsMan = Manufacturer::where(function ($query) use ($mans) {
            return $query->where('show_all', 1)
                  -> orWhereIn('id', $mans);
        }) -> pluck('id');

        $products = Product::whereIn('manufacturer_id', $showsMan)
        	->where('name', 'like', "%".$name."%")
            ->with('photo', 'size', 'manufacturer')
            ->where('accessibility', 1)
            ->where('show_product', 1)
            ->orderBy('id',"desc")->paginate(16);

        $sales = null;
        if (Auth::id()) $sales = SpecSale::where('user_id', Auth::id()) -> get();

        foreach ($products as $product) {

            if ( $sales && $sales -> contains ('manufacturer_id', $product -> manufacturer -> id)) {
                foreach ($sales as $sale) {
                    if ( $sale -> manufacturer_id == $product -> manufacturer -> id)
                        if ( $sale -> percent ) $product -> prise = $product -> prise - ($product -> prise * ( $sale -> percent/100));
                        else if ( $sale -> minus ) $product -> prise = $product -> prise - $sale -> minus;
                }

                $product -> prise = round($product -> prise);
                $product -> specsale = 'specsale';
            }

            if($product -> manufacturer ->koorse != "" && $product -> manufacturer ->koorse != 0  && $product->currency == 'дол'){

               $product->prise_default *= $product -> manufacturer ->koorse;
                $product->prise_default = round( $product->prise_default, 2);
            }

            $product -> full__price = $product -> prise * $product -> box_count;
            $product -> rostovka__price = $product -> prise * $product -> rostovka_count;

            if($product -> manufacturer ->box == 1 ){

                $product->rostovka__price = $product->full__price;
                $product -> rostovka_count = $product -> box_count;

            }


            $product -> types = $product -> type -> name;
            $product -> product_url = $product -> category() -> first() -> link . '/' . rawurlencode($product -> name);

        	$end = Carbon::parse($product -> created_at);
			$now = Carbon::now();
			$length = $end->diffInDays($now);
			if ( $length <= 7) $product -> prodNew = 'NEW';
			else $product -> prodNew = '';

            if ( $product -> prise_default > $product -> prise) {
                $product -> prodNew = '';
                $product -> prodSale = 'SALE';
            } else $product -> prodSale = '';

            if ( $product -> category_id == 4 ) $product -> names = (object) ['box' => 'в палете', 'rostovka' => 'упаковка'];
            else $product -> names = (object) ['box' => 'в ящике', 'rostovka' => 'минимум'];
        }

        return view('user.search.search', compact('products', 'name'));

    }

    public function stylesFilterProduct($name){

        $products = Product::where('name', 'like', "%".$name."%")
            ->with('photo', 'size', 'manufacturer')
            ->where('accessibility', 1)
            ->where('show_product', 1)
            ->orderBy('id',"desc")->paginate(16);

        $sales = null;
        if (Auth::id()) $sales = SpecSale::where('user_id', Auth::id()) -> get();

        foreach ($products as $product) {

            if ( $sales && $sales -> contains ('manufacturer_id', $product -> manufacturer -> id)) {
                foreach ($sales as $sale) {
                    if ( $sale -> manufacturer_id == $product -> manufacturer -> id)
                        if ( $sale -> percent ) $product -> prise = $product -> prise - ($product -> prise * ( $sale -> percent/100));
                        else if ( $sale -> minus ) $product -> prise = $product -> prise - $sale -> minus;
                }

                $product -> prise = round($product -> prise);
                $product -> specsale = 'specsale';
            }

            if($product -> manufacturer ->koorse != "" && $product -> manufacturer ->koorse != 0  && $product->currency == 'дол'){

               $product->prise_default *= $product -> manufacturer ->koorse;
                $product->prise_default = round( $product->prise_default, 2);
            }

            $product -> full__price = $product -> prise * $product -> box_count;
            $product -> rostovka__price = $product -> prise * $product -> rostovka_count;

            if($product -> manufacturer ->box == 1 ){

                $product->rostovka__price = $product->full__price;
                $product -> rostovka_count = $product -> box_count;

            }


            $product -> types = $product -> type -> name;
            $product -> product_url = $product -> category() -> first() -> link . '/' . rawurlencode($product -> name);

            if ( $product -> category_id == 4 ) $product -> names = (object) ['box' => 'в палете', 'rostovka' => 'упаковка'];
            else $product -> names = (object) ['box' => 'в ящике', 'rostovka' => 'минимум'];
        }

        return view('user.search.search1', compact('products', 'name'));

    }

}
