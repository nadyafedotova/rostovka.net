<?php

namespace App\Http\Controllers\Admin\CSV;

use App\Category;
use App\Http\Requests\CsvPostRequest;
use App\Manufacturer;
use App\Product;
use App\ProductPhotos;
use App\ProductNovelty;
use App\Season;
use App\Size;
use App\Type;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

use ZipArchive;
use Illuminate\Support\Facades\File;

class CsvLoadController extends Controller
{
    public function index(){

        return view('csv_load');

    }

    public function edit(){

        return view('csv_load_edit');

    }

    public function checkDooble($products){

        $check_array = [];

        foreach ($products as $product){

            $check_array[] = [$product -> artikul, $product -> brend];

        }

        for($i = 0; $i < count($check_array); $i ++){

            for($j = 0; $j < count($check_array); $j ++){

                if($i != $j && strval($check_array[$i][0]) == strval($check_array[$j][0]) && strval($check_array[$i][1]) == strval($check_array[$j][1])){


                   // dd([$check_array[$i][0], $check_array[$i][1]]);

                    return true;

                }

            }

        }

        return false;

    }



    public function csvShoesDelete(CsvPostRequest $request){

        $path = $request->file('files')->getRealPath();

        $products = Excel::load($path, function($reader) {
        })->get();

        $products = $this ->checkEmpty($products);

        $delete_array = [];

        foreach ($products as $product){

            $delete_array[] = $product -> id;

        }

        Product::whereIn('id', $delete_array) -> delete();

        $photos = ProductPhotos::whereIn('product_id', $delete_array) -> pluck('photo_url');

        ProductPhotos::whereIn('product_id', $delete_array) -> delete();

        ProductNovelty::whereIn('product_id', $delete_array) -> delete();

        foreach ($photos as $photo){
            if(file_exists('images/products/' . $photo))
            File::delete('images/products/' . $photo);

        }

    }

    public function onlyPhotoUpdate(CsvPostRequest $request){

        $path = $request->file('files')->getRealPath();

        $products = Excel::load($path, function($reader) {
        })->get();

        $this ->checkSex($products);

        $products = $this ->checkEmpty($products);

        foreach ($products as $product){

            ProductPhotos::where('product_id',$product -> id) -> update(['photo_url' =>$product -> foto1.'.jpg']);

        }


    }


    public function csvShoesUpdate(CsvPostRequest $request)
    {
        $path = $request->file('files')->getRealPath();

        $products = Excel::load($path, function($reader) {
        })->get();

        $this ->checkSex($products);

        $products = $this ->checkEmpty($products);

        $this->productsUpdate($products);

        if($request -> photo && $request -> photo != 'undefined') {

            $this->productsPhotoUpdate($request, $products);

            $this->photosRename($products);
        }

    }

    public function checkSex($products){

        $i = 0;

        foreach ($products as $product){



            if($product -> kategoriya == 'Детская' ){



            }

        }

    }

    public function productsPhotoUpdate($photos, $products)
    {
            $zip = new ZipArchive;
            $zip->open($photos->photo->getRealPath());
            $zip->extractTo('../images/products/');
            $zip->close();

            $products_mass = [];

            foreach ($products as $product) {

                $products_mass[$product->artikul . ' ' . ucfirst(trim($product ->{'brend'}))] = [[$product->foto1, $product->foto2, $product->foto3]];

            }

            $data_base_products = Product::whereIn('name', array_keys($products_mass))->pluck('id', 'name')->toArray();

            foreach ($products_mass as $key => $photo_to_product_value) {

                foreach ($photo_to_product_value[0] as $item) {

                    if ($item && file_exists('../images/products/'.$item.'.jpg')) {
                        ProductPhotos::where('product_id', '=', $data_base_products[$key])
                            ->update(['photo_url' => $data_base_products[$key] . "_" . $item . '.jpg']);
                    }
                }
            }


    }

