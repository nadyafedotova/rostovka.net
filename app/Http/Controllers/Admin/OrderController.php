<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use App\OrderDetails;
use App\Product;
use App\Fool;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index($name = ''){

        if($name != '') {
            if (is_numeric($name))
                $orders = Order::with('details')->orderBy('id', 'desc')-> where('id', $name) -> paginate(30);
            else
            $orders = Order::with('details')
                -> where('first_name', 'like', "%".$name."%")
                -> where('last_name', 'like', "%".$name."%",'or')
                ->orderBy('id', 'desc')->paginate(30);
        }else
            $orders = Order::with('details') ->orderBy('id', 'desc')->paginate(30);

        foreach ($orders as $order){

            foreach ($order -> details as $detail){

                $order -> all_prise += $detail -> this_tovar_in_order_price;

            }

        }

        $fools = Fool::all();

        $countByMount = [];
        $dateStart = Carbon::now();

        for( $i = 0; $i < 6; $i ++ ) {
        	$orders_count = Order::whereMonth('created_at', '=', $dateStart->format('m'))
        		-> whereYear('created_at', '=', $dateStart->format('Y'))
        		-> get();

        	array_push($countByMount, [ 'date' => date('m.Y', strtotime($dateStart)), 'count' => $orders_count -> count()]);

        	$dateStart = $dateStart -> subMonth();
        }

        return view('admin.product.orders', compact('orders', 'fools', 'countByMount'));

    }

    public function orderInfo($id){

        $order = Order::with('details', 'details.product') -> find($id);

        //dd($order -> toArray());

        return view('admin.product.orderInfo', compact('order'));

    }

    public function update(Request $request){

        $order = Order::find($request -> id);

        $order -> fill($request -> all());

        $order -> save();

        return redirect()->route('orders');

    }

    public function deleteOrderDetail(Request $request){

        $order_detail = OrderDetails::find($request -> id);

        if($order_detail){

            $order = Order::find($order_detail -> order_id);

            if($order){

                $order -> summ = $order -> summ - $order_detail -> this_tovar_in_order_price;

                $order -> save();

                $order_detail -> delete();

                return response()->json(['done' => 'deleted'], 200);

            } else return response()->json(['error' => 'wrong id order'], 404);

        }else return response()->json(['error' => 'wrong id detail'], 404);

    }


    public function deleteOrder(Request $request){

        Order::find($request -> id) ->details() -> delete();

        Order::find($request -> id)  -> delete();

    }


    public function addOrderDetail(Request $request){

         $ids = [];

         for($i = 0; $i < count($request -> data); $i ++){

             $ids[] = $request -> data[$i]['id'];

         }

         $orderDates = [];

        for($i = 0; $i < count($request -> data); $i ++){

            $orderDates[ $request -> data[$i]['id']] = [$request -> data[$i]['orderID'], $request -> data[$i]['quantity'] , $request -> data[$i]['type']];

        }

        $products = Product::whereIn('id',$ids) -> with('photo') -> get();
        $insert_mass = [];
        $final_prise = 0;
            foreach ($products as $product) {

                $order_tovar_prise = $product->prise;

                /*if($product -> manufacturer ->koorse != "" || $product -> manufacturer ->koorse != 0){

                    $order_tovar_prise *= $product -> manufacturer ->koorse;

                }*/

                if($product -> manufacturer ->discount !="" || $product -> manufacturer ->discount != 0) {

                    $hrivna_discount = explode("грн",$product -> manufacturer ->discount);

                    if(isset($hrivna_discount[1])){

                        $order_tovar_prise = $order_tovar_prise - $hrivna_discount[0];
                    }

                    $prozent_discount = explode("%",$product -> manufacturer ->discount);

                    if(isset($prozent_discount[1])){

                        $order_tovar_prise = $order_tovar_prise - ( $order_tovar_prise * ($prozent_discount[0]/100) );
                    }

                }

                if($product ->discount !="" || $product -> discount != 0) {

                    $hrivna_discount = explode("грн",$product ->discount);

                    if(isset($hrivna_discount[1])){

                        $order_tovar_prise =  $order_tovar_prise - $hrivna_discount[0];
                    }

                    $prozent_discount = explode("%",$product -> discount);

                    if(isset($prozent_discount[1])){


                        $order_tovar_prise =  $order_tovar_prise - ( $order_tovar_prise * ($prozent_discount[0]/100) ) ;
                    }

                }

                if($orderDates[$product -> id][2] == 'box'){

                        $this_tovar_in_order_price = $order_tovar_prise * $product->box_count * $orderDates[$product -> id][1];

                }else {

                    $this_tovar_in_order_price = $order_tovar_prise * $product->rostovka_count * $orderDates[$product -> id][1];

                }
                    $insert_mass[] = [
                        'article' => $product->article,
                        'tovar_name' => $product->name,
                        'rostovka_count' => $product->rostovka_count,
                        'box_count' => $product->box_count,
                        'prise' => $order_tovar_prise,
                        'manufacturer_name' => $product->manufacturer->name,
                        'category_name' => $product->category->name,
                        'currency' => $product->currency,
                        'full_description' => $product->full_description,
                        'discount' => $product->discount,
                        'accessibility' => $product->accessibility,
                        'type_name' => $product->type->name,
                        'season_name' => $product->season->name,
                        'size_name' => $product->size->name,
                        'order_id' => $orderDates[$product -> id][0],
                        'tovar_in_order_count' => $orderDates[$product -> id][1],
                        'this_tovar_in_order_price' => $this_tovar_in_order_price,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'image' => $product-> photo->photo_url,
                        'prise_zakup' => $product-> prise_zakup,
                        'tip' => $orderDates[$product -> id][2]
                    ];


                $final_prise +=  $this_tovar_in_order_price;
                }

        OrderDetails::insert($insert_mass);


        $order = Order::find($request -> data[0]['orderID']);

        $order -> summ = $order -> summ + $final_prise;

        $order -> save();


    }
}
