<?php

namespace App\Http\Controllers\Admin;

use App\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class AboutController extends Controller
{
    public function index(){

    	$about = About::first();

    	return view(' admin.about.index ') -> with(["about" => $about]);

    }

    public function update(Request $request) {

    	$about = About::first();

    	$about -> tab1 = $request -> tab1;
    	$about -> tab2 = $request -> tab2;
    	$about -> tab3 = $request -> tab3;
    	$about -> tab4 = $request -> tab4;

    	$about -> save();

    	return view(' admin.about.index ') -> with(["about" => $about]);

    }

}