    public function productsUpdate($products){


        $types = Type::all() -> pluck('id', 'name') -> toArray();
        $seasons = Season::all() -> pluck('id', 'name') -> toArray();
        $sizes = Size::all()  -> pluck('id', 'name') -> toArray();
        $categories = Category::all() -> pluck('id', 'name') -> toArray();
        $manufacturers = Manufacturer::all() -> pluck('id', 'name') -> toArray();
        $manufacturersInfo = Manufacturer::all();

        foreach ($products as $product){

            //$product -> kategoriya = ucfirst(trim($product -> kategoriya));

            $sex = 'Унисекс';
            if(($product -> kategoriya == 'Мужская') || ($product -> kategoriya == 'мужская'))
                $sex = 'Мужской';
            if(($product -> kategoriya == 'Женская') || ($product -> kategoriya == 'женская'))
                $sex = 'Женский';
            if(($product -> kategoriya == 'Детская') || ($product -> kategoriya == 'детская') || ($product -> kategoriya == 'Перчатки') || ($product -> kategoriya == 'перчатки')) {
                //$product -> pol = ucfirst(trim($product -> pol));
                $sex = $product->pol;
            }


            if(isset($sizes[$product -> razmer]))
                $size = $sizes[$product -> razmer];
            else{
                $sizes = array_merge($sizes, $this ->addSize($product -> razmer));
                $size = $sizes[$product -> razmer];
            }

            if(isset($manufacturers[str_replace($product ->{'brend'}[0], strtoupper($product ->{'brend'}[0]), $product ->{'brend'})]))
                $manufacturer = $manufacturers[str_replace($product ->{'brend'}[0], strtoupper($product ->{'brend'}[0]), $product ->{'brend'})];
            else{
                $manufacturers = array_merge($manufacturers, $this ->addManufacturer($product ->{'brend'}));
                $manufacturer = $manufacturers[str_replace($product ->{'brend'}[0], strtoupper($product ->{'brend'}[0]), $product ->{'brend'})];
            }


            if ($product ->{'tip_obuvi'}[0] && isset($types[str_replace($product ->{'tip_obuvi'}[0], strtoupper($product ->{'tip_obuvi'}[0]), $product ->{'tip_obuvi'})]))
                $type = $types[str_replace($product ->{'tip_obuvi'}[0], strtoupper($product ->{'tip_obuvi'}[0]), $product ->{'tip_obuvi'})];
            else if ($product ->{'tip_obuvi'}[0]){
                $types = array_merge($types, $this ->addType($product ->{'tip_obuvi'}));
                $type = $types[str_replace($product ->{'tip_obuvi'}[0], strtoupper($product ->{'tip_obuvi'}[0]), $product ->{'tip_obuvi'})];
            } else {
                if ($product ->{'tip'}[0] && isset($types[str_replace($product ->{'tip'}[0], strtoupper($product ->{'tip'}[0]), $product ->{'tip'})]))
                $type = $types[str_replace($product ->{'tip'}[0], strtoupper($product ->{'tip'}[0]), $product ->{'tip'})];
                else if ($product ->{'tip'}[0]){
                    $types = array_merge($types, $this ->addType($product ->{'tip'}));
                    $type = $types[str_replace($product ->{'tip'}[0], strtoupper($product ->{'tip'}[0]), $product ->{'tip'})];
                }
            }

            if(isset($seasons[str_replace($product ->{'sezon'}[0], strtoupper($product ->{'sezon'}[0]), $product ->{'sezon'})]))
                $season = $seasons[str_replace($product ->{'sezon'}[0], strtoupper($product ->{'sezon'}[0]), $product ->{'sezon'})];
            else{
                $seasons = array_merge($seasons, $this ->addSeason($product ->{'sezon'}));
                $season = $seasons[str_replace($product ->{'sezon'}[0], strtoupper($product ->{'sezon'}[0]), $product ->{'sezon'})];
            }



            $priseWithDiscount = $product ->tsena_prodazhi;

            $manufacturersInfoToProduct = $manufacturersInfo ->find($manufacturers[str_replace($product ->{'brend'}[0], strtoupper($product ->{'brend'}[0]), $product ->{'brend'})]);

            if($manufacturersInfoToProduct ->koorse != "" && $manufacturersInfoToProduct ->koorse != 0 && $product->valyuta == "дол"){

                $priseWithDiscount *= $manufacturersInfoToProduct ->koorse;

            }

            if($manufacturersInfoToProduct ->discount !="" && $manufacturersInfoToProduct ->discount != 0) {


                $hrivna_discount = explode("грн",$manufacturersInfoToProduct ->discount);

                if(isset($hrivna_discount[1])){

                    $priseWithDiscount = $priseWithDiscount - $hrivna_discount[0];
                }

                $prozent_discount = explode("%",$manufacturersInfoToProduct ->discount);

                if(isset($prozent_discount[1])){

                    $priseWithDiscount = $priseWithDiscount - ( $priseWithDiscount * ($prozent_discount[0]/100) );
                }

            }

            if($product ->skidka !="" && $product ->skidka != 0) {


                $hrivna_discount = explode("грн",$product ->skidka);

                if(isset($hrivna_discount[1])){
                    $priseWithDiscount = $priseWithDiscount - $hrivna_discount[0];
                }

                $prozent_discount = explode("%",$product ->skidka);

                if(isset($prozent_discount[1])){
                    $priseWithDiscount = $priseWithDiscount - ( $priseWithDiscount * ($prozent_discount[0]/100) );
                }

            }

            switch ($product ->kategoriya){

                case "Детская":
                    $categoryId = 1;
                    break;
                case "Мужская":
                    $categoryId = 2;
                    break;
                case "Женская":
                    $categoryId = 3;
                    break;
                default :
                    $categoryId = 4;

            }

            $priseWithDiscount = round($priseWithDiscount, 2);
            $insert_array = [];
            if ( $categoryId == 4 ) {
                $insert_array = ['article' => $product->artikul,
                    'name' => $product ->artikul.' '.$product ->{'brend'},
                    'rostovka_count' => $product->kol_v_upakovke,
                    'box_count' => $product ->kol_v_palete,
                    'prise_default' => (float)$product->tsena_prodazhi,
                    'prise' => (float)$priseWithDiscount,
                    'manufacturer_id' => $manufacturer,
                    'category_id' => $categoryId,
                    'show_product' => $product->nalichie,
                    'currency' => $product->valyuta,
                    'full_description' => $product->opisanie,
                    'discount' => $product->skidka,
                    'accessibility' => $product->nalichie,
                    'type_id' => $type,
                    'season_id' => $season,
                    'size_id' => $size,
                    "prise_zakup" => (float)$product->tsena_zakupki,
                    'sex' => $sex,
                    'material' => $product->material_verkh,
                    'color' => $product->tsvet,
                    'manufacturer_country' => $product->strana_proizvoditel,
                    'material_inside' => $product->material_vnutri,
                    'material_insoles' => $product->material_stelki,
                    'repeats' => $product->povtory,
                ];
            } else {
                $insert_array = ['article' => $product->artikul,
                    'name' => $product->artikul . ' ' . str_replace($product->{'brend'}[0], strtoupper($product->{'brend'}[0]), $product->{'brend'}),     ///////////////////////////// уточнить
                    'rostovka_count' => $product->{"min._kol"},
                    'box_count' => $product->kol_v_yashchike,
                    'prise_default' => (float)$product->tsena_prodazhi,
                    'prise' => (float)$priseWithDiscount,
                    'manufacturer_id' => $manufacturer,
                    'category_id' => $categoryId,
                    'show_product' => $product->nalichie,
                    'currency' => $product->valyuta,
                    'full_description' => $product->opisanie,
                    'discount' => $product->skidka,
                    'accessibility' => $product->nalichie,
                    'type_id' => $type,
                    'season_id' => $season,
                    'size_id' => $size,
                    "prise_zakup" => (float)$product->tsena_zakupki,
                    'sex' => $sex,
                    'material' => $product->material_verkh,
                    'color' => $product->tsvet,
                    'manufacturer_country' => $product->strana_proizvoditel,
                    'material_inside' => $product->material_vnutri,
                    'material_insoles' => $product->material_stelki,
                    'repeats' => $product->povtory,
                ];
            }

            $productFind = Product::find($product->id);
            if($productFind)
                $productFind->update($insert_array);

        }

    }



