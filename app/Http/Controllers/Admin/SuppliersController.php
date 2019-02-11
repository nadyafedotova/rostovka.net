<?php

namespace App\Http\Controllers\Admin;

use App\Manufacturer;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SuppliersController extends Controller
{
    public function index($name = ""){

        if($name != "") {

            $manufacturers = Manufacturer::where('name', 'like', '%' . $name . '%')
            ->orderBy('koorse', 'desc')->paginate(15);
        }
        else {

            $manufacturers = Manufacturer::orderBy('koorse', 'desc')->paginate(15);
        }

        return view('admin.product.suppliers', compact('manufacturers'));

    }

    public function delete($id){

        $manufacturer = Manufacturer::find($id);
        if($manufacturer){

            $manufacturer -> delete();

            Product::where('manufacturer_id', $id) -> delete();

            return redirect()->back();

        }else return redirect()->back();

    }

    public function edit($id){

        $manufacturer = Manufacturer::find($id);

        if($manufacturer)

            return view('admin.product.supplier_edit', compact('manufacturer'));

        else return redirect() -> back();

    }

    public function update(Request $request){

        $manufacturer = Manufacturer::find($request -> id);

        if($manufacturer){

            $manufacturer -> fill($request -> all());

            if($request ->justBox == "on")
                $manufacturer -> box = 1;
            else $manufacturer -> box = 0;

            if($request -> expiresdis) {
                $manufacturer -> expiresdis = Carbon::now()->addDays($request -> expiresdis);
            } else $manufacturer -> expiresdis = null;

            $manufacturer -> save();

            $products = Product::where("manufacturer_id", $manufacturer -> id) -> get();

            DB::update('update products set prise = prise_default where manufacturer_id = ?',[$manufacturer -> id]);


            if($manufacturer ->koorse != "" && $manufacturer ->koorse != 0){

                DB::update('update products set prise = prise * ? where manufacturer_id = ? AND currency = "дол"',
                    [$manufacturer ->koorse,$manufacturer -> id]);

            }

            if($manufacturer ->discount !="" || $manufacturer ->discount != 0) {


                $hrivna_discount = explode("грн", $manufacturer ->discount);

                if(isset($hrivna_discount[1])){

                    DB::update('update products set prise = prise - ? where manufacturer_id = ?',
                        [$hrivna_discount[0],$manufacturer -> id]);

                }

                $prozent_discount = explode("%",$manufacturer ->discount);

                if(isset($prozent_discount[1])){

                    DB::update('update products set prise = prise - ( prise * ?)  where manufacturer_id = ?',
                        [$prozent_discount[0]/100,$manufacturer -> id]);

                }

            }
            foreach ($products as $product){

                if($product ->discount !="" || $product -> discount != 0) {


                    $hrivna_discount = explode("грн",$product ->discount);

                    if(isset($hrivna_discount[1])){

                        DB::update('update products set prise = prise - ?  where id = ?',
                            [$hrivna_discount[0],$product -> id]);
                    }

                    $prozent_discount = explode("%",$product -> discount);


                    if(isset($prozent_discount[1])){

                        DB::update('update products set prise = prise - ( prise * ?)  where id = ?',
                            [$prozent_discount[0]/100,$product -> id]);

                    }

                }

            }

            $productsTwo = Product::where("manufacturer_id", $manufacturer -> id) -> get();

            foreach ($productsTwo as $products){

                $products -> prise = round($products->prise, 2);

                $products -> save();

            }



            return redirect()->route('suppliers');

        } else return redirect() -> back()->withInput()->withErrors(['error' => "Id was wrong"]);

    }
}
