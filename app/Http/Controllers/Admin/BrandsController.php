<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use App\Season;
use App\Category;
use App\Manufacturer;
use App\ManShow;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class BrandsController extends Controller
{
    public function index(){

        $brands = Manufacturer::orderBy('name') -> get();
        return view('admin.brands.main', compact('brands'));

    }

    public function editing($id){

        $brand = Manufacturer::find($id);
        $ids = ManShow::where('manufacturer_id', $brand -> id) -> pluck('user_id');
        $mans = User::whereIn('id', $ids) -> get();
        $users = User::whereIn('type', ['admin', 'moder', 'opt']) -> get();
        return view('admin.brands.edit', compact('brand', 'mans', 'users'));

    }

    public function update(Request $request){

        $brand = Manufacturer::find($request -> brand_id);
        if ($brand) {

            if ( $request -> lenght ) {
                $lenght = $request -> lenght;
                $request->request->remove('lenght');

                for ($i=1; $i <= $lenght; $i++) {
                    if( $request -> {'man_id' . $i}) {
                        $user = explode('_', $request -> {'man' . $i})[0];
                        $old = explode('_', $request -> {'man_id' . $i})[0];
                        $manufacturer = explode('_', $request -> {'man_id' . $i})[1];

                        $spec = ManShow::where('manufacturer_id', $manufacturer) -> where('user_id', $old) -> first();
                        if ($spec) {
                            $spec -> manufacturer_id = $manufacturer;
                            $spec -> user_id = $user;
                            $spec -> save();
                        }

                        $request->request->remove('man_id' . $i);
                    } else {
                        $user = explode('_', $request -> {'man' . $i})[0];
                        $manufacturer = explode('_', $request -> {'man' . $i})[1];
                        $spec = new ManShow();
                        $spec -> manufacturer_id = $manufacturer;
                        $spec -> user_id = $user;
                        $spec -> save();
                    }

                    $request->request->remove('man' . $i);
                }
            }

	        if ($request -> photo && Input::file('photo')->isValid()) {
	            $path = public_path() . '/images/brands';
	            $name = $brand -> name . '.' . Input::file('photo')->getClientOriginalExtension();
	            Input::file('photo')->move($path, $name);

	            $brand -> photo = $name;

	        } else {

		        $brand -> name = $request -> name;
		        $brand -> title = $request -> title;
		        $brand -> description = $request -> description;
		        $brand -> keywords = $request -> keywords;

            if ( $request -> show_all == 0 ) $brand -> show_all = false;
            else $brand -> show_all = true;

		    }

	        $brand -> save();
	    }

        return redirect() -> back();
    }

    public function delete(Request $request){

        $brand = Manufacturer::find($request -> id);

        if ($brand -> photo && file_exists('/images/brands/' . $brand -> photo)) {
            File::delete('/images/brands/' . $brand -> photo);
        }

        $brand->delete();
    }

    public function deleteMan(Request $request) {
        $user = explode('_', $request -> id)[0];
        $manufacturer = explode('_', $request -> id)[1];
        ManShow::where('manufacturer_id', $manufacturer) -> where('user_id', $user) -> delete();
    }
}