    public function csvShoesLoad(CsvPostRequest $request){

        $path = $request->file('files')->getRealPath();

        $products = Excel::load($path, function($reader) {
        })->get();

        $products = $this ->checkEmpty($products);

        if($this ->checkDooble($products))

            return response('Check file, program find doodles', 404);

        else {

            $inputTovars = $this->formInsertArray($products, $request -> spec_show);

            Product::insert($inputTovars[0]);

            // dd('russik');

            //dd($this->formPhotoInsertArray($request, $products));

            ProductPhotos::insert($this->formPhotoInsertArray($request, $products));

            ProductNovelty::insert($this->formNovInsertArray($products));

            $this->photosRename($products);

            return response(['all date was upload', $inputTovars[1]], 200);
        }

    }

    public function reloadCsvShoesLoad(CsvPostRequest $request){
    	$prods = Product::where('accessibility', 1)->get();
    	$prodIds = [];

    	foreach ($prods as $key => $prod) {
    		$photo = ProductPhotos::where('product_id', $prod->id)->first();
    		if($photo && !file_exists('images/products/' . $photo -> photo_url))
    			$prodIds[] = $prod->id;
    		else if (!$photo) $prodIds[] = $prod->id;
    	}

    	$products = Product::whereIn('id', $prodIds)->get();
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
    }

