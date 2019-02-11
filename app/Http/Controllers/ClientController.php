<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index(){

        $client = Auth::user();

        return view('user.userinfo', compact('client'));

    }

    public function update(Request $request){

        $client = User::find(Auth::user()->id);

        $client -> fill($request -> all());

        if($request -> password)
            $client -> password = bcrypt($request -> password);

        $client -> save();

        return redirect() -> back();

    }
}
