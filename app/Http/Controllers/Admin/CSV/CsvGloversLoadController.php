<?php

namespace App\Http\Controllers\Admin\CSV;

use App\GloverHelper;
use App\Http\Requests\CsvPostRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Manufacturer;
use App\Product;
use App\ProductPhotos;
use App\Season;
use App\Size;
use App\Type;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;
use Illuminate\Support\Facades\File;

class CsvGloversLoadController extends Controller
{
    public function index(){

        return view('csv_glovers_load');

    }

    public function edit(){

        return view('csv_glovers_edit');

    }

    public function csvGloversDelete(CsvPostRequest $request){

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

        foreach ($photos as $photo){

            File::delete('../images/products/' . $photo);

        }

    }

    public function csvGloversUpdate(CsvPostRequest $request){

        $path = $request->file('files')->getRealPath();

        $products = Excel::load($path, function($reader) {
        })->get();

        $products = $this ->checkEmpty($products);

        $this->productsUpdate($products);

        if($request -> photo) {

            $this->productsPhotoUpdate($request, $products);

            $this->photosRename($products);
        }


    }

    public function productsPhotoUpdate($photos, $products){

        $zip = new ZipArchive;
        $zip->open($photos -> photo -> getRealPath());
        $zip->extractTo('images/products/');
        $zip->close();

        $products_mass = [];

        foreach ($products as $product){

            $products_mass[$product ->artikul.' '.$product ->{'brend'}] = [[$product -> foto1,$product -> foto2,$product -> foto3]];

        }

        $data_base_products = Product::whereIn('name', array_keys($products_mass)) -> pluck('id', 'name') ->toArray();

        foreach ($products_mass as $key => $photo_to_product_value){

            foreach ($photo_to_product_value[0] as $item){
                if($item){
                    ProductPhotos::where('product_id', '=',$data_base_products[$key])
                        ->update(['photo_url' => $data_base_products[$key]."_". $item.'.jpg']);
                }
            }
        }

    }

    protected function productsUpdate($products){

        $types = Type::all() -> pluck('id', 'name') -> toArray();
        $seasons = Season::all() -> pluck('id', 'name') -> toArray();
        $sizes = Size::all()  -> pluck('id', 'name') -> toArray();
        $categories = Category::all() -> pluck('id', 'name') -> toArray();
        $manufacturers = Manufacturer::all() -> pluck('id', 'name') -> toArray();

        foreach ($products as $product){

            if(isset($sizes[$product -> razmer]))
                $size = $sizes[$product -> razmer];
            else{
                $sizes = array_merge($sizes, $this ->addSize($product -> razmer));
                $size = $sizes[$product -> razmer];
            }

            if(isset($manufacturers[$product ->{'brend'}]))
                $manufacturer = $manufacturers[$product ->{'brend'}];
            else{
                $manufacturers = array_merge($manufacturers, $this ->addManufacturer($product ->{'brend'}));
                $manufacturer = $manufacturers[$product ->{'brend'}];
            }

            if($product ->nalichie == 'Есть')
                $show = 1;
            else
                $show = 0;

            if (isset($types['перчатки']))
                $type = $types['перчатки'];
            else{
                $types = array_merge($types, $this ->addType('перчатки'));
                $type = $types['перчатки'];
            }

            if(isset($seasons[$product ->{'sezon'}]))
                $season = $seasons[$product ->{'sezon'}];
            else{
                $seasons = array_merge($seasons, $this ->addSeason($product ->{'sezon'}));
                $season = $seasons[$product ->{'sezon'}];
            }



            if($product -> valyuta == "$")
                $valyuta = "дол";
            else $valyuta = "грн";

            $insert_array = [ 'article' => $product ->artikul,
                'name' => $product ->artikul.' '.$product ->{'brend'},     ///////////////////////////// уточнить
                'rostovka_count' => $product ->{"min._kol"},
                'box_count' => $product ->kol_v_palete,
                'prise' => $product ->tsena_prodazhi,
                'manufacturer_id' => $manufacturer,
                'category_id' => $categories["Перчатки"],
                'show_product' => $show,
                'currency' =>  $valyuta,
                'full_description' => null,
                'discount' => ($product ->skidka)? $product ->skidka."%": null,
                'accessibility' => $show,
                'type_id' => $type,
                'season_id' => $season,
                'size_id' => $size,
                'sex' => $product -> pol,
                'material' => $product ->{'material'},
                'tip_vyazki' => $product ->{'tip_vyazki'}
            ];
            Product::find($product->id)->update($insert_array);
        }

    }



    public function csvGloversLoad(CsvPostRequest $request){

        $path = $request->file('files')->getRealPath();

        $products = Excel::load($path, function($reader) {
        })->get();

        $products = $this ->checkEmpty($products);

        if($this ->checkDooble($products))
            return 'Check file, program find doodles';
        else {

            Product::insert($this->formInsertArray($products));

            ProductPhotos::insert($this->formPhotoInsertArray($request, $products));

            $this->photosRename($products);

            return 'all date was upload';
        }

    }

    public function checkDooble($products){

        $check_array = [];

        foreach ($products as $product){

            $check_array[] = [$product -> artikul, $product -> brend];

        }

        for($i = 0; $i < count($check_array); $i ++){

            for($j = 0; $j < count($check_array); $j ++){

                if($i != $j && $check_array[$i][0] == $check_array[$j][0] && $check_array[$i][1] == $check_array[$j][1]){

                    return true;

                }

            }

        }

        return false;

    }

