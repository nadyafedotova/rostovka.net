<?php

namespace App\Http\Controllers\Admin\CSV;

use App\Manufacturer;
use App\Order;
use App\Parsing\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use PHPExcel_Worksheet_Drawing;

class CsvOrderController extends Controller
{


    public function getCsvFileWithOrdersToSend(Request $request){

        //dd($request -> dataFrom, $request -> dataTo);

        if(!$request -> dataFrom)
            $dataFrom = Carbon::now();
        if(!$request -> dataTo)
            $dataTo = Carbon::now();

        if($request -> dataFrom)
            $dataFrom = $request -> dataFrom;
        if($request -> dataTo)
            $dataTo = $request -> dataTo;


        if($dataFrom == $dataTo){

            $str = strtotime($dataTo);

            $dataToSecond = date('Y-m-d',($str+86400*1));


            $orders = Order::where('created_at', '>=', $dataTo)
                ->where('created_at', '<', $dataToSecond)
                -> whereIn('paid', [0,3])
                -> get();


        }else{

            $str = strtotime($dataTo);

            $dataToSecond = date('Y-m-d',($str+86400*1));

            $orders = Order::where('created_at', '>=', $dataFrom)
                -> where('created_at', '<=', $dataToSecond) -> whereIn('paid', [0,3])
                -> get();
        }



        $data = [];
        $score =[];

        if($orders->count() > 0) {
            foreach ($orders as $order) {

                if(!isset($score[$order->shipping_method]))
                    $score[$order->shipping_method] = 1;


                $data[$order->shipping_method][] = [
                    $score[$order->shipping_method],
                    $order->first_name . ' ' . $order->last_name,
                    $order->address. ' '. $order -> info,
                    $order->phone,
                    '',
                    '',
                    ""
                ];

                $score[$order->shipping_method] =  $score[$order->shipping_method] + 1;

            }

            Excel::create('Заказ Доставка', function ($excel) use ($data) {

                foreach ($data as $key => $value) {

                    $excel->sheet($key, function ($sheet) use ($value, $key) {

                        for ($i = 1; $i < count($value) + 10; $i++) {

                            $sheet->setHeight($i, 46);

                            $sheet->getStyle('A'.$i.':I3'.$i)->getAlignment()->applyFromArray(
                                array('horizontal' => 'left', 'vertical' => 'center')
                            )->setWrapText(true);
                        }

                        switch ($key){
                            case "new_post" :
                                $headValue = "Новая почта";
                                break;
                            case "delivery_method" :
                                $headValue = "Delivery";
                                break;
                            case "avtolux_method" :
                                $headValue = "Автолюкс";
                                break;
                            case "intime_method" :
                                $headValue = "InTime";
                                break;
                            case "bus_method" :
                                $headValue = "Подвести к автобусу";
                                break;
                            default :
                                $headValue = "Самовывоз";
                        }



                        $sheet->row(1, array("",$headValue,"","","","",""));

                        $sheet->row(2, array("№",
                            "Фамилия"."\r\n"."имя"."\r\n"."отчество",
                            "Город"."\r\n"."Номер отделения",
                            "Номер "."\r\n"."телефона",
                            "Сумма",
                            "Кол-во"."\r\n"."мест",
                            "Гал"));

                        for ($i = 0; $i < count($value); $i++) {

                            $insertIntoTableValue = [
                                $value[$i][0],
                                $value[$i][1],
                                $value[$i][2],
                                $value[$i][3],
                                $value[$i][4],
                                $value[$i][5],
                                $value[$i][6]
                            ];



                            $sheet->row(3 + $i, $insertIntoTableValue);


                        }

                        //$sheet->fromArray($value);

                        $sheet->setWidth('A', 3);
                        $sheet->setWidth('B', 20);
                        $sheet->setWidth('C', 22);
                        $sheet->setWidth('D', 15);
                        $sheet->setWidth('E', 7);
                        $sheet->setWidth('F', 12);
                        $sheet->setWidth('G', 4);



                    });


                }

            })->export('xlsx');
        }else return redirect()->back()->withInput()->withErrors(['msg'=> 'Not find items']);


    }

