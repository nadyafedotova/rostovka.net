<?php

namespace App\Http\Controllers;

use App\Category;
use App\Type;
use App\Product;
use App\User;
use App\Sitemap;
use App\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SitemapController extends Controller
{
    public function index(){

        $sitemap = new Sitemap("https://rostovka.net");
        $sitemap_types = new Sitemap("https://rostovka.net");

        $sitemap_types->addUrl("https://rostovka.net/",               date('c'),  'daily',    '1');

        $sitemap_types->addUrl("https://rostovka.net/about",          date('c'),  'daily',    '0.80');
        $sitemap_types->addUrl("https://rostovka.net/login",          date('c'),  'daily',    '0.80');
        $sitemap_types->addUrl("https://rostovka.net/register",       date('c'),  'daily',    '0.80');
        $sitemap_types->addUrl("https://rostovka.net/checkout",       date('c'),  'daily',    '0.80');

        $categories = Category::all();

        foreach ($categories as $category) {
            $sitemap_types->addUrl("https://rostovka.net/" . $category -> link, date('c'), 'daily', '0.80');

            $types = Type::whereIn('id', Product::where('category_id', $category -> id) -> where('show_product' , 1) -> distinct()
                -> groupBy('type_id')
                -> pluck('type_id'))
                -> get();

            foreach ($types as $type) {
                $sitemap_types->addUrl("https://rostovka.net/" . $category -> link . '/' . $type -> name, date('c'), 'daily', '0.80');
            }
        }

        $brands = Manufacturer::all();
        foreach ($brands as $brand) {
            $sitemap_types->addUrl("https://rostovka.net/brand/" . $brand -> name, date('c'), 'daily', '0.80');
        }

        //$lol = Product::where('accessibility', 1) ->get();
        //dd($lol);

        Product::where('accessibility', 1)
        ->chunk(1000, function ($products) use ($sitemap) {
            foreach ($products as $product) {
                $sitemap->addUrl("https://rostovka.net/" . $product -> category() -> first() -> link . '/' . rawurlencode($product -> name), date('c'), 'daily', '0.60');
            }
        });

        $sitemap_types->createTypesSitemap();
        $sitemap->createSitemap();

        $sitemap_types->writeSitemap();
        $sitemap->writeSitemap();

        return $sitemap;

    }
}