    protected function photosRename($products){

        $products_mass = [];

        foreach ($products as $product){

            $products_mass[$product ->artikul.' '.str_replace($product ->{'brend'}[0], strtoupper($product ->{'brend'}[0]), $product ->{'brend'})] = [[$product -> foto1,$product -> foto2,$product -> foto3]];

        }

        $data_base_products = Product::whereIn('name', array_keys($products_mass)) -> pluck('id', 'name') ->toArray();



        foreach ($products_mass as $key => $photo_to_product_value){

            foreach ($photo_to_product_value[0] as $item){



                if (isset($data_base_products[$key]) && $item) {

                    if (is_numeric($item)) {
                        if ($item && file_exists('../images/products/' . (integer)$item . '.jpg')) {
                            File::move('../images/products/' . (integer)$item . '.jpg', 'images/products/' . $data_base_products[$key] . "_" . $item . '.jpg');
                            $img = Image::make(public_path('images/products/' . $data_base_products[$key] . "_" . $item . '.jpg'));
                            $img->insert(public_path('images/марка.png'), 'center');
                            $img->save(public_path('images/products/' . $data_base_products[$key] . "_" . $item . '.jpg'));
                        }
                    } else {
                        if ($item && file_exists('../images/products/' . $item . '.jpg')) {
                            File::move('../images/products/' . $item . '.jpg', 'images/products/' . $data_base_products[$key] . "_" . $item . '.jpg');
                            $img = Image::make(public_path('images/products/' . $data_base_products[$key] . "_" . $item . '.jpg'));
                            $img->insert(public_path('images/марка.png'), 'center');
                            $img->save(public_path('images/products/' . $data_base_products[$key] . "_" . $item . '.jpg'));
                            //$objDrawing->setPath(public_path('images/viber_image.jpg')); //your image path
                        }
                    }
                }

            }
        }

    }

    protected function formPhotoInsertArray($photos, $products){

        $zip = new ZipArchive;
        $zip->open($photos -> photo -> getRealPath());
        $zip->extractTo('../images/products/');
        $zip->close();

        $products_mass = [];

        foreach ($products as $product){

            $products_mass[$product ->artikul.' '.str_replace($product ->{'brend'}[0], strtoupper($product ->{'brend'}[0]), $product ->{'brend'})] = [[$product -> foto1,$product -> foto2,$product -> foto3]];

        }

        $data_base_products = Product::whereIn('name', array_keys($products_mass)) -> pluck('id', 'name') ->toArray();

        $photos_to_products_insert_array = [];

        foreach ($products_mass as $key => $photo_to_product_value){

            foreach ($photo_to_product_value[0] as $item) {
                if (isset($data_base_products[$key])) {
                    if ($item) {
                        $photos_to_products_insert_array[] = ['photo_url' => $data_base_products[$key] . "_" . $item . '.jpg',
                            'product_id' => $data_base_products[$key]];
                    }
                }
            }
        }

       return $photos_to_products_insert_array;

    }