    public function getCsvFileWithOrdersImages(Request $request){


        if(!$request -> dataFrom)
            $dataFrom = Carbon::now();
        if(!$request -> dataTo)
            $dataTo = Carbon::now();

        if($request -> dataFrom)
            $dataFrom = $request -> dataFrom;
        if($request -> dataTo)
            $dataTo = $request -> dataTo;


        if($dataFrom == $dataTo){

            $str = strtotime($dataTo);

            $dataToSecond = date('Y-m-d',($str+86400*1));


            $orders = Order::where('created_at', '>=', $dataTo)
                ->where('created_at', '<', $dataToSecond)
                -> whereIn('paid', [0,3])
                -> get();


        }else{

            $str = strtotime($dataTo);

            $dataToSecond = date('Y-m-d',($str+86400*1));

            $orders = Order::where('created_at', '>=', $dataFrom)
                -> where('created_at', '<=', $dataToSecond) -> whereIn('paid', [0,3])
                -> get();
        }


        if($orders->count() > 0) {

            $data = [];
            $manufacturersNames = [];

            foreach ($orders as $order) {

                foreach ($order->details as $detail) {

                    if(!in_array($detail->manufacturer_name, $manufacturersNames))
                        $manufacturersNames[] = $detail->manufacturer_name;

                }

            }

            $manufacturersInfos = Manufacturer::whereIn('name', $manufacturersNames) -> pluck('street', 'name');

            $manufacturersFirstName = Manufacturer::whereIn('name', $manufacturersNames) -> pluck('firstName', 'name');
            $manufacturersSecondName = Manufacturer::whereIn('name', $manufacturersNames) -> pluck('secondName', 'name');
            $manufacturersPhoneName = Manufacturer::whereIn('name', $manufacturersNames) -> pluck('phone', 'name');
            $manufacturersNumberContainer = Manufacturer::whereIn('name', $manufacturersNames) -> pluck('numberContainer', 'name');


            foreach ($orders as $order) {

                foreach ($order->details as $detail) {
                    if(isset($manufacturersInfos[$detail->manufacturer_name]))
                        if($manufacturersInfos[$detail->manufacturer_name] != "" && $manufacturersInfos[$detail->manufacturer_name] != null)
                            $street = ", ".$manufacturersInfos[$detail->manufacturer_name];
                        else $street = $manufacturersInfos[$detail->manufacturer_name];
                    else $street = 'Поставщик был удалён'.", ";

                    if(isset($manufacturersFirstName[$detail->manufacturer_name]))
                        if($manufacturersFirstName[$detail->manufacturer_name] != "" && $manufacturersFirstName[$detail->manufacturer_name] != null)
                            $firstNameManufacturer = ", ".$manufacturersFirstName[$detail->manufacturer_name];
                        else $firstNameManufacturer = $manufacturersFirstName[$detail->manufacturer_name];
                    else $firstNameManufacturer = '';

                    if(isset($manufacturersSecondName[$detail->manufacturer_name]))
                        if($manufacturersSecondName[$detail->manufacturer_name] != "" && $manufacturersSecondName[$detail->manufacturer_name] != null)
                            $secondNameManufacturer = " ".$manufacturersSecondName[$detail->manufacturer_name];
                        else $secondNameManufacturer = $manufacturersSecondName[$detail->manufacturer_name];
                    else $secondNameManufacturer = '';


                    if(isset($manufacturersPhoneName[$detail->manufacturer_name]))
                        if($manufacturersPhoneName[$detail->manufacturer_name] != "" && $manufacturersPhoneName[$detail->manufacturer_name] != null)
                            $phoneManufacturer = ", ".$manufacturersPhoneName[$detail->manufacturer_name];
                        else  $phoneManufacturer = $manufacturersPhoneName[$detail->manufacturer_name];
                    else $phoneManufacturer = '';

                    if(isset($manufacturersNumberContainer[$detail->manufacturer_name]))
                        if($manufacturersNumberContainer[$detail->manufacturer_name] != "" && $manufacturersNumberContainer[$detail->manufacturer_name] != null)
                            $NumberContainerManufacturer = ", ".$manufacturersNumberContainer[$detail->manufacturer_name];
                        else  $NumberContainerManufacturer = $manufacturersNumberContainer[$detail->manufacturer_name];
                    else $NumberContainerManufacturer = '';

                    $time =  explode(' ',  Carbon::now());

                    $data[$detail->manufacturer_name][0] = [

                        Carbon::parse($time[0])->format('d.m.Y'),
                        '',
                        'Заказчик: Rostovka.net '."\r\n".'Сергей тел: 0672533305',
                        'Поставщик: ' . $detail->manufacturer_name . "". $street. "". $NumberContainerManufacturer ."". $firstNameManufacturer. "". $secondNameManufacturer."".$phoneManufacturer,

                    ];

                }

            }


            foreach ($orders as $order) {

                foreach ($order->details as $detail) {

                    if($detail -> tip == "box") {
                        $type = 'ящ';
                        $count = $detail->box_count;
                        $finalPrise = $detail->tovar_in_order_count * $detail->prise_zakup * $detail->box_count;
                    }
                    else {
                        $type = 'рост';
                        $count = $detail->rostovka_count;
                        $finalPrise = $detail->tovar_in_order_count * $detail->prise_zakup * $detail->rostovka_count;
                    }


                    $number = count($data[$detail->manufacturer_name]);

                    $data[$detail->manufacturer_name][] = [
                        $number,
                        $detail->order_id,
                        $detail->image,
                        $detail->article,
                        $type,
                        $detail->tovar_in_order_count,
                        $count,
                        (integer)$detail->prise_zakup,
                        $finalPrise

                    ];


                }

            }

            Excel::create('Заказ Произв Фото', function ($excel) use ($data) {

                foreach ($data as $key => $value) {

                    $excel->sheet($key, function ($sheet) use ($value) {

                        for ($i = 1; $i < count($value) + 2; $i++) {


                            if ($i == 2)
                                $sheet->setHeight($i, 30);
                            else
                                $sheet->setHeight($i, 25);

                            $sheet->getStyle('A'.$i.':I'.$i)->getAlignment()->applyFromArray(
                                array('horizontal' => 'center', 'vertical' => 'center')
                            )->setWrapText(true);

                        }


                        $sheet->row(1, $value[0]);
                        $sheet->row(2, array("№", "Номер "."\r\n"."заказа", 'Фото', "Aртикул", "Ящ/рост", "Кол-во", "Пар в Ящ/рост", "Цена за Пару(закуп)", "Сумма"));

                        $count = 0;
                        $all_prise = 0;

                        for ($i = 1; $i < count($value); $i++) {

                            $insertIntoTableValue = [
                                $value[$i][0],
                                $value[$i][1],
                                "",
                                $value[$i][3],
                                $value[$i][4],
                                $value[$i][5],
                                $value[$i][6],
                                $value[$i][7],
                                $value[$i][8]
                            ];

                            $sheet->row(2 + $i, $insertIntoTableValue);

                            $count += $value[$i][6];
                            $all_prise += $value[$i][8];

                        }


                        $sheet->row(2 + $i, array("", "", "", "", "", "", $count, "", $all_prise));
                        $sheet->setWidth('A', 10);
                        $sheet->setWidth('B', 8);
                        $sheet->setWidth('C', 23);
                        $sheet->setWidth('D', 40);
                        $sheet->setWidth('E', 8);
                        $sheet->setWidth('F', 7);
                        $sheet->setWidth('G', 13);
                        $sheet->setWidth('H', 18);
                        $sheet->setWidth('I', 8);

                        $sheet->mergeCells('E1:G1');

                        $objDrawing = new PHPExcel_Worksheet_Drawing;
                        $objDrawing->setPath(public_path('images/viber_image.jpg')); //your image path
                        $objDrawing->setName('imageRussik');
                        $objDrawing->setWorksheet($sheet);
                        $objDrawing->setCoordinates('E1');
                        $objDrawing->setResizeProportional();
                        //$objDrawing->setOffsetX($objDrawing->getWidth() - $objDrawing->getWidth() / 5);
                        $objDrawing->setOffsetY(0);
                        $objDrawing->setOffsetX(0);
                        $objDrawing->setWidth(60);
                        $objDrawing->setHeight(33);


                        for ($i = 1; $i < count($value); $i++) {
                            //dump($value[$i]);

                            if($value[$i][2] != "")

                                if (file_exists('images/products/' . $value[$i][2]) && $value[$i][2] != "") {
                                    $objDrawing = new PHPExcel_Worksheet_Drawing;
                                    $objDrawing->setPath(public_path('images/products/' . $value[$i][2])); //your image path
                                    $objDrawing->setName('imageRussik');
                                    $objDrawing->setWorksheet($sheet);
                                    $objDrawing->setCoordinates('C' . ($i + 2));
                                    $objDrawing->setResizeProportional();
                                    //$objDrawing->setOffsetX($objDrawing->getWidth() - $objDrawing->getWidth() / 5);
                                    $objDrawing->setOffsetY(5);
                                    $objDrawing->setOffsetX(55);
                                    $objDrawing->setWidth(125);
                                    $objDrawing->setHeight(65);
                                }

                        }

                    });


                }


            })->export('xlsx');

        }else return redirect()->back()->withInput()->withErrors(['msg'=>'Not find items']);

    }

