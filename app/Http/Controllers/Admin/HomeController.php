<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\SpecSale;
use App\Manufacturer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index($name=""){

        if($name != "")
            $clients = User::where('first_name', 'like', '%'.$name.'%')
                -> where('last_name', 'like', '%'.$name.'%','or')
                -> orderBy('type') -> paginate(15);
        else
            $clients = User::orderBy('type') -> paginate(15);

        return view('admin.all_user', compact('clients'));

    }

    public function supplier(){

        $client = User::find(2);

        return view('admin.product.supplier_edit', compact('client'));

    }



    public function editClient($id){

        $client = User::find($id);
        $mans = Manufacturer::orderBy('name') -> get();
        $sales = SpecSale::where('user_id', $id) -> get();

        return view('admin.user_edit.edit', compact('client', 'mans', 'sales'));

    }

    public function deleteClient($id){

        User::find($id) -> delete();

    }

    public function deleteSale(Request $request) {
        SpecSale::find($request -> id) -> delete();
    }

    public function updateClient(Request $request){

        $rules = [
            'email' => 'required|email'
            ];

        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ( $request -> lenght ) {
            $lenght = $request -> lenght;
            $request->request->remove('lenght');

            for ($i=1; $i <= $lenght; $i++) { 
                if ( !$request -> {'percent'.$i} && !$request -> {'minus'.$i}) return redirect()->back()->withErrors('Поля скидки должны быть заполнены');
            }

            for ($i=1; $i <= $lenght; $i++) { 
                if( $request -> {'sale_id' . $i}) {
                    $spec = SpecSale::find($request -> {'sale_id' . $i});
                    $spec -> manufacturer_id = $request -> {'sel'.$i};
                    $spec -> user_id = $request -> id;
                    if ($request -> {'percent'.$i}) $spec -> percent = $request -> {'percent'.$i};
                    if ($request -> {'minus'.$i}) $spec -> minus = $request -> {'minus'.$i};
                    $spec -> save();

                    $request->request->remove('sale_id' . $i);
                } else {
                    $spec = new SpecSale();
                    $spec -> manufacturer_id = $request -> {'sel'.$i};
                    $spec -> user_id = $request -> id;
                    if ($request -> {'percent'.$i}) $spec -> percent = $request -> {'percent'.$i};
                    if ($request -> {'minus'.$i}) $spec -> minus = $request -> {'minus'.$i};
                    $spec -> save();
                }

                $request->request->remove('sel' . $i);
                $request->request->remove('percent' . $i);
                $request->request->remove('minus' . $i);
            }
        }

        $client = User::find($request -> id);

        $client -> fill($request -> all());

        $client -> save();

        return redirect()->route("adminIndex");

    }

    public function personal(){

        $user = User::find(Auth::user()->id);

        return view('admin.user_edit.admin_edit', compact('user'));

    }

    public function personalUpdate(Request $request){

        $user = User::find($request -> id);

        $user->fill($request -> all());

        $user -> save();

        return redirect() ->route("adminIndex");

    }
}
