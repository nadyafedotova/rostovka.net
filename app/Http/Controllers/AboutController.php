<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashRequest;
use App\Http\Requests\SaleRequest;
use App\About;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class AboutController extends Controller
{
    public function index() {

        $about = About::first();
        return view('user.aboutDB') -> with(['about' => $about]);

    }
}
