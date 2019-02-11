<?php

namespace App\Http\Controllers\Admin\PDF;

use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;

class ReceiptController extends Controller
{
    public function index($id){
        $order = Order::with('details') -> find($id);
        $pdf = PDF::loadView('admin.pdf.invoice', compact('order'));
        $pdf -> setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);

        //$pdf -> setPaper('a4', 'landscape');

        return $pdf->download('Заказ.pdf');

    }

    public function show(){

        $order = Order::with('details') -> find(96);

        return view('admin.pdf.invoice', compact('order'));

    }
}