    protected function formNovInsertArray($products){

        $novId = ProductNovelty::latest('id')->first();
        $novId = ($novId)? $novId -> nov_id + 1: 1;
        $products_mass = [];

        foreach ($products as $product){

            $products_mass[$product ->artikul.' '.str_replace($product ->{'brend'}[0], strtoupper($product ->{'brend'}[0]), $product ->{'brend'})] = [[$product -> foto1,$product -> foto2,$product -> foto3]];

        }

        $data_base_products = Product::whereIn('name', array_keys($products_mass)) -> get();

        $nov_to_products_insert_array = [];

        foreach ($data_base_products as $nov){

            array_push($nov_to_products_insert_array, ['nov_id' => $novId, 'product_id' => $nov -> id, 'created_at' => Carbon::now()]);

        }

       return $nov_to_products_insert_array;

    }

    protected function checkEmpty($products){

        $exel_array_flag = 0;
        foreach ($products as $product){

            if($product -> artikul == null) {

                $products->forget($exel_array_flag);
            }

            $exel_array_flag++;

        }

        return $products;

    }



    protected function formInsertArray($products, $spec = false){
        //dd($products);

        $types = Type::all() -> pluck('id', 'name') -> toArray();
        $seasons = Season::all() -> pluck('id', 'name') -> toArray();
        $sizes = Size::all()  -> pluck('id', 'name') -> toArray();
        //$categories = Category::all() -> pluck('id', 'name') -> toArray();
        $manufacturers = Manufacturer::all() -> pluck('id', 'name') -> toArray();
        $manufacturersInfo = Manufacturer::all();
        $insert_array = [];
        $russik_dump = 2;
        $delete_array = [];

        $checkProductInDb = [];
        $checkProductInDb[0] = 'Товары, которые уже есть в базе';

        foreach ($products as $product){

            //$product -> kategoriya = ucfirst(trim($product -> kategoriya));

            $sex = 'Унисекс';
            if(($product -> kategoriya == 'Мужская') || ($product -> kategoriya == 'мужская'))
                $sex = 'Мужской';
            if(($product -> kategoriya == 'Женская') || ($product -> kategoriya == 'женская'))
                $sex = 'Женский';
            if(($product -> kategoriya == 'Детская') || ($product -> kategoriya == 'детская') || ($product -> kategoriya == 'Перчатки') || ($product -> kategoriya == 'перчатки')) {
                //$product -> pol = ucfirst(trim($product -> pol));
                $sex = $product->pol;
            }

            if(isset($sizes[$product -> razmer]))
                $size = $sizes[$product -> razmer];
            else{
                $sizes = array_merge($sizes, $this ->addSize($product -> razmer));
                $size = $sizes[$product -> razmer];
            }


            if(isset($manufacturers[str_replace($product ->{'brend'}[0], strtoupper($product ->{'brend'}[0]), $product ->{'brend'})]))
                $manufacturer = $manufacturers[str_replace($product ->{'brend'}[0], strtoupper($product ->{'brend'}[0]), $product ->{'brend'})];
            else{
                $manufacturers = array_merge($manufacturers, $this ->addManufacturer($product ->{'brend'}, $spec));
                $manufacturer = $manufacturers[str_replace($product ->{'brend'}[0], strtoupper($product ->{'brend'}[0]), $product ->{'brend'})];
            }



            //dd(mb_convert_encoding($product ->{'tip_obuvi'}[0], "CP1252", "UTF-8"));
            //dd($product ->{'tip_obuvi'}, str_split($product ->{'tip_obuvi'}), mb_detect_encoding($product ->{'tip_obuvi'}[0]), iconv_get_encoding($product ->{'tip_obuvi'}));

            if ($product ->{'tip_obuvi'}[0] && isset($types[str_replace($product ->{'tip_obuvi'}[0], strtoupper($product ->{'tip_obuvi'}[0]), $product ->{'tip_obuvi'})]))
                $type = $types[str_replace($product ->{'tip_obuvi'}[0], strtoupper($product ->{'tip_obuvi'}[0]), $product ->{'tip_obuvi'})];
            else if ($product ->{'tip_obuvi'}[0]){
                $types = array_merge($types, $this ->addType($product ->{'tip_obuvi'}));
                $type = $types[str_replace($product ->{'tip_obuvi'}[0], strtoupper($product ->{'tip_obuvi'}[0]), $product ->{'tip_obuvi'})];
            } else {
                if ($product ->{'tip'}[0] && isset($types[str_replace($product ->{'tip'}[0], strtoupper($product ->{'tip'}[0]), $product ->{'tip'})]))
                $type = $types[str_replace($product ->{'tip'}[0], strtoupper($product ->{'tip'}[0]), $product ->{'tip'})];
                else if ($product ->{'tip'}[0]){
                    $types = array_merge($types, $this ->addType($product ->{'tip'}));
                    $type = $types[str_replace($product ->{'tip'}[0], strtoupper($product ->{'tip'}[0]), $product ->{'tip'})];
                }
            }

            if(isset($seasons[str_replace($product ->{'sezon'}[0], strtoupper($product ->{'sezon'}[0]), $product ->{'sezon'})]))
                $season = $seasons[str_replace($product ->{'sezon'}[0], strtoupper($product ->{'sezon'}[0]), $product ->{'sezon'})];
            else{
                $seasons = array_merge($seasons, $this ->addSeason($product ->{'sezon'}));
                $season = $seasons[str_replace($product ->{'sezon'}[0], strtoupper($product ->{'sezon'}[0]), $product ->{'sezon'})];
            }



            $priseWithDiscount = $product ->tsena_prodazhi;

            $manufacturersInfoToProduct = $manufacturersInfo ->find($manufacturers[str_replace($product ->{'brend'}[0], strtoupper($product ->{'brend'}[0]), $product ->{'brend'})]);

            //dd($manufacturersInfoToProduct, $product->valyuta);

            if($manufacturersInfoToProduct ->koorse != "" && $manufacturersInfoToProduct ->koorse != 0 && $product->valyuta == "дол"){

                $priseWithDiscount *= $manufacturersInfoToProduct ->koorse;



            }

            if($manufacturersInfoToProduct ->discount !="" && $manufacturersInfoToProduct ->discount != 0) {


                $hrivna_discount = explode("грн",$manufacturersInfoToProduct ->discount);

                if(isset($hrivna_discount[1])){

                    $priseWithDiscount = $priseWithDiscount - $hrivna_discount[0];
                }

                $prozent_discount = explode("%",$manufacturersInfoToProduct ->discount);

                if(isset($prozent_discount[1])){

                    $priseWithDiscount = $priseWithDiscount - ( $priseWithDiscount * ($prozent_discount[0]/100) );
                }

            }

            if($product ->skidka !="" && $product ->skidka != 0) {


                $hrivna_discount = explode("грн",$product ->skidka);

                if(isset($hrivna_discount[1])){

                    $priseWithDiscount = $priseWithDiscount - $hrivna_discount[0];
                }

                $prozent_discount = explode("%",$product ->skidka);



                if(isset($prozent_discount[1])){

                    $priseWithDiscount = $priseWithDiscount - ( $priseWithDiscount * ($prozent_discount[0]/100) ) ;
                }

            }


            switch ($product ->kategoriya){

                case "Детская":
                    $categoryId = 1;
                    break;
                case "Мужская":
                    $categoryId = 2;
                    break;
                case "Женская":
                    $categoryId = 3;
                    break;
                default :
                    $categoryId = 4;

            }

            $priseWithDiscount = round($priseWithDiscount, 2);

            $delete_array[] = $product ->artikul.' '.str_replace($product ->{'brend'}[0], strtoupper($product ->{'brend'}[0]), $product ->{'brend'});
//            if(Product::where('manufacturer_id',$manufacturer)
//                -> where('name', $product ->artikul.' '.str_replace($product ->{'brend'}[0], strtoupper($product ->{'brend'}[0]), $product ->{'brend'}))
//                ->get()->toArray()) {
//                $checkProductInDb[] = $russik_dump;
//                   }

                if ( $categoryId == 4 ) {
                    $insert_array[] = ['article' => $product->artikul,
                        'name' => $product ->artikul.' '.$product ->{'brend'},
                        'rostovka_count' => $product->kol_v_upakovke,
                        'box_count' => $product ->kol_v_palete,
                        'prise_default' => (float)$product->tsena_prodazhi,
                        'prise' => (float)$priseWithDiscount,
                        'manufacturer_id' => $manufacturer,
                        'category_id' => $categoryId,
                        'show_product' => $product->nalichie,
                        'currency' => $product->valyuta,
                        'full_description' => $product->opisanie,
                        'discount' => $product->skidka,
                        'accessibility' => $product->nalichie,
                        'type_id' => $type,
                        'season_id' => $season,
                        'size_id' => $size,
                        "prise_zakup" => (float)$product->tsena_zakupki,
                        'sex' => $sex,
                        'material' => $product->material_verkh,
                        'color' => $product->tsvet,
                        'manufacturer_country' => $product->strana_proizvoditel,
                        'material_inside' => $product->material_vnutri,
                        'material_insoles' => $product->material_stelki,
                        'repeats' => $product->povtory,
                    ];
                } else {
                    $insert_array[] = ['article' => $product->artikul,
                        'name' => $product->artikul . ' ' . str_replace($product->{'brend'}[0], strtoupper($product->{'brend'}[0]), $product->{'brend'}),     ///////////////////////////// уточнить
                        'rostovka_count' => $product->{"min._kol"},
                        'box_count' => $product->kol_v_yashchike,
                        'prise_default' => (float)$product->tsena_prodazhi,
                        'prise' => (float)$priseWithDiscount,
                        'manufacturer_id' => $manufacturer,
                        'category_id' => $categoryId,
                        'show_product' => $product->nalichie,
                        'currency' => $product->valyuta,
                        'full_description' => $product->opisanie,
                        'discount' => $product->skidka,
                        'accessibility' => $product->nalichie,
                        'type_id' => $type,
                        'season_id' => $season,
                        'size_id' => $size,
                        "prise_zakup" => (float)$product->tsena_zakupki,
                        'sex' => $sex,
                        'material' => $product->material_verkh,
                        'color' => $product->tsvet,
                        'manufacturer_country' => $product->strana_proizvoditel,
                        'material_inside' => $product->material_vnutri,
                        'material_insoles' => $product->material_stelki,
                        'repeats' => $product->povtory,
                    ];
                }

            $russik_dump ++;
        }



       Product::whereIn('name',$delete_array)->delete();

        return [$insert_array, $checkProductInDb];

    }

    protected function addSize($min){

        $size = new Size();

        $size ->name = $min;

        $size_norm = explode('-', $min);

        $size ->min = $size_norm[0];

        $size ->max = $size_norm[1];

        $size -> save();

        return [$min => $size -> id];

    }

    protected function addManufacturer($brend, $spec = false){

        $manufacturer = new Manufacturer();

        $manufacturer -> name =str_replace($brend[0], strtoupper($brend[0]), $brend);

        if ($spec == 'true') $manufacturer -> show_all = 0;
        $manufacturer -> save();

        return [$brend => $manufacturer -> id];

    }

    protected function addType($tip){

        $type = new Type();

        $type -> name = str_replace($tip[0], strtoupper($tip[0]), $tip);

        $type -> save();

        return [$tip => $type -> id];

    }

    protected function addSeason($sezon){

        $season = new Season();

        $season -> name = str_replace($sezon[0], strtoupper($sezon[0]), $sezon);

        $season -> save();

        return [$sezon => $season -> id];



    }


}
