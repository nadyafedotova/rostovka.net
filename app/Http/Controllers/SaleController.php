<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashRequest;
use App\Http\Requests\SaleRequest;
use App\Order;
use App\OrderCash;
use App\OrderDetails;
use App\Product;
use App\TopSale;
use App\SpecSale;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function makeOrder(Request $request){

      // return response($request -> all());

        $order = new Order();

        $order -> fill($request -> all());

        $order -> save();

        $this ->addOrderDetais($request -> tovar, $order -> id);

        $this ->setTopTovar($request -> tovar);

        $order = Order::with('details', 'details.product') -> find($order -> id);

        $this ->sendOrderMail($order);

        //return redirect('/');


    }

    private function sendOrderMail($dates){


        if($dates -> email) {

            Mail::send('admin.mail.smallMail', ["order" => $dates], function ($message)use ($dates) {
                $message->from('sales@rostovka.net', 'Rostovka');
                $message->to( $dates -> email, 'Drugak')->subject('new order');
                //$message->to('z.kon2009@gmail.com','Drugak')->subject('Welcome to Odessa');
            });

            Mail::send('admin.mail.smallMail', ["order" => $dates], function ($message)use ($dates) {
                $message->from('sales@rostovka.net', 'Rostovka');
                $message->to("sava280982@gmail.com", 'Drugak')->subject('new order');
                //$message->to('z.kon2009@gmail.com','Drugak')->subject('Welcome to Odessa');
            });


            return response(['status' => 'success', 'message' => '', 'data' => null]);
        }
        return response(['status' => 'client error', 'message' => 'wrong email address', 'data' => null]);

    }

    public function getAllTovarsInOrderIds($tovars){

        $ids = [];

        foreach ($tovars as $tovar){

            $ids[] = $tovar['product_id'];

        }

        return $ids;

    }

    public function addOrderDetais($tovars, $order_id){

        $products = Product::whereIn('id',$this -> getAllTovarsInOrderIds($tovars)) -> with('photo') -> get();
        $sales = null;
        if (Auth::id()) $sales = SpecSale::where('user_id', Auth::id()) -> get();

        $insert_mass = [];
        foreach ($tovars as $tovar){
            $product = Product::where('id', $tovar['product_id']) -> with('photo') -> first();

            if ( $sales && $sales -> contains ('manufacturer_id', $product -> manufacturer_id)) {
                foreach ($sales as $sale) {
                    if ( $sale -> manufacturer_id == $product -> manufacturer_id)
                        if ( $sale -> percent ) $product -> prise = $product -> prise - ($product -> prise * ( $sale -> percent/100));
                        else if ( $sale -> minus ) $product -> prise = $product -> prise - $sale -> minus;
                }

                $product -> prise = round($product -> prise);
            }

            if ($product->id == $tovar['product_id']) {
                if($tovar['selected_value'] == 1){
                    $tip = 'minimum';
                }else $tip = 'box';

                if($product-> photo)
                    $productsPhoto = $product-> photo->photo_url;
                else $productsPhoto = 'none';

                $insert_mass[] = [
                    'article' => $product->article,
                    'tovar_name' => $product->name,
                    'rostovka_count' => $product->rostovka_count,
                    'box_count' => $product->box_count,
                    'prise' => $product->prise,
                    'manufacturer_name' => $product->manufacturer->name,
                    'category_name' => $product->category->name,
                    'currency' => $product->currency,
                    'full_description' => $product->full_description,
                    'discount' => $product->discount,
                    'accessibility' => $product->accessibility,
                    'type_name' => $product->type->name,
                    'season_name' => $product->season->name,
                    'size_name' => $product->size->name,
                    'order_id' => $order_id,
                    'tovar_in_order_count' => $tovar['quantity'],
                    'this_tovar_in_order_price' => $tovar['quantityPrice'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'image' => $productsPhoto,
                    'prise_zakup' => $product->prise_zakup,
                    'tip' => $tip
                ];
            }

        }


        OrderDetails::insert($insert_mass);
    }


    public function setTopTovar($tovars){

        foreach ($tovars as $tovar){
            $top = TopSale::where('product_id', '=',$tovar['product_id']) -> first();
            if($top){

                $top -> count = $top -> count + $tovar['quantity'];

            }else{

                $top = new TopSale();
                $top -> product_id = $tovar['product_id'];
                $top -> count = $tovar['quantity'];
            }

            $top -> save();

        }

    }

    public function getTopSales(){
        $top = TopSale::orderBy('top','desc') -> orderBy('count','desc') -> pluck('product_id') -> toArray();

        $products = Product::whereIn('id', $top)
            ->take(12)
            ->with('photo','size','manufacturer')
            ->where('show_product', 1)
            ->where('accessibility', 1)
            ->orderBy(DB::raw('FIELD(`id`, '.implode(',', $top).')')) ->get();

        foreach ($products as $product){

            $product -> full__price = $product -> prise * $product -> box_count;
            $product -> rostovka__price = $product -> prise * $product -> rostovka_count;

            if($product -> manufacturer ->box == 1 ){

                $product->rostovka__price = $product->full__price;
                $product -> rostovka_count = $product -> box_count;

            }

            if($product -> manufacturer ->koorse != "" && $product -> manufacturer ->koorse != 0 && $product->currency == 'дол'){

                $product->prise_default *= $product -> manufacturer ->koorse;
                $product->prise_default = round( $product->prise_default, 2);
            }


            $product -> types = $product -> type -> name;
            $product -> product_url = $product -> category() -> first() -> link . '/' . rawurlencode($product -> name);
        }

        return $products;
    }

    public function testTopSales() {
        $tops = TopSale::where('top', 1) -> where('expires_at', '<', Carbon::now()) -> get();
        dd($tops);
            // foreach ($tops as $top) {
            //     $top -> top = 0;
            //     $top -> expires_at = null;
            //     $top -> save();
            // }
    }

    public function getOrderCash(Request $request){

        if(Order::find($request -> id)){
            $orderCash = OrderCash::where('order_id', $request -> id) -> first();
            if($orderCash){

                return response(['url' => url('showOrder/{orderCash}'.$orderCash -> cashCode)],200);

            }else{

                $orderCash = new OrderCash();

                $orderCash->order_id = $request -> id;

                $cashCode = str_random(64);

                $orderCash->cashCode = $cashCode;

                $orderCash -> save();

                return response(['url' => url('showOrder/{orderCash}'.$cashCode)],200);

            }

        }else return response(['message' => 'Wrong order id'],404);

    }

    public function generateDateCash(CashRequest $request){

        return response(url('showOrder').'/'.base64_encode('dateFrom='.$request -> dateFrom.'&'.'dateTo='.$request -> dateTo));

    }

    public function showOrderOnCash($orderCash){


        $datas = explode('&',base64_decode($orderCash));

        $dataInfo = [];

        foreach ($datas as $data){

            $info = explode('=', $data);
            $dataInfo[] = $info[1];

        }

        if($dataInfo[0] == $dataInfo[1]){
            $str = strtotime($dataInfo[1]);

            $dataToSecond = date('Y-m-d',($str+86400*1));



            $orders = Order::where('created_at', '>=', $dataInfo[1])
                ->where('created_at', '<', $dataToSecond)
                -> whereIn('paid', [0,3])
                -> get();


        }else{

            $orders = Order::where('created_at', '>=', $dataInfo[0])
                -> where('created_at', '<=', $dataInfo[1]) -> whereIn('paid', [0,3])
                -> get();
        }

        $manufacturersNames = [];
        $orderManufacturersUrl = [];

            foreach ($orders as $order) {

                foreach ($order->details as $detail) {

                    if(!in_array($detail->manufacturer_name, $manufacturersNames)) {

                        $orderManufacturersUrl[$detail->manufacturer_name] = url('showOrderManufacturer').'/'
                            .base64_encode(
                                'dateFrom='.$dataInfo[0].
                                      '&'.'dateTo='.$dataInfo[1].
                                      '&'.'manufacturer='.$detail->manufacturer_name);
                        $manufacturersNames[] = $detail->manufacturer_name;
                    }

                }

            }


        return view('admin.product.tov', compact('orderManufacturersUrl'));
         //return response($orderManufacturersUrl);


    }

    public function showOrderManufacturer($orderCash){

        $datas = explode('&',base64_decode($orderCash));

        $values = [];

        foreach ($datas as $data){

            $dataInfo = explode('=', $data);

            $values[] = $dataInfo[1];

        }


        if($values[0] == $values[1]){
            $str = strtotime($values[1]);

            $dataToSecond = date('Y-m-d',($str+86400*1));



            $orders = Order::where('created_at', '>=', $values[1])
                ->where('created_at', '<', $dataToSecond)
                -> whereIn('paid', [0,3])
                -> get();


        }else{

            $orders = Order::where('created_at', '>=', $values[0])
                -> where('created_at', '<=', $values[1]) -> whereIn('paid', [0,3])
                -> get();
        }


        $manufacturersOrders = [];
        $finalPrise = 0;
        $manufacturerName = $values[2];

        foreach ($orders as $order) {

            foreach ($order->details as $detail) {

                if($detail->manufacturer_name == $values[2]) {

                    $manufacturersOrders[] = $detail;
                    if($detail -> tip == "box")

                        $finalPrise +=   $detail->tovar_in_order_count * $detail->prise_zakup * $detail->box_count;
                    else
                        $finalPrise +=   $detail->tovar_in_order_count * $detail->prise_zakup * $detail->rostovka_count;
                  //  $finalPrise += $detail -> this_tovar_in_order_price;

                }

            }

        }

        //dd($values);
        //dd($manufacturersOrders);

        return view('user.sale.toManufacturer', compact('manufacturersOrders', 'finalPrise', 'manufacturerName'));



    }
}
