<?php

namespace App\Http\Controllers\Admin\CSV;

use App\Manufacturer;
use App\Product;
use App\Season;
use App\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use PHPExcel_Worksheet_Drawing;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CsvDownloadController extends Controller
{
    public function getCsvFileWithProduct(Request $request){

        if($request -> manufacturer_id == 0){

            $manufacturer_id = Manufacturer::all()->pluck('id')->toArray();

        }else{

            $manufacturer_id = Manufacturer::where('id', $request -> manufacturer_id)->pluck('id')->toArray();

        }

        if(Type::where('id', $request -> type_id)->first())
            if(Type::where('id', $request -> type_id) ->first() -> name == 'Все')
                $type = Type::all()->pluck('id')->toArray();
            else  $type = Type::where('id', $request -> type_id)->pluck('id')->toArray();

        if($request -> season_id == 5)
            $season = Season::all()->pluck('id')->toArray();
        else  $season = Season::where('id', $request -> season_id)->pluck('id')->toArray();


        $accessibility = [0,1];


        if ($request->accessibility == 0) {
            $accessibility = [0];

        }
        if ($request->accessibility == 1) {
            $accessibility = [1];

        }


        $products = Product::with('category','manufacturer','season','type', 'size', 'photo')
            -> whereIn('manufacturer_id', $manufacturer_id) ->whereIn('type_id', $type)
            ->whereIn('season_id', $season) -> whereIn('accessibility',$accessibility)-> get();

        //dd($request -> all(), $season, $type, $products, $accessibility);

        if($products -> count() > 0) {
            $data = [];
            $i = 0;
            foreach ($products as $product) {

                $i++;

                if($product -> photo) {
                    $photo_name = explode('.', $product->photo->photo_url);
                    $photo_one = $photo_name[0];
                }
                else $photo_one = '';

                if($product->size)
                    $size = $product->size->name;
                else $size = 'none';

                //dd($product->accessibility);

                switch ($product->category_id){

                    case 1 :
                        $categoryName = "Детская";
                        break;
                    case 2 :
                        $categoryName = "Мужская";
                        break;
                    case 3 :
                        $categoryName = "Женская";
                        break;
                    default :
                        $categoryName = "Другая";
                }


                if ( $request -> gloves == 'true' )
                    $data[] = [

                        "ID" => $product->id,
                        "Артикул" => $product->article,
                        "Цена закупки" => $product->prise_zakup,
                        "Цена продажи" => $product->prise_default,
                        "Валюта" => $product->currency,
                        "Бренд" => $product->manufacturer->name,
                        "Размер" => $size,
                        "Тип" => $product->type->name,
                        "Категория" => $categoryName,
                        "Пол" => $product->sex,
                        "Сезон" => $product->season->name,
                        "Кол в палете" => $product->rostovka_count,
                        "Кол в упаковке" => $product->box_count,
                        "Наличие" => (string)$product->accessibility,
                        "Цвет" =>$product ->color,
                        "Скидка" => $product->discount,
                        "Страна производитель" =>$product ->manufacturer_country,
                        "Материал верх" =>$product ->material,
                        "Материал внутри" =>$product ->material_inside,
                        "Описание" => $product->full_description,
                        "Фото1" => $photo_one,
                        "Фото2" => "",
                        "Фото3" => ""
    //                  "tip_vyazki" => $product ->tip_vyazki

                    ];
                else
                    $data[] = [

                        "ID" => $product->id,
                        "Артикул" => $product->article,
                        "Цена закупки" => $product->prise_zakup,
                        "Цена продажи" => $product->prise_default,
                        "Скидка" => $product->discount,
                        "Валюта" => $product->currency,
                        "Наличие" => (string)$product->accessibility,
                        "Бренд" => $product->manufacturer->name,
                        "Размер" => $size,
                        "Тип обуви" => $product->type->name,
                        "Категория" => $categoryName,
                        "Пол" => $product->sex,
                        "Сезон" => $product->season->name,
                        "Кол в ящике" => $product->box_count,
                        "Мин. Кол" => $product->rostovka_count,


                        //"show_product" => $product ->show_product,
                        "Описание" => $product->full_description,

                        "Материал верх" =>$product ->material,
                        "Материал внутри" =>$product ->material_inside,
                        "Материал стельки" =>$product ->material_insoles,
                        "Цвет" =>$product ->color,
                        "Страна производитель" =>$product ->manufacturer_country,
                        "Повторы" =>$product ->repeats,

                        "Фото1" => $photo_one,
                        "Фото2" => "",
                        "Фото3" => ""
    //                  "tip_vyazki" => $product ->tip_vyazki

                    ];

            }

            Excel::create('Товары Редакт', function ($excel) use ($data) {

                $excel->sheet('Sheetname', function ($sheet) use ($data) {

                    for ($i = 1; $i < count($data) + 1; $i++) {

                        $sheet->setHeight($i, 25);

                    }

                    $sheet->fromArray($data);

                });

            })->export('xlsx');
        }else return redirect()->back()->withInput()->withErrors(['msg'=> 'Not find items']);

    }

    public function testPost(Request $request) {
        $type = json_decode($request -> type_id);
        $season = json_decode($request -> season_id);
        $manufacturer = json_decode($request -> manufacturer_id);

        if ($type) $type = Type::whereIn('id', $type)->pluck('id')->toArray();
        else $type = Type::all()->pluck('id')->toArray();

        if ($season) $season = Season::whereIn('id', $season)->pluck('id')->toArray();
        else $season = Season::all()->pluck('id')->toArray();

        if ($manufacturer) $manufacturer = Manufacturer::whereIn('id', $manufacturer)->pluck('id')->toArray();
        else $manufacturer = Manufacturer::all()->pluck('id')->toArray();

        $accessibility = json_decode($request -> accessibility);

        if ($accessibility) $products = Product::whereIn('manufacturer_id', $manufacturer) 
            -> whereIn('type_id', $type)
            -> whereIn('season_id', $season)-> whereIn('accessibility', $accessibility)
            -> with('category','manufacturer','season','type', 'size', 'photo') -> get();

        else $products = Product::whereIn('manufacturer_id', $manufacturer) ->whereIn('type_id', $type)
            -> whereIn('season_id', $season)
            -> with('category','manufacturer','season','type', 'size', 'photo') -> get();

        return response($products);
    }

    public function testDownload(Request $request) {

        $type = json_decode($request -> type_id);
        $season = json_decode($request -> season_id);
        $manufacturer = json_decode($request -> manufacturer_id);
        $countries = json_decode($request -> countries);
        $colors = json_decode($request -> colors);

        if ($type) $type = Type::whereIn('id', $type)->pluck('id')->toArray();
        else $type = Type::all()->pluck('id')->toArray();

        if ($season) $season = Season::whereIn('id', $season)->pluck('id')->toArray();
        else $season = Season::all()->pluck('id')->toArray();

        if ($manufacturer) $manufacturer = Manufacturer::whereIn('id', $manufacturer)->pluck('id')->toArray();
        else $manufacturer = Manufacturer::all()->pluck('id')->toArray();

        $accessibility = json_decode($request -> accessibility);

        if ($accessibility) $products = Product::whereIn('manufacturer_id', $manufacturer) 
            -> whereIn('type_id', $type)
            -> whereIn('season_id', $season)-> whereIn('accessibility', $accessibility)
            -> orderBy('manufacturer_id')
            -> orderBy('name')
            -> with('category','manufacturer','season','type', 'size');

        else $products = Product::whereIn('manufacturer_id', $manufacturer) ->whereIn('type_id', $type)
            -> whereIn('season_id', $season)
            -> orderBy('manufacturer_id')
            -> orderBy('name')
            -> with('category','manufacturer','season','type', 'size');

        if ( $request -> gloves == 'true' ) $products->where('category_id', 4);

        if ($countries)
            $products->whereIn('manufacturer_country', $countries);

        if ($colors)
            $products->Where(function ($query) use($colors) {
                for ($i = 0; $i < count($colors); $i++){
                    $query->orwhere('color', 'like',  '%' . $colors[$i] .'%');
                }      
            });

        $products = $products->get();

        if($products -> count() > 0) {
            $data = [];
            $i = 0;
            foreach ($products as $product) {

                $i++;

                if($product -> photo) {
                    $photo_name = explode('.', $product->photo->photo_url);
                    $photo_one = $photo_name[0];
                }
                else $photo_one = '';

                if($product->size)
                    $size = $product->size->name;
                else $size = 'none';

                //dd($product->accessibility);

                switch ($product->category_id){

                    case 1 :
                        $categoryName = "Детская";
                        break;
                    case 2 :
                        $categoryName = "Мужская";
                        break;
                    case 3 :
                        $categoryName = "Женская";
                        break;
                    default :
                        $categoryName = "Перчатки";
                }



                if ( $request -> gloves == 'true' )
                    $data[] = [

                        "ID" => $product->id,
                        "Артикул" => $product->article,
                        "Цена закупки" => $product->prise_zakup,
                        "Цена продажи" => $product->prise_default,
                        "Валюта" => $product->currency,
                        "Бренд" => $product->manufacturer->name,
                        "Размер" => $size,
                        "Тип" => $product->type->name,
                        "Категория" => $categoryName,
                        "Пол" => $product->sex,
                        "Сезон" => $product->season->name,
                        "Кол в палете" => $product->rostovka_count,
                        "Кол в упаковке" => $product->box_count,
                        "Наличие" => (string)$product->accessibility,
                        "Цвет" =>$product ->color,
                        "Скидка" => $product->discount,
                        "Страна производитель" =>$product ->manufacturer_country,
                        "Материал верх" =>$product ->material,
                        "Материал внутри" =>$product ->material_inside,
                        "Описание" => $product->full_description,
                        "Фото1" => $photo_one,
                        "Фото2" => "",
                        "Фото3" => ""
    //                  "tip_vyazki" => $product ->tip_vyazki

                    ];
                else
                    $data[] = [

                        "ID" => $product->id,
                        "Артикул" => $product->article,
                        "Цена закупки" => $product->prise_zakup,
                        "Цена продажи" => $product->prise_default,
                        "Скидка" => $product->discount,
                        "Валюта" => $product->currency,
                        "Наличие" => (string)$product->accessibility,
                        "Бренд" => $product->manufacturer->name,
                        "Размер" => $size,
                        "Тип обуви" => $product->type->name,
                        "Категория" => $categoryName,
                        "Пол" => $product->sex,
                        "Сезон" => $product->season->name,
                        "Кол в ящике" => $product->box_count,
                        "Мин. Кол" => $product->rostovka_count,


                        //"show_product" => $product ->show_product,
                        "Описание" => $product->full_description,

                        "Материал верх" =>$product ->material,
                        "Материал внутри" =>$product ->material_inside,
                        "Материал стельки" =>$product ->material_insoles,
                        "Цвет" =>$product ->color,
                        "Страна производитель" =>$product ->manufacturer_country,
                        "Повторы" =>$product ->repeats,

                        "Фото1" => $photo_one,
                        "Фото2" => "",
                        "Фото3" => ""
    //                  "tip_vyazki" => $product ->tip_vyazki

                    ];

            }

            Excel::create('Товары Редакт', function ($excel) use ($data) {

                $excel->sheet('Sheetname', function ($sheet) use ($data) {

                    for ($i = 1; $i < count($data) + 1; $i++) {

                        $sheet->setHeight($i, 25);

                    }

                    $sheet->fromArray($data);

                });

            })->export('xlsx');
        }else return redirect()->back()->withInput()->withErrors(['msg'=> 'Not find items']);
    }

    public function fullDownloadPDF(Request $request) {
        $type = json_decode($request -> type_id);
        $season = json_decode($request -> season_id);
        $manufacturer = json_decode($request -> manufacturer_id);

        if ($type) $type = Type::whereIn('id', $type)->pluck('id')->toArray();
        else $type = Type::all()->pluck('id')->toArray();

        if ($season) $season = Season::whereIn('id', $season)->pluck('id')->toArray();
        else $season = Season::all()->pluck('id')->toArray();

        if ($manufacturer) $manufacturer = Manufacturer::whereIn('id', $manufacturer)->pluck('id')->toArray();
        else $manufacturer = Manufacturer::all()->pluck('id')->toArray();

        $accessibility = json_decode($request -> accessibility);

        if (!$accessibility) $accessibility = [0, 1];
        
        $products = new Collection();

        Product::whereIn('manufacturer_id', $manufacturer) 
            -> whereIn('type_id', $type)
            -> whereIn('season_id', $season)
            -> whereIn('accessibility', $accessibility)
            -> orderBy('manufacturer_id')
            -> with('category', 'manufacturer', 'season', 'type', 'size', 'photo') 
            -> chunk(1000, function($chProd) use (&$products) {
                $products = $products->merge($chProd);
            });


        //dd($products);

        if($products->count() > 0) {
            $normalTimeLimit = ini_get('max_execution_time');

            set_time_limit(0);

            $data = [];

            $manId = $products[0]->manufacturer->id;
            $dId = 0;

            array_push($data, ["manufacturer" => $products[0]->manufacturer, "products" => [], "date" => date('d.m.Y',(strtotime(Carbon::now())))]);

            foreach ($products as $product) {

                if($product->size)
                    $size = $product->size->name;
                else $size = 'none';

                if ($manId == $product->manufacturer->id)
                    array_push($data[$dId]["products"], [
                        $product->name,
                        $size,
                        $product->box_count,
                        $product->prise_zakup,
                        $product->prise
                    ]);
                else {
                    array_push($data, [
                        "manufacturer" => $product->manufacturer, 
                        "products" => [[
                            $product->name,
                            $size,
                            $product->box_count,
                            $product->prise_zakup,
                            $product->prise
                        ]],
                        "date" => date('d.m.Y',(strtotime(Carbon::now())))
                    ]);

                    $dId++;
                    $manId = $product->manufacturer->id;
                }

            }

            $pdf = PDF::loadView('admin.pdf.productNoPhoto', compact('data'));
            $pdf -> setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);

            ini_set('max_execution_time', $normalTimeLimit);
            return $pdf->download('Товары Пост.pdf');
        } else return redirect()->back()->withInput()->withErrors(['msg'=> 'Not find items']);
    }

    public function testDownloadPDF(Request $request) {
        $normalTimeLimit = ini_get('max_execution_time');
        ini_set('max_execution_time', 0);
        
        $type = json_decode($request -> type_id);
        $season = json_decode($request -> season_id);
        $manufacturer = json_decode($request -> manufacturer_id);
        $photo = json_decode($request -> photo);

        if ($type) $type = Type::whereIn('id', $type)->pluck('id')->toArray();
        else $type = Type::all()->pluck('id')->toArray();

        if ($season) $season = Season::whereIn('id', $season)->pluck('id')->toArray();
        else $season = Season::all()->pluck('id')->toArray();

        if ($manufacturer) $manufacturer = Manufacturer::whereIn('id', $manufacturer)->pluck('id')->toArray();
        else $manufacturer = Manufacturer::all()->pluck('id')->toArray();

        $accessibility = json_decode($request -> accessibility);

        if ($accessibility) $products = Product::whereIn('manufacturer_id', $manufacturer) 
            -> whereIn('type_id', $type)
            -> whereIn('season_id', $season)-> whereIn('accessibility', $accessibility)
            -> orderBy('manufacturer_id')
            -> orderBy('name')
            -> with('category', 'manufacturer', 'season', 'type', 'size');

        else $products = Product::whereIn('manufacturer_id', $manufacturer) ->whereIn('type_id', $type)
            -> whereIn('season_id', $season)
            -> orderBy('manufacturer_id')
            -> orderBy('name')
            -> with('category', 'manufacturer', 'season', 'type', 'size');

        if ( $request -> gloves == 'true' ) $products = $products->where('category_id', 4)->get();
        else $products = $products->get();

        if($products->count() > 0) {
            if($photo) {
                $data = [];

                $manId = $products[0]->manufacturer->id;
                $dId = 0;

                array_push($data, ["manufacturer" => $products[0]->manufacturer, "products" => [], "date" => date('d.m.Y',(strtotime(Carbon::now())))]);

                foreach ($products as $product) {

                    if($product->photo)
                        $photo = $product->photo->photo_url;
                    else $photo = "";

                    if($product->size)
                        $size = $product->size->name;
                    else $size = 'none';



                    if ($manId == $product->manufacturer->id)
                        array_push($data[$dId]["products"], [
                            $photo,
                            $product->name,
                            $size,
                            $product->box_count,
                            $product->prise_zakup,
                            $product->prise
                        ]);
                    else {
                        array_push($data, [
                            "manufacturer" => $product->manufacturer, 
                            "products" => [[
                                $photo,
                                $product->name,
                                $size,
                                $product->box_count,
                                $product->prise_zakup,
                                $product->prise
                            ]],
                            "date" => date('d.m.Y',(strtotime(Carbon::now())))
                        ]);

                        $dId++;
                        $manId = $product->manufacturer->id;
                    }

                }

                $pdf = PDF::loadView('admin.pdf.productWithPhoto', compact('data'));
                $pdf -> setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);

                ini_set('max_execution_time', $normalTimeLimit);
                return $pdf->download('Товары Пост Фото.pdf');
            } else {
                $data = [];

                $manId = $products[0]->manufacturer->id;
                $dId = 0;

                array_push($data, ["manufacturer" => $products[0]->manufacturer, "products" => [], "date" => date('d.m.Y',(strtotime(Carbon::now())))]);

                foreach ($products as $product) {

                    if($product->size)
                        $size = $product->size->name;
                    else $size = 'none';

                    if ($manId == $product->manufacturer->id)
                        array_push($data[$dId]["products"], [
                            $product->name,
                            $size,
                            $product->box_count,
                            $product->prise_zakup,
                            $product->prise
                        ]);
                    else {
                        array_push($data, [
                            "manufacturer" => $product->manufacturer, 
                            "products" => [[
                                $product->name,
                                $size,
                                $product->box_count,
                                $product->prise_zakup,
                                $product->prise
                            ]],
                            "date" => date('d.m.Y',(strtotime(Carbon::now())))
                        ]);

                        $dId++;
                        $manId = $product->manufacturer->id;
                    }

                }

                $pdf = PDF::loadView('admin.pdf.productNoPhoto', compact('data'));
                $pdf -> setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);

                ini_set('max_execution_time', $normalTimeLimit);
                return $pdf->download('Товары Пост.pdf');
            }
        } else return redirect()->back()->withInput()->withErrors(['msg'=> 'Not find items']);
    }

    public function getCsvFileWithOrdersToManufacturer(Request $request){

        if(Type::where('id', $request -> type_id)->first())
            if(Type::where('id', $request -> type_id) ->first() -> name == 'Все')
                $type = Type::all()->pluck('id')->toArray();
            else  $type = Type::where('id', $request -> type_id)->pluck('id')->toArray();

        if($request -> season_id == 5)
            $season = Season::all()->pluck('id')->toArray();
        else  $season = Season::where('id', $request -> season_id)->pluck('id')->toArray();

        $accessibility = [0,1];

        if ($request->accessibility == 0) {
            $accessibility = [0];

        }
        if ($request->accessibility == 1) {
            $accessibility = [1];

        }



        $products = Product::with('category','manufacturer','season','type', 'size', 'photo')
            -> where('manufacturer_id', $request -> manufacturer_id) ->whereIn('type_id', $type)
            ->whereIn('season_id', $season)-> whereIn('accessibility',$accessibility)-> get();

        if($products->count() > 0) {
            $data = [];
            $photosData = [];


            foreach ($products as $product) {

                if($product->photo)
                    $photo = $product->photo->photo_url;
                else $photo = "";

                if($product->size)
                    $size = $product->size->name;
                else $size = 'none';



                $data[] = [

                    "",
                    $product->name,
                    $size,
                    $product->box_count,
                    $product->prise_zakup,
                    $product->prise,

                ];
                $photosData[] = ["Фото" => $photo];

            }

            $manufacturerInfo = $products[0]->manufacturer;

            //dd($manufacturerInfo);

            Excel::create('Товары Пост Фото', function ($excel) use ($data, $photosData,$manufacturerInfo) {

                $excel->sheet('Sheetname', function ($sheet) use ($data, $photosData,$manufacturerInfo) {

                    for ($i = 1; $i < count($data) + 3; $i++) {

                        if ($i > 2)
                            $sheet->setHeight($i, 50);
                        else
                            $sheet->setHeight($i, 25);

                        $size = 2 + $i;

                        $sheet->getStyle('A'.$size.':F'.$size)->getAlignment()->applyFromArray(
                            array('horizontal' => 'left', 'vertical' => 'center')
                        );

                    }


                    if($manufacturerInfo -> street != "" &&  $manufacturerInfo -> street != null)
                        $streetManufacturer = ", ".$manufacturerInfo -> street;
                    else $streetManufacturer = '';

                    if($manufacturerInfo -> firstName != "" &&  $manufacturerInfo -> firstName != null)
                        $firstNameManufacturer = ", ".$manufacturerInfo -> firstName;
                    else $firstNameManufacturer = '';

                    if($manufacturerInfo -> secondName != "" &&  $manufacturerInfo -> secondName != null)
                        $secondNameManufacturer = " ".$manufacturerInfo -> secondName;
                    else $secondNameManufacturer = '';

                    if($manufacturerInfo -> phone != "" &&  $manufacturerInfo -> phone != null)
                        $phoneManufacturer = ", ".$manufacturerInfo -> phone;
                    else $phoneManufacturer = '';

                    if($manufacturerInfo -> numberContainer != "" &&  $manufacturerInfo -> numberContainer != null)
                        $containerManufacturer = ", ".$manufacturerInfo -> numberContainer;
                    else $containerManufacturer = '';

                    $dataTo = Carbon::now();

                    $str = strtotime($dataTo);

                    $dataToSecond = date('Y-m-d',($str+86400*1));

                    $sheet->row(1, array("Фото",
                        $dataToSecond."\r\n".""."\r\n"."Поставщик: ".$manufacturerInfo -> name."".$streetManufacturer."". $containerManufacturer."".$firstNameManufacturer."". $secondNameManufacturer."".$phoneManufacturer,
                        "",
                        "Rostovka"."\r\n".""."\r\n"."Сергей, 0672533305","",""));




                    $sheet->setHeight(1, 60);

                    $sheet->mergeCells('B1:C1');
                    $sheet->mergeCells('D1:F1');

                    $sheet->getStyle('A1:C1')->getAlignment()->applyFromArray(
                        array('horizontal' => 'left', 'vertical' => 'center')
                    );
                    $sheet->getStyle('D1:F1')->getAlignment()->applyFromArray(
                        array('horizontal' => 'center', 'vertical' => 'center',
                            'font' => array(
                                'size' => 600,
                            ))
                    );

                    $sheet->row(2, array("",
                        "Товар",
                        "размер",
                        "Пар в ящике",
                        "Цена закуп",
                        "Цена сайт"));

                    //dd($data);

                    //$sheet->fromArray($data);




                    for ($i = 0; $i < count($data); $i++) {

                        $insertIntoTableValue = [
                            $data[$i][0],
                            $data[$i][1],
                            $data[$i][2],
                            $data[$i][3],
                            $data[$i][4],
                            $data[$i][5]
                        ];



                        $sheet->row(3 + $i, $insertIntoTableValue);


                    }
                    $sheet->setWidth('A', 9);
                    $sheet->setWidth('B', 48);
                    $sheet->setWidth('C', 10);
                    $sheet->setWidth('D', 12);
                    $sheet->setWidth('E', 10);
                    $sheet->setWidth('F', 10);
                    $sheet->setWidth('G', 20);
                    $sheet->setWidth('H', 20);



                    for ($i = 0; $i < count($photosData); $i++) {

                        if($photosData[$i]['Фото'] != "")

                            if (file_exists( 'images/products/' . $photosData[$i]['Фото'])) {
                                $objDrawing = new PHPExcel_Worksheet_Drawing;
                                $objDrawing->setPath(public_path('images/products/' . $photosData[$i]['Фото'])); //your image path
                                $objDrawing->setName('imageRussik');
                                $objDrawing->setWorksheet($sheet);
                                $objDrawing->setCoordinates('A' . ($i + 3));
                                $objDrawing->setResizeProportional();
                                $objDrawing->setOffsetX($objDrawing->getWidth() - $objDrawing->getWidth() / 5);
                                $objDrawing->setOffsetY(0);
                                $objDrawing->setOffsetX(10);
                                $objDrawing->setWidth(80);
                                $objDrawing->setHeight(55);
                            }

                    }

                });

            })->export('xlsx');
        }else return redirect()->back()->withInput()->withErrors(['msg'=> 'Not find items']);
    }

    public function getCsvFileWithOrdersToManufacturerOhnePhoto(Request $request){

        if(Type::where('id', $request -> type_id)->first())
            if(Type::where('id', $request -> type_id) ->first() -> name == 'Все')
                $type = Type::all()->pluck('id')->toArray();
            else  $type = Type::where('id', $request -> type_id)->pluck('id')->toArray();

        if($request -> season_id == 5)
            $season = Season::all()->pluck('id')->toArray();
        else  $season = Season::where('id', $request -> season_id)->pluck('id')->toArray();

        $accessibility = [0,1];

        if ($request->accessibility == 0) {
            $accessibility = [0];

        }
        if ($request->accessibility == 1) {
            $accessibility = [1];

        }



        $products = Product::with('category','manufacturer','season','type', 'size', 'photo')
            -> where('manufacturer_id', $request -> manufacturer_id) ->whereIn('type_id', $type)
            ->whereIn('season_id', $season)-> whereIn('accessibility',$accessibility)-> get();

        if($products->count() > 0) {
            $data = [];
            $photosData = [];


            foreach ($products as $product) {

                if($product->photo)
                    $photo = $product->photo->photo_url;
                else $photo = "";

                if($product->size)
                    $size = $product->size->name;
                else $size = 'none';

                $data[] = [
                    $product->name,
                    $size,
                    $product->box_count,
                    $product->prise_zakup,
                    $product->prise,

                ];


            }


            $manufacturerInfo = $products[0]->manufacturer;


            Excel::create('Товары Пост', function ($excel) use ($data, $manufacturerInfo) {

                $excel->sheet('Sheetname', function ($sheet) use ($data, $manufacturerInfo) {

                    for ($i = 1; $i < count($data) + 3; $i++) {

                        if ($i > 2)
                            $sheet->setHeight($i, 18);
                        else
                            $sheet->setHeight($i, 25);

                        $size = 2 + $i;

                        $sheet->getStyle('A'.$size.':E'.$size)->getAlignment()->applyFromArray(
                            array('horizontal' => 'left', 'vertical' => 'center')
                        );

                    }


                    if($manufacturerInfo -> street != "" &&  $manufacturerInfo -> street != null)
                        $streetManufacturer = ", ".$manufacturerInfo -> street;
                    else $streetManufacturer = '';

                    if($manufacturerInfo -> firstName != "" &&  $manufacturerInfo -> firstName != null)
                        $firstNameManufacturer = ", ".$manufacturerInfo -> firstName;
                    else $firstNameManufacturer = '';

                    if($manufacturerInfo -> secondName != "" &&  $manufacturerInfo -> secondName != null)
                        $secondNameManufacturer = " ".$manufacturerInfo -> secondName;
                    else $secondNameManufacturer = '';

                    if($manufacturerInfo -> phone != "" &&  $manufacturerInfo -> phone != null)
                        $phoneManufacturer = ", ".$manufacturerInfo -> phone;
                    else $phoneManufacturer = '';

                    if($manufacturerInfo -> numberContainer != "" &&  $manufacturerInfo -> numberContainer != null)
                        $containerManufacturer = ", ".$manufacturerInfo -> numberContainer;
                    else $containerManufacturer = '';

                    $dataTo = Carbon::now();

                    $str = strtotime($dataTo);

                    $dataToSecond = date('Y-m-d',($str+86400*1));

                    $sheet->row(1, array(
                        $dataToSecond."\r\n".""."\r\n"."Поставщик: ".$manufacturerInfo -> name."".$streetManufacturer."". $containerManufacturer."".$firstNameManufacturer."". $secondNameManufacturer."".$phoneManufacturer,
                        "",
                        "Rostovka"."\r\n".""."\r\n"."Сергей, 0672533305","",""));



                    $sheet->setHeight(1, 60);

                    $sheet->mergeCells('A1:B1');
                    $sheet->mergeCells('C1:E1');

                    $sheet->getStyle('A1:B1')->getAlignment()->applyFromArray(
                        array('horizontal' => 'left', 'vertical' => 'center')
                    );
                    $sheet->getStyle('C1:E1')->getAlignment()->applyFromArray(
                        array('horizontal' => 'center', 'vertical' => 'center',
                            'font' => array(
                                'size' => 600,
                            ))
                    );

                    $sheet->row(2, array(
                        "Товар",
                        "размер",
                        "Пар в ящике",
                        "Цена закуп",
                        "Цена сайт"));

                    //dd($data);

                    //$sheet->fromArray($data);




                    for ($i = 0; $i < count($data); $i++) {

                        $insertIntoTableValue = [
                            $data[$i][0],
                            $data[$i][1],
                            $data[$i][2],
                            $data[$i][3],
                            $data[$i][4]
                        ];



                        $sheet->row(3 + $i, $insertIntoTableValue);


                    }
                    $sheet->setWidth('A', 48);
                    $sheet->setWidth('B', 9);
                    $sheet->setWidth('C', 10);
                    $sheet->setWidth('D', 12);
                    $sheet->setWidth('E', 10);
                    $sheet->setWidth('F', 10);
                    $sheet->setWidth('G', 20);
                    $sheet->setWidth('H', 20);


                });

            })->export('xlsx');
        }else return redirect()->back()->withInput()->withErrors(['msg'=> 'Not find items']);
    }

    public function getCsvFileWithOrdersToManufacturerPDF(Request $request){

        if(Type::where('id', $request -> type_id)->first())
            if(Type::where('id', $request -> type_id) ->first() -> name == 'Все')
                $type = Type::all()->pluck('id')->toArray();
            else  $type = Type::where('id', $request -> type_id)->pluck('id')->toArray();

        if($request -> season_id == 5)
            $season = Season::all()->pluck('id')->toArray();
        else  $season = Season::where('id', $request -> season_id)->pluck('id')->toArray();

        $accessibility = [0,1];

        if ($request->accessibility == 0) {
            $accessibility = [0];

        }
        if ($request->accessibility == 1) {
            $accessibility = [1];

        }



        $products = Product::with('category','manufacturer','season','type', 'size', 'photo')
            -> where('manufacturer_id', $request -> manufacturer_id) ->whereIn('type_id', $type)
            ->whereIn('season_id', $season)-> whereIn('accessibility',$accessibility)-> get();
        $products = $products -> sortBy('name');
        if($products->count() > 0) {
            $data = [];
            $photosData = [];

            foreach ($products as $product) {

                if($product->photo)
                    $photo = $product->photo->photo_url;
                else $photo = "";

                if($product->size)
                    $size = $product->size->name;
                else $size = 'none';



                $data[] = [

                    $photo,
                    $product->name,
                    $size,
                    $product->box_count,
                    $product->prise_zakup,
                    $product->prise,

                ];
                $photosData[] = ["Фото" => $photo];

            }

            $manufacturerInfo = $products[0]->manufacturer;
            $manufacturerInfo -> date =  date('d.m.Y',(strtotime(Carbon::now())+86400*1));


            $pdf = PDF::loadView('admin.pdf.productWithPhoto', compact('data', 'photosData', 'manufacturerInfo'));
            $pdf -> setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            return $pdf->download('Товары Пост Фото.pdf');
        }else return redirect()->back()->withInput()->withErrors(['msg'=> 'Not find items']);
    }

    public function getCsvFileWithOrdersToManufacturerOhnePhotoPDF(Request $request){

        if(Type::where('id', $request -> type_id)->first())
            if(Type::where('id', $request -> type_id) ->first() -> name == 'Все')
                $type = Type::all()->pluck('id')->toArray();
            else  $type = Type::where('id', $request -> type_id)->pluck('id')->toArray();

        if($request -> season_id == 5)
            $season = Season::all()->pluck('id')->toArray();
        else  $season = Season::where('id', $request -> season_id)->pluck('id')->toArray();

        $accessibility = [0,1];

        if ($request->accessibility == 0) {
            $accessibility = [0];

        }
        if ($request->accessibility == 1) {
            $accessibility = [1];

        }



        $products = Product::with('category','manufacturer','season','type', 'size', 'photo')
            -> where('manufacturer_id', $request -> manufacturer_id) ->whereIn('type_id', $type)
            ->whereIn('season_id', $season)-> whereIn('accessibility',$accessibility)-> get();
        $products = $products -> sortBy('name');
        if($products->count() > 0) {
            $data = [];
            $photosData = [];


            foreach ($products as $product) {

                if($product->photo)
                    $photo = $product->photo->photo_url;
                else $photo = "";

                if($product->size)
                    $size = $product->size->name;
                else $size = 'none';

                $data[] = [
                    $product->name,
                    $size,
                    $product->box_count,
                    $product->prise_zakup,
                    $product->prise,

                ];


            }


            $manufacturerInfo = $products[0]->manufacturer;
            $manufacturerInfo -> date =  date('d.m.Y',(strtotime(Carbon::now())+86400*1));



            $pdf = PDF::loadView('admin.pdf.productNoPhoto', compact('data', 'manufacturerInfo'));
            $pdf -> setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            return $pdf->download('Товары Пост.pdf');
        }else return redirect()->back()->withInput()->withErrors(['msg'=> 'Not find items']);
    }

}