    protected function photosRename($products){

        $products_mass = [];

        foreach ($products as $product){

            $products_mass[$product ->artikul.' '.$product ->{'brend'}] = [[$product -> foto1,$product -> foto2,$product -> foto3]];

        }

        $data_base_products = Product::whereIn('name', array_keys($products_mass)) -> pluck('id', 'name') ->toArray();

        foreach ($products_mass as $key => $photo_to_product_value){

            foreach ($photo_to_product_value[0] as $item){
                if($item)
                    File::move('images/products/' . $item.'.jpg', '../images/products/' . $data_base_products[$key]."_". $item.'.jpg');

            }
        }

    }

    protected function formPhotoInsertArray($photos, $products){

        $zip = new ZipArchive;
        $zip->open($photos -> photo -> getRealPath());
        $zip->extractTo('images/products/');
        $zip->close();

        $products_mass = [];

        foreach ($products as $product){

            $products_mass[$product ->artikul.' '.$product ->{'brend'}] = [[$product -> foto1,$product -> foto2,$product -> foto3]];

        }

        $data_base_products = Product::whereIn('name', array_keys($products_mass)) -> pluck('id', 'name') ->toArray();

        $photos_to_products_insert_array = [];

        foreach ($products_mass as $key => $photo_to_product_value){

            foreach ($photo_to_product_value[0] as $item){
                if($item)
                    $photos_to_products_insert_array[] = ['photo_url' => $data_base_products[$key]."_". $item.'.jpg',
                        'product_id' => $data_base_products[$key]];

            }
        }

        return $photos_to_products_insert_array;

    }

    protected function formInsertArray($products){

        $types = Type::all() -> pluck('id', 'name') -> toArray();
        $seasons = Season::all() -> pluck('id', 'name') -> toArray();
        $sizes = Size::all()  -> pluck('id', 'name') -> toArray();
        $categories = Category::all() -> pluck('id', 'name') -> toArray();
        $manufacturers = Manufacturer::all() -> pluck('id', 'name') -> toArray();
        $insert_array = [];

        foreach ($products as $product){
            if(isset($sizes[$product -> razmer]))
                $size = $sizes[$product -> razmer];
            else{
                $sizes = array_merge($sizes, $this ->addSize($product -> razmer));
                $size = $sizes[$product -> razmer];
            }

            if(isset($manufacturers[$product ->{'brend'}]))
                $manufacturer = $manufacturers[$product ->{'brend'}];
            else{
                $manufacturers = array_merge($manufacturers, $this ->addManufacturer($product ->{'brend'}));
                $manufacturer = $manufacturers[$product ->{'brend'}];
            }

            if($product ->nalichie == 1)
                $show = 1;
            else
                $show = 0;

            if (isset($types['перчатки']))
                $type = $types['перчатки'];
            else{
                $types = array_merge($types, $this ->addType('перчатки'));
                $type = $types['перчатки'];
            }

            if(isset($seasons[$product ->{'sezon'}]))
                $season = $seasons[$product ->{'sezon'}];
            else{
                $seasons = array_merge($seasons, $this ->addSeason($product ->{'sezon'}));
                $season = $seasons[$product ->{'sezon'}];
            }



            if($product -> valyuta == "$")
                $valyuta = "дол";
            else $valyuta = "грн";

            $insert_array[] = [ 'article' => $product ->artikul,
                'name' => $product ->artikul.' '.$product ->{'brend'},
                'rostovka_count' => $product -> kol_v_upakovke,
                'box_count' => $product ->kol_v_palete,
                'prise_zakup' => $product ->tsena_zakupki,
                'prise_default' => $product ->tsena_prodazhi,
                'prise' => $product ->tsena_prodazhi,
                'manufacturer_id' => $manufacturer,
                'category_id' => $categories["Перчатки"],
                'show_product' => $show,
                'currency' =>  $valyuta,
                'full_description' => null,
                'discount' => ($product ->skidka)? $product ->skidka."%": null,
                'accessibility' => $show,
                'type_id' => $type,
                'season_id' => $season,
                'size_id' => $size,
                'sex' => $product -> pol,
                'material' => $product ->{'material'},
                'tip_vyazki' => $product ->{'tip_vyazki'}
            ];
        }

        return $insert_array;

    }


    protected function addGloverHelper($help){

        $season = new GloverHelper();

        $season -> name = $help;

        $season -> save();

        return [$help => $season -> id];

    }

    protected function addSeason($sezon){

        $season = new Season();

        $season -> name = $sezon;

        $season -> save();

        return [$sezon => $season -> id];



    }

    protected function addType($tip){

        $type = new Type();

        $type -> name = $tip;

        $type -> save();

        return [$tip => $type -> id];

    }

    protected function addManufacturer($brend){

        $manufacturer = new Manufacturer();

        $manufacturer -> name = $brend;

        $manufacturer -> save();

        return [$brend => $manufacturer -> id];

    }

    protected function addSize($razmer){

        $size = new Size();

        $size ->name = $razmer;

        $size ->min = null;

        $size ->max = null;

        $size -> save();

        return [$razmer => $size -> id];

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
}
