<?php

namespace App\Http\Controllers\Admin;

use App\Fool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class FoolController extends Controller
{
    public function index(){

    	$fools = Fool::all();

    	return view(' admin.fool.index ') -> with(["fools" => $fools]);

    }

    public function addFools(Request $request){

    	$address = $request -> fools -> getPathName();
    	Excel::load($address, function($reader) {
	        $results = $reader->get();

	        foreach ($results as $res) {
	        	if ($res -> nomer_telefona) {
		        	$fool = new Fool();
		        	$fool -> name = $res -> nomer_telefona;
		        	if ($res -> prichina) $fool -> reason = $res -> prichina;
		        	$fool -> save();
		        }

		        if ($res -> email) {
		        	$fool = new Fool();
		        	$fool -> name = $res -> email;
		        	if ($res -> prichina) $fool -> reason = $res -> prichina;
		        	$fool -> save();
		        }
	        }
	    });

    }

    public function add2Fools(Request $request){

    	if ($request -> name) {
	    	$fool = new Fool();
	    	$fool -> name = $request -> name;
	    	if ($request -> reason) $fool -> reason = $request -> reason;
	    	$fool -> save();
	    }

	    if ($request -> email) {
	    	$fool = new Fool();
	    	$fool -> name = $request -> email;
	    	if ($request -> reason) $fool -> reason = $request -> reason;
	    	$fool -> save();
	    }

    }

    public function delFools(Request $request) {
    	$fool = Fool::find($request -> id);
        if ($fool) $fool->delete();
    }
}