    public function getCsvFileWithOrders(Request $request){


        if(!$request -> dataFrom)
            $dataFrom = Carbon::now();
        if(!$request -> dataTo)
            $dataTo = Carbon::now();

        if($request -> dataFrom)
            $dataFrom = $request -> dataFrom;
        if($request -> dataTo)
            $dataTo = $request -> dataTo;


        if($dataFrom == $dataTo){

            $str = strtotime($dataTo);

            $dataToSecond = date('Y-m-d',($str+86400*1));


            $orders = Order::where('created_at', '>=', $dataTo)
                ->where('created_at', '<', $dataToSecond)
                -> whereIn('paid', [0,3])
                -> get();


        }else{

            $str = strtotime($dataTo);

            $dataToSecond = date('Y-m-d',($str+86400*1));

            $orders = Order::where('created_at', '>=', $dataFrom)
                -> where('created_at', '<=', $dataToSecond) -> whereIn('paid', [0,3])
                -> get();
        }

        // dd($request -> all());


        $data = [];
        $manufacturersNames = [];

        if($orders->count() > 0) {

            foreach ($orders as $order) {

                foreach ($order->details as $detail) {

                    if(!in_array($detail->manufacturer_name, $manufacturersNames))
                        $manufacturersNames[] = $detail->manufacturer_name;

                }

            }

            $manufacturersInfos = Manufacturer::whereIn('name', $manufacturersNames) -> pluck('street', 'name');

            $manufacturersFirstName = Manufacturer::whereIn('name', $manufacturersNames) -> pluck('firstName', 'name');
            $manufacturersSecondName = Manufacturer::whereIn('name', $manufacturersNames) -> pluck('secondName', 'name');
            $manufacturersPhoneName = Manufacturer::whereIn('name', $manufacturersNames) -> pluck('phone', 'name');
            $manufacturersNumberContainer = Manufacturer::whereIn('name', $manufacturersNames) -> pluck('numberContainer', 'name');

            //dd($manufacturersNames, $manufacturersInfos,$manufacturersFirstName,$manufacturersSecondName, $manufacturersPhoneName);


            foreach ($orders as $order) {

                foreach ($order->details as $detail) {

                    $time =  explode(' ',  Carbon::now());

                    if(isset($manufacturersInfos[$detail->manufacturer_name]))
                        if($manufacturersInfos[$detail->manufacturer_name] != "" && $manufacturersInfos[$detail->manufacturer_name] != null)
                            $street = ", ".$manufacturersInfos[$detail->manufacturer_name];
                        else $street = $manufacturersInfos[$detail->manufacturer_name];
                    else $street = 'Поставщик был удалён'.", ";

                    if(isset($manufacturersFirstName[$detail->manufacturer_name]))
                        if($manufacturersFirstName[$detail->manufacturer_name] != "" && $manufacturersFirstName[$detail->manufacturer_name] != null)
                            $firstNameManufacturer = ", ".$manufacturersFirstName[$detail->manufacturer_name];
                        else $firstNameManufacturer = $manufacturersFirstName[$detail->manufacturer_name];
                    else $firstNameManufacturer = '';

                    if(isset($manufacturersSecondName[$detail->manufacturer_name]))
                        if($manufacturersSecondName[$detail->manufacturer_name] != "" && $manufacturersSecondName[$detail->manufacturer_name] != null)
                            $secondNameManufacturer = " ".$manufacturersSecondName[$detail->manufacturer_name];
                        else $secondNameManufacturer = $manufacturersSecondName[$detail->manufacturer_name];
                    else $secondNameManufacturer = '';


                    if(isset($manufacturersPhoneName[$detail->manufacturer_name]))
                        if($manufacturersPhoneName[$detail->manufacturer_name] != "" && $manufacturersPhoneName[$detail->manufacturer_name] != null)
                            $phoneManufacturer = ", ".$manufacturersPhoneName[$detail->manufacturer_name];
                        else  $phoneManufacturer = $manufacturersPhoneName[$detail->manufacturer_name];
                    else $phoneManufacturer = '';

                    if(isset($manufacturersNumberContainer[$detail->manufacturer_name]))
                        if($manufacturersNumberContainer[$detail->manufacturer_name] != "" && $manufacturersNumberContainer[$detail->manufacturer_name] != null)
                            $NumberContainerManufacturer = ", ".$manufacturersNumberContainer[$detail->manufacturer_name];
                        else  $NumberContainerManufacturer = $manufacturersNumberContainer[$detail->manufacturer_name];
                    else $NumberContainerManufacturer = '';


                    $data[$detail->manufacturer_name][0] = [

                        Carbon::parse($time[0])->format('d.m.Y'),
                        '',
                        'Заказчик: Rostovka.net '."\r\n".'Сергей тел: 0672533305',
                        'Поставщик: ' . $detail->manufacturer_name ."". $street."". $NumberContainerManufacturer ."". $firstNameManufacturer. "". $secondNameManufacturer."".$phoneManufacturer,


                    ];

                }

            }


            foreach ($orders as $order) {

                foreach ($order->details as $detail) {
                    $number = count($data[$detail->manufacturer_name]);

                    $normArtikle = explode(mb_strtolower($detail->manufacturer_name), $detail->article);
                    if(isset($normArtikle[1])){

                        $artiklePrint = $normArtikle[1];

                    }else $artiklePrint = $detail->article;

                    //dd($normArtikle, $detail->manufacturer_name);

                    if($detail -> tip == "box") {
                        $type = 'ящ';
                        $count = $detail->box_count;
                        $finalPrise = $detail->tovar_in_order_count * $detail->prise_zakup * $detail->box_count;
                    }
                    else {
                        $type = 'рост';
                        $count = $detail->rostovka_count;
                        $finalPrise = $detail->tovar_in_order_count * $detail->prise_zakup * $detail->rostovka_count;
                    }

                    $prise_for_pdf = $detail->prise_zakup - $detail->discount;


                    $data[$detail->manufacturer_name][] = [
                        $number,
                        $detail->order_id,
                        $artiklePrint,
                        $type,
                        $detail->tovar_in_order_count,
                        $count,
                        (integer)$prise_for_pdf,
                        $finalPrise

                    ];


                }

            }

            Excel::create('Заказ Произв', function ($excel) use ($data) {

                foreach ($data as $key => $value) {

                    $excel->sheet($key, function ($sheet) use ($value) {

                        for ($i = 1; $i < count($value) + 2; $i++) {

                            $sheet->setHeight($i, 67);

                            if($i >= 2)
                                $sheet->setHeight($i, 40);

                            $sheet->getStyle('A'.$i.':I'.$i)->getAlignment()->applyFromArray(
                                array('horizontal' => 'center', 'vertical' => 'center')
                            )->setWrapText(true);

                        }

                        $sheet->row(1, $value[0]);
                        $sheet->row(2, array("№", "Номер"."\r\n"."заказа",  "Aртикул", "Ящ/рост", "Кол-во", "Пар", "Закуп", "Сумма"));

                        $count = 0;
                        $all_prise = 0;


                        for ($i = 1; $i < count($value); $i++) {



                            $sheet->row(2 + $i, $value[$i]);

                            $count += $value[$i][5];
                            $all_prise += $value[$i][7];

                        }

                        $sheet->row(2 + $i, array("", "", "", "", "", $count, "", $all_prise));
                        $sheet->setWidth('A', 10);
                        $sheet->setWidth('B', 8);
                        $sheet->setWidth('C', 35);
                        $sheet->setWidth('D', 8);
                        $sheet->setWidth('E', 8);
                        $sheet->setWidth('F', 7);
                        $sheet->setWidth('G', 10);
                        $sheet->setWidth('H', 10);
                        //$sheet->setWidth('I', 8);

                        $sheet->mergeCells('D1:F1');
                        $sheet->mergeCells('G1:H1');


                        $objDrawing = new PHPExcel_Worksheet_Drawing;
                        $objDrawing->setPath(public_path('images/viber_image.jpg')); //your image path
                        $objDrawing->setName('imageRussik');
                        $objDrawing->setWorksheet($sheet);
                        $objDrawing->setCoordinates('G1');
                        $objDrawing->setResizeProportional();
                        //$objDrawing->setOffsetX($objDrawing->getWidth() - $objDrawing->getWidth() / 5);
                        $objDrawing->setOffsetY(0);
                        $objDrawing->setOffsetX(0);
                        $objDrawing->setWidth(60);
                        $objDrawing->setHeight(33);

                    });


                }


            })->export('xlsx');
        }else return redirect()->back()->withInput()->withErrors(['msg' => 'Not find items']);

    }


