<?php

namespace App\Http\Controllers;

use App\Manufacturer;
use App\Product;
use App\ProductNovelty;
use App\Season;
use App\Size;
use App\Type;
use App\Color;
use App\Category;
use App\ManShow;
use Auth;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function getFiltersValues($view){


        if ( $view -> category -> id != 5 ) {

            $mans = ManShow::select('manufacturer_id') -> where('user_id', Auth::id()) -> pluck('manufacturer_id');
            $forAll = Manufacturer::where('show_all', 1)->orderBy('name','asc') -> get();
            $showsMan = Manufacturer::where(function ($query) use ($mans) {
                return $query->where('show_all', 1)
                      -> orWhereIn('id', $mans);
            }) -> pluck('id');
            
            $types = Type::whereIn('id', Product::where('category_id', '=', $view -> category -> id)->where('show_product', '=', 1) -> orderBy('prise', 'asc')->distinct()
                ->groupBy('type_id')
                ->pluck('type_id'))-> orderBy('name', 'asc') -> get();

            $seasons = Season::whereIn('id', Product::where('category_id', '=', $view -> category -> id)->where('show_product', '=', 1) -> orderBy('prise', 'asc')->distinct()
                ->groupBy('season_id')
                ->pluck('season_id')) -> orderBy('name', 'asc') -> get();

            $sizes = Size::whereIn('id', Product::where('category_id', '=', $view -> category -> id)->where('show_product', '=', 1) -> orderBy('prise', 'asc')->distinct()
                ->groupBy('size_id')
                ->pluck('size_id'))->orderBy('min', 'asc') -> orderBy('max', 'asc') -> get();

            $colors = Product::where('category_id', '=', $view -> category -> id) -> where('show_product', '=', 1) -> whereNotNull('color') -> groupBy('color') -> select('color') -> get();

            if ( $colors -> count() > 0 ) {
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
		        $tmpColors = array_unique($tmpColors);

		        $colors = Color::Where(function ($query) use($tmpColors) {
		            foreach( $tmpColors as $color ) {
		            	$query->orwhere('words', 'like',  '%' . $color .'%');
		            }      
		        }) -> get();
		    } else $colors = [];

            $manufacturers = Manufacturer::whereIn('id', Product::where('category_id', '=', $view -> category -> id)->where('show_product', '=', 1) -> orderBy('prise', 'asc')->distinct()
                ->groupBy('manufacturer_id')
                ->pluck('manufacturer_id'))
                ->whereIn('id', $showsMan) -> orderBy('name', 'asc') -> get();

            $minPrice = Product::where('category_id', '=', $view -> category -> id)->where('show_product', '=', 1) -> orderBy('prise', 'asc') -> first();

            $maxPrice = Product::where('category_id', '=', $view -> category -> id)->where('show_product', '=', 1) -> orderBy('prise', 'desc') -> first();

            $countries = Product::where('category_id', '=', $view -> category -> id)->where('show_product', '=', 1) -> whereNotNull('manufacturer_country') -> groupBy('manufacturer_country') -> select('manufacturer_country') -> get();

            $categories = [];

        } else {

            $mans = ManShow::select('manufacturer_id') -> where('user_id', Auth::id()) -> pluck('manufacturer_id');
            $forAll = Manufacturer::where('show_all', 1)->orderBy('name','asc') -> get();
            $showsMan = Manufacturer::where(function ($query) use ($mans) {
                return $query->where('show_all', 1)
                      -> orWhereIn('id', $mans);
            }) -> pluck('id');

            $manufacturersDiscaunt = Manufacturer::whereIn('id', $showsMan) -> whereNotNull('discount')-> where('discount', '!=', '0%')
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

            foreach ($productsWithDiscount as $item) {

                if(!in_array($item, $productsFromManufacturers)) {

                    $productsFromManufacturers[] = $item;

                }

            }

            $types = Type::whereIn('id', Product::whereIn('id', $productsFromManufacturers)->where('show_product', '=', 1)->distinct()
                ->groupBy('type_id')
                ->pluck('type_id'))-> orderBy('name', 'asc') -> get();

            $seasons = Season::whereIn('id', Product::whereIn('id', $productsFromManufacturers)->where('show_product', '=', 1)->distinct()
                ->groupBy('season_id')
                ->pluck('season_id')) -> orderBy('name', 'asc') -> get();

            $sizes = Size::whereIn('id', Product::whereIn('id', $productsFromManufacturers)->where('show_product', '=', 1)->distinct()
                ->groupBy('size_id')
                ->pluck('size_id'))->orderBy('min', 'asc') -> orderBy('max', 'asc') -> get();

            $manufacturers = Manufacturer::whereIn('id', Product::whereIn('id', $productsFromManufacturers)->where('show_product', '=', 1)->distinct()
                ->groupBy('manufacturer_id')
                ->pluck('manufacturer_id'))
                ->whereIn('id', $showsMan) -> orderBy('name', 'asc') -> get();

            $colors = Product::whereIn('id', $productsFromManufacturers) -> where('show_product', '=', 1) -> whereNotNull('color') -> groupBy('color') -> select('color') -> get();

            if ( $colors -> count() > 0 ) {
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
		        $tmpColors = array_unique($tmpColors);

		        $colors = Color::Where(function ($query) use($tmpColors) {
		            foreach( $tmpColors as $color ) {
		            	$query->orwhere('words', 'like',  '%' . $color .'%');
		            }      
		        }) -> get();
		    } else $colors = [];

            $minPrice = Product::whereIn('id', $productsFromManufacturers)->where('show_product', '=', 1) -> orderBy('prise', 'asc') -> first();

            $maxPrice = Product::whereIn('id', $productsFromManufacturers)->where('show_product', '=', 1) -> orderBy('prise', 'desc') -> first();

            $countries = Product::whereIn('id', $productsFromManufacturers)->where('show_product', '=', 1) -> whereNotNull('manufacturer_country') -> groupBy('manufacturer_country') -> select('manufacturer_country') -> get();

            $categories = Category::whereIn('id', Product::whereIn('id', $productsFromManufacturers)->where('show_product', '=', 1)->distinct()
                ->groupBy('category_id')
                ->pluck('category_id'))-> orderBy('id', 'asc') -> get();

        }

        $filter = [];
        if ( $view -> typeFilter ) $filter = $view -> typeFilter;

        $view->with(['types' => $types, 'seasons' => $seasons, 'sizes' => $sizes, 'manufacturers' => $manufacturers, 'min' => $minPrice['prise'], 'max' => $maxPrice['prise'], 'countries' => $countries, 'categories' => $categories, 'colors' => $colors, 'filter' => $filter]);

    }


    public function getBrandValues($view){

        if ( $view -> brand ) {
            $types = Type::whereIn('id', Product::where('manufacturer_id', '=', $view -> brand -> id)->where('show_product', '=', 1)->distinct()
                ->groupBy('type_id')
                ->pluck('type_id'))-> orderBy('name', 'asc') -> get();

            $seasons = Season::whereIn('id', Product::where('manufacturer_id', '=', $view -> brand -> id)->where('show_product', '=', 1)->distinct()
                ->groupBy('season_id')
                ->pluck('season_id')) -> orderBy('name', 'asc') -> get();

            $sizes = Size::whereIn('id', Product::where('manufacturer_id', '=', $view -> brand -> id)->where('show_product', '=', 1)->distinct()
                ->groupBy('size_id')
                ->pluck('size_id'))->orderBy('min', 'asc') -> orderBy('max', 'asc') -> get();

            $colors = Product::where('manufacturer_id', '=', $view -> brand -> id) -> where('show_product', '=', 1) -> whereNotNull('color') -> groupBy('color') -> select('color') -> get();

            if ( $colors -> count() > 0 ) {
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
		        $tmpColors = array_unique($tmpColors);

		        $colors = Color::Where(function ($query) use($tmpColors) {
		            foreach( $tmpColors as $color ) {
		            	$query->orwhere('words', 'like',  '%' . $color .'%');
		            }      
		        }) -> get();
		    } else $colors = [];

            $manufacturers = [];

            $minPrice = Product::where('manufacturer_id', '=', $view -> brand -> id)->where('show_product', '=', 1) -> orderBy('prise', 'asc') -> first();

            $maxPrice = Product::where('manufacturer_id', '=', $view -> brand -> id)->where('show_product', '=', 1) -> orderBy('prise', 'desc') -> first();

            $countries = Product::where('manufacturer_id', '=', $view -> brand -> id)->where('show_product', '=', 1) -> whereNotNull('manufacturer_country') -> groupBy('manufacturer_country') -> select('manufacturer_country') -> get();

            $categories = Category::whereIn('id', Product::where('manufacturer_id', '=', $view -> brand -> id)->where('show_product', '=', 1)->distinct()
                ->groupBy('category_id')
                ->pluck('category_id'))-> orderBy('id', 'asc') -> get();
        } 

        if ( $view -> novelty ) {

            $mans = ManShow::select('manufacturer_id') -> where('user_id', Auth::id()) -> pluck('manufacturer_id');
            $forAll = Manufacturer::where('show_all', 1)->orderBy('name','asc') -> get();
            $showsMan = Manufacturer::where(function ($query) use ($mans) {
                return $query->where('show_all', 1)
                      -> orWhereIn('id', $mans);
            }) -> pluck('id');

            $types = Type::whereIn('id', Product::whereIn('id', ProductNovelty::where('nov_id', $view -> novelty -> nov_id) -> pluck('product_id'))->where('show_product', '=', 1)->distinct()
                ->groupBy('type_id')
                ->pluck('type_id'))-> orderBy('name', 'asc') -> get();

            $seasons = Season::whereIn('id', Product::whereIn('id', ProductNovelty::where('nov_id', $view -> novelty -> nov_id) -> pluck('product_id'))->where('show_product', '=', 1)->distinct()
                ->groupBy('season_id')
                ->pluck('season_id')) -> orderBy('name', 'asc') -> get();

            $sizes = Size::whereIn('id', Product::whereIn('id', ProductNovelty::where('nov_id', $view -> novelty -> nov_id) -> pluck('product_id'))->where('show_product', '=', 1)->distinct()
                ->groupBy('size_id')
                ->pluck('size_id'))->orderBy('min', 'asc') -> orderBy('max', 'asc') -> get();

            $manufacturers = Manufacturer::whereIn('id', $showsMan) -> whereIn('id', Product::whereIn('id', ProductNovelty::where('nov_id', $view -> novelty -> nov_id) -> pluck('product_id'))->where('show_product', '=', 1)->distinct()
                ->groupBy('manufacturer_id')
                ->pluck('manufacturer_id'))-> orderBy('name', 'asc') -> get();

            $colors = Product::whereIn('id', ProductNovelty::where('nov_id', $view -> novelty -> nov_id) -> pluck('product_id')) -> where('show_product', '=', 1) -> whereNotNull('color') -> groupBy('color') -> select('color') -> get();

            if ( $colors -> count() > 0 ) {
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
		        $tmpColors = array_unique($tmpColors);

		        $colors = Color::Where(function ($query) use($tmpColors) {
		            foreach( $tmpColors as $color ) {
		            	$query->orwhere('words', 'like',  '%' . $color .'%');
		            }      
		        }) -> get();
		    } else $colors = [];


            $minPrice = Product::whereIn('id', ProductNovelty::where('nov_id', $view -> novelty -> nov_id) -> pluck('product_id'))->where('show_product', '=', 1) -> orderBy('prise', 'asc') -> first();

            $maxPrice = Product::whereIn('id', ProductNovelty::where('nov_id', $view -> novelty -> nov_id) -> pluck('product_id'))->where('show_product', '=', 1) -> orderBy('prise', 'desc') -> first();

            $countries = Product::whereIn('id', ProductNovelty::where('nov_id', $view -> novelty -> nov_id) -> pluck('product_id'))->where('show_product', '=', 1) -> whereNotNull('manufacturer_country') -> groupBy('manufacturer_country') -> select('manufacturer_country') -> get();

            $categories = Category::whereIn('id', Product::whereIn('id', ProductNovelty::where('nov_id', $view -> novelty -> nov_id) -> pluck('product_id'))->where('show_product', '=', 1)->distinct()
                ->groupBy('category_id')
                ->pluck('category_id'))-> orderBy('id', 'asc') -> get();

        } 

        $view->with(['types' => $types, 'seasons' => $seasons, 'sizes' => $sizes, 'manufacturers' => $manufacturers, 'min' => $minPrice['prise'], 'max' => $maxPrice['prise'], 'countries' => $countries, 'categories' => $categories, 'colors' => $colors]);

    }

}
