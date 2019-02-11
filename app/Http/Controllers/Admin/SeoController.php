<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use App\Season;
use App\Setting;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SeoController extends Controller
{
    public function index(){

        $categories = Category::all();

        return view('admin.seo.main', compact('categories'));

    }

    public function editing($id){

        $category = null;
        if ( $id == 0 ) {
            $title = Setting::where('name', 'main_title') -> first() -> value_text;
            $desc = Setting::where('name', 'main_desc') -> first() -> value_text;
            $text = Setting::where('name', 'main_text') -> first() -> value_text;

            $category = new \stdClass();
            $category->id = 0;
            $category->name = 'Главная';
            $category->title = $title;
            $category->description = $desc;
            $category->text = $text;
        } else $category = Category::find($id);

        return view('admin.seo.edit', compact('category'));

    }

    public function update(Request $request){

        if ( $request -> id == 0 ) {
            $title = Setting::where('name', 'main_title') -> first();
            $desc = Setting::where('name', 'main_desc') -> first();
            $text = Setting::where('name', 'main_text') -> first();

            $title -> value_text = $request -> title;
            $desc -> value_text = $request -> description;
            $text -> value_text = $request -> text;

            $title -> save();
            $desc -> save();
            $text -> save();
        } else {
            $category = Category::find($request -> id);

            $category -> title = $request -> title;
            $category -> description = $request -> description;
            $category -> text = $request -> text;

            $category -> save();
        }

        return redirect()->route("adminSeo");

    }
}
