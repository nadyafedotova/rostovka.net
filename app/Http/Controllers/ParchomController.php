<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParchomController extends Controller
{
    public function index(){

        return view('admin.parhom');

    }
}