    public function getCsvFileWithOrdersToSendPDF(Request $request){

        //dd($request -> dataFrom, $request -> dataTo);

        if(!$request -> dataFrom)
            $dataFrom = Carbon::now();
        if(!$request -> dataTo)
            $dataTo = Carbon::now();

        if($request -> dataFrom)
            $dataFrom = $request -> dataFrom;
        if($request -> dataTo)
            $dataTo = $request -> dataTo;


        if($dataFrom == $dataTo){

            $str = strtotime($dataTo);

            $dataToSecond = date('Y-m-d',($str+86400*1));


            $orders = Order::where('created_at', '>=', $dataTo)
                ->where('created_at', '<', $dataToSecond)
                -> whereIn('paid', [0,3])
                -> get();


        }else{

            $str = strtotime($dataTo);

            $dataToSecond = date('Y-m-d',($str+86400*1));

            $orders = Order::where('created_at', '>=', $dataFrom)
                -> where('created_at', '<=', $dataToSecond) -> whereIn('paid', [0,3])
                -> get();
        }



        $data = [];
        $score =[];

        if($orders->count() > 0) {
            foreach ($orders as $order) {

                if(!isset($score[$order->shipping_method]))
                    $score[$order->shipping_method] = 1;


                $data[$order->shipping_method][] = [
                    $score[$order->shipping_method],
                    $order->first_name . ' ' . $order->last_name,
                    $order->address. ' '. $order -> info,
                    $order->phone,
                    $order->payment_method,
                    '',
                    '',
                    "",
                    $dataFrom,
                    $dataTo,
                    date('d.m.y',(strtotime(Carbon::now())))
                ];

                $score[$order->shipping_method] =  $score[$order->shipping_method] + 1;

            }

            $pdf = PDF::loadView('admin.pdf.order_list', compact('data'));

            $pdf -> setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            return $pdf->download('СписокЗаказов.pdf');

        }else return redirect()->back()->withInput()->withErrors(['msg'=> 'Not find items']);


    }

