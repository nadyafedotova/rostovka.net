<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use App\Season;
use App\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TypeController extends Controller
{
    public function index(){

        $types = Type::orderBy('name', 'desc')->get();
        $seasons = Season::orderBy('name', 'desc')->get();

        foreach ($types as $type) {
            $type -> productsCount = Product::where('type_id', $type -> id) -> count();
        }

        foreach ($seasons as $season) {
            $season -> productsCount = Product::where('season_id', $season -> id) -> count();
        }

        return view('admin.product.editing', compact('types','seasons'));

    }

    public function delete($id){

        Type::find($id)->delete();

        Product::where('type_id', $id) -> delete();

        return redirect()->back();

    }

    public function editing($id){

        $type = Type::find($id);

        if ($type) return view('admin.product.type_edit', compact('type'));

        return redirect()->back();

    }

    public function update(Request $request){

        $type = Type::find($request -> type_id);

        if ($type) {

            $type -> name = $request -> name;

            $type -> ktitle = $request -> ktitle;
            $type -> mtitle = $request -> mtitle;
            $type -> ftitle = $request -> ftitle;

            $type -> kdescription = $request -> kdescription;
            $type -> mdescription = $request -> mdescription;
            $type -> fdescription = $request -> fdescription;

            $type -> kkeywords = $request -> kkeywords;
            $type -> mkeywords = $request -> mkeywords;
            $type -> fkeywords = $request -> fkeywords;

            $type -> kids = $request -> kids;
            $type -> female = $request -> female;
            $type -> male = $request -> male;

            $type -> save();
        }

        return redirect() -> back();
    }

    public function deleteSeason($id){

        Season::find($id) -> delete();

        Product::where('season_id', $id) -> delete();

        return redirect()->back();

    }
}
