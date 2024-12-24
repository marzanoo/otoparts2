<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index() {
        
        $distributors = Distributor::all();
        $purchases = Purchase::with('distributors')->get();        

        return view('pembelian.purchase', compact('purchases', 'distributors'));
    }

    public function add(Request $request) {
        $purchases = Purchase::create([
            'tanggal' => $request->tanggal,
            'total' => 0,
            'id_distributor' => $request->distributor
        ]);

        return redirect()->route('purchase-details', ['id' => $purchases->id_pembelian]);
    }
}