    public function getCsvFileWithOrdersImagesPDF(Request $request){


        if(!$request -> dataFrom)
            $dataFrom = Carbon::now();
        if(!$request -> dataTo)
            $dataTo = Carbon::now();

        if($request -> dataFrom)
            $dataFrom = $request -> dataFrom;
        if($request -> dataTo)
            $dataTo = $request -> dataTo;


        if($dataFrom == $dataTo){

            $str = strtotime($dataTo);

            $dataToSecond = date('Y-m-d',($str+86400*1));


            $orders = Order::where('created_at', '>=', $dataTo)
                ->where('created_at', '<', $dataToSecond)
                -> whereIn('paid', [0,3])
                -> get();


        }else{

            $str = strtotime($dataTo);

            $dataToSecond = date('Y-m-d',($str+86400*1));

            $orders = Order::where('created_at', '>=', $dataFrom)
                -> where('created_at', '<=', $dataToSecond) -> whereIn('paid', [0,3])
                -> get();
        }


        if($orders->count() > 0) {

            $data = [];
            $manufacturersNames = [];

            foreach ($orders as $order) {

                foreach ($order->details as $detail) {

                    if(!in_array($detail->manufacturer_name, $manufacturersNames))
                        $manufacturersNames[] = $detail->manufacturer_name;

                }

            }

            $manufacturersInfos = Manufacturer::whereIn('name', $manufacturersNames) -> pluck('street', 'name');

            $manufacturersFirstName = Manufacturer::whereIn('name', $manufacturersNames) -> pluck('firstName', 'name');
            $manufacturersSecondName = Manufacturer::whereIn('name', $manufacturersNames) -> pluck('secondName', 'name');
            $manufacturersPhoneName = Manufacturer::whereIn('name', $manufacturersNames) -> pluck('phone', 'name');
            $manufacturersNumberContainer = Manufacturer::whereIn('name', $manufacturersNames) -> pluck('numberContainer', 'name');


            foreach ($orders as $order) {

                foreach ($order->details as $detail) {
                    if(isset($manufacturersInfos[$detail->manufacturer_name]))
                        if($manufacturersInfos[$detail->manufacturer_name] != "" && $manufacturersInfos[$detail->manufacturer_name] != null)
                            $street = $manufacturersInfos[$detail->manufacturer_name];
                        else $street = $manufacturersInfos[$detail->manufacturer_name];
                    else $street = 'Поставщик был удалён';

                    if(isset($manufacturersFirstName[$detail->manufacturer_name]))
                        if($manufacturersFirstName[$detail->manufacturer_name] != "" && $manufacturersFirstName[$detail->manufacturer_name] != null)
                            $firstNameManufacturer = $manufacturersFirstName[$detail->manufacturer_name];
                        else $firstNameManufacturer = $manufacturersFirstName[$detail->manufacturer_name];
                    else $firstNameManufacturer = '';

                    if(isset($manufacturersSecondName[$detail->manufacturer_name]))
                        if($manufacturersSecondName[$detail->manufacturer_name] != "" && $manufacturersSecondName[$detail->manufacturer_name] != null)
                            $secondNameManufacturer = " ".$manufacturersSecondName[$detail->manufacturer_name];
                        else $secondNameManufacturer = $manufacturersSecondName[$detail->manufacturer_name];
                    else $secondNameManufacturer = '';


                    if(isset($manufacturersPhoneName[$detail->manufacturer_name]))
                        if($manufacturersPhoneName[$detail->manufacturer_name] != "" && $manufacturersPhoneName[$detail->manufacturer_name] != null)
                            $phoneManufacturer = $manufacturersPhoneName[$detail->manufacturer_name];
                        else  $phoneManufacturer = $manufacturersPhoneName[$detail->manufacturer_name];
                    else $phoneManufacturer = '';

                    if(isset($manufacturersNumberContainer[$detail->manufacturer_name]))
                        if($manufacturersNumberContainer[$detail->manufacturer_name] != "" && $manufacturersNumberContainer[$detail->manufacturer_name] != null)
                            $NumberContainerManufacturer = ", ".$manufacturersNumberContainer[$detail->manufacturer_name];
                        else  $NumberContainerManufacturer = $manufacturersNumberContainer[$detail->manufacturer_name];
                    else $NumberContainerManufacturer = '';


                    $data[$detail->manufacturer_name][0] = [

                        $dataFrom,
                        $dataTo,
                        'Rostovka.net '."\r\n".'Сергей'."\r\n".' тел: 0672533305',
                        $detail->manufacturer_name ,
                        $street.$NumberContainerManufacturer,
                        $firstNameManufacturer.' '.$secondNameManufacturer,
                        $phoneManufacturer,
                        date('d.m.y',(strtotime(Carbon::now())))
                    ];

                }

            }


            foreach ($orders as $order) {

                foreach ($order->details as $detail) {

                    if ($detail -> product() -> first() && $detail -> product() -> first() -> manufacturer() -> first())
                        $discount = $detail -> product() -> first() -> manufacturer() -> first() -> discount;

                    if($detail -> tip == "box") {
                        $type = 'ящ';
                        $count = $detail->box_count;

                        if($discount) {
	                        $discountTmp = explode("грн", $discount);
			                if(isset($discountTmp[1])) {
			                	$zakup = $detail->prise_zakup - $discountTmp[0];
			                    $finalPrise = $detail->tovar_in_order_count * $zakup * $detail->box_count;
			                }

			                $discountTmp = explode("%", $discount);
			                if(isset($discountTmp[1])) {
			                	$zakup = $detail->prise_zakup-($detail->prise_zakup * ($discountTmp[0]/100));
			                	$finalPrise = $detail->tovar_in_order_count * $zakup * $detail->box_count;
			                }
			            } else {
			            	$zakup = $detail->prise_zakup;
			            	$finalPrise = $detail->tovar_in_order_count * $zakup * $detail->box_count;
			            }
                     
                    }
                    else {
                        $type = 'рост';
                        $count = $detail->rostovka_count;

                        if($discount) {
	                        $discountTmp = explode("грн", $discount);
			                if(isset($discountTmp[1])) {
			                	$zakup = $detail->prise_zakup - $discountTmp[0];
			                	$finalPrise = $detail->tovar_in_order_count * ($detail->prise_zakup-$discountTmp[0]) * $detail->rostovka_count;
			                }

			                $discountTmp = explode("%", $discount);
			                if(isset($discountTmp[1])) {
			                	$zakup = $detail->prise_zakup-($detail->prise_zakup * ($discountTmp[0]/100));
			                	$finalPrise = $detail->tovar_in_order_count * ($detail->prise_zakup-($detail->prise_zakup * ($discountTmp[0]/100))) * $detail->rostovka_count;
			                }
			            } else {
			            	$zakup = $detail->prise_zakup;
			            	$finalPrise = $detail->tovar_in_order_count * $detail->prise_zakup * $detail->rostovka_count;
			            }
                    }


                    $number = count($data[$detail->manufacturer_name]);

                    $data[$detail->manufacturer_name][] = [
                        $number,
                        $detail->order_id,
                        $detail->image,
                        $detail->size_name,
                        $detail->article,
                        $type,
                        $detail->tovar_in_order_count,
                        $count,
                        $zakup,
                        $finalPrise

                    ];

                    
                }

            }

            $pdf = PDF::loadView('admin.pdf.order_list_with_photo', compact('data'));
            $pdf -> setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            return $pdf->download('СписокЗаказовПоставщикиФото.pdf');

        }else return redirect()->back()->withInput()->withErrors(['msg'=>'Not find items']);

    }

    public function getCsvFileWithOrdersPDF(Request $request){


        if(!$request -> dataFrom)
            $dataFrom = Carbon::now();
        if(!$request -> dataTo)
            $dataTo = Carbon::now();

        if($request -> dataFrom)
            $dataFrom = $request -> dataFrom;
        if($request -> dataTo)
            $dataTo = $request -> dataTo;


        if($dataFrom == $dataTo){

            $str = strtotime($dataTo);

            $dataToSecond = date('Y-m-d',($str+86400*1));


            $orders = Order::where('created_at', '>=', $dataTo)
                ->where('created_at', '<', $dataToSecond)
                -> whereIn('paid', [0,3])
                -> get();


        }else{

            $str = strtotime($dataTo);

            $dataToSecond = date('Y-m-d',($str+86400*1));

            $orders = Order::where('created_at', '>=', $dataFrom)
                -> where('created_at', '<=', $dataToSecond) -> whereIn('paid', [0,3])
                -> get();
        }

        // dd($request -> all());


        $data = [];
        $manufacturersNames = [];

        if($orders->count() > 0) {

            foreach ($orders as $order) {

                foreach ($order->details as $detail) {

                    if(!in_array($detail->manufacturer_name, $manufacturersNames))
                        $manufacturersNames[] = $detail->manufacturer_name;

                }

            }

            $manufacturersInfos = Manufacturer::whereIn('name', $manufacturersNames) -> pluck('street', 'name');

            $manufacturersFirstName = Manufacturer::whereIn('name', $manufacturersNames) -> pluck('firstName', 'name');
            $manufacturersSecondName = Manufacturer::whereIn('name', $manufacturersNames) -> pluck('secondName', 'name');
            $manufacturersPhoneName = Manufacturer::whereIn('name', $manufacturersNames) -> pluck('phone', 'name');
            $manufacturersNumberContainer = Manufacturer::whereIn('name', $manufacturersNames) -> pluck('numberContainer', 'name');

            //dd($manufacturersNames, $manufacturersInfos,$manufacturersFirstName,$manufacturersSecondName, $manufacturersPhoneName);


            foreach ($orders as $order) {

                foreach ($order->details as $detail) {

                    $time =  explode(' ',  Carbon::now());

                    if(isset($manufacturersInfos[$detail->manufacturer_name]))
                        if($manufacturersInfos[$detail->manufacturer_name] != "" && $manufacturersInfos[$detail->manufacturer_name] != null)
                            $street = $manufacturersInfos[$detail->manufacturer_name];
                        else $street = $manufacturersInfos[$detail->manufacturer_name];
                    else $street = 'Поставщик был удалён';

                    if(isset($manufacturersFirstName[$detail->manufacturer_name]))
                        if($manufacturersFirstName[$detail->manufacturer_name] != "" && $manufacturersFirstName[$detail->manufacturer_name] != null)
                            $firstNameManufacturer = $manufacturersFirstName[$detail->manufacturer_name];
                        else $firstNameManufacturer = $manufacturersFirstName[$detail->manufacturer_name];
                    else $firstNameManufacturer = '';

                    if(isset($manufacturersSecondName[$detail->manufacturer_name]))
                        if($manufacturersSecondName[$detail->manufacturer_name] != "" && $manufacturersSecondName[$detail->manufacturer_name] != null)
                            $secondNameManufacturer = " ".$manufacturersSecondName[$detail->manufacturer_name];
                        else $secondNameManufacturer = $manufacturersSecondName[$detail->manufacturer_name];
                    else $secondNameManufacturer = '';


                    if(isset($manufacturersPhoneName[$detail->manufacturer_name]))
                        if($manufacturersPhoneName[$detail->manufacturer_name] != "" && $manufacturersPhoneName[$detail->manufacturer_name] != null)
                            $phoneManufacturer = $manufacturersPhoneName[$detail->manufacturer_name];
                        else  $phoneManufacturer = $manufacturersPhoneName[$detail->manufacturer_name];
                    else $phoneManufacturer = '';

                    if(isset($manufacturersNumberContainer[$detail->manufacturer_name]))
                        if($manufacturersNumberContainer[$detail->manufacturer_name] != "" && $manufacturersNumberContainer[$detail->manufacturer_name] != null)
                            $NumberContainerManufacturer = ", ".$manufacturersNumberContainer[$detail->manufacturer_name];
                        else  $NumberContainerManufacturer = $manufacturersNumberContainer[$detail->manufacturer_name];
                    else $NumberContainerManufacturer = '';


                    $data[$detail->manufacturer_name][0] = [

                        $dataFrom,
                        $dataTo,
                        'Rostovka.net '."\r\n".'Сергей'."\r\n".' тел: 0672533305',
                        $detail->manufacturer_name ,
                        $street.$NumberContainerManufacturer,
                        $firstNameManufacturer.' '.$secondNameManufacturer,
                        $phoneManufacturer,
                        date('d.m.y',(strtotime(Carbon::now())))
                    ];

                }

            }


            foreach ($orders as $order) {

                foreach ($order->details as $detail) {
                    $number = count($data[$detail->manufacturer_name]);

                    $normArtikle = explode(mb_strtolower($detail->manufacturer_name), $detail->article);
                    if(isset($normArtikle[1])){

                        $artiklePrint = $normArtikle[1];

                    }else $artiklePrint = $detail->article;

                    //dd($normArtikle, $detail->manufacturer_name);

                    if($detail -> tip == "box") {
                        $type = 'ящ';
                        $count = $detail->box_count;
                        $finalPrise = $detail->tovar_in_order_count * $detail->prise_zakup * $detail->box_count;
                    }
                    else {
                        $type = 'рост';
                        $count = $detail->rostovka_count;
                        $finalPrise = $detail->tovar_in_order_count * $detail->prise_zakup * $detail->rostovka_count;
                    }

                    $data[$detail->manufacturer_name][] = [
                        $number,
                        $detail->order_id,
                        $detail->size_name,
                        $artiklePrint,
                        $type,
                        $detail->tovar_in_order_count,
                        $count,
                        (integer)$detail->prise_zakup,
                        $finalPrise

                    ];


                }

            }


            $pdf = PDF::loadView('admin.pdf.order_list_manufacturer', compact('data'));
            $pdf -> setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            return $pdf->download('СписокЗаказовПроизв.pdf');

        }else return redirect()->back()->withInput()->withErrors(['msg' => 'Not find items']);

    }

}
