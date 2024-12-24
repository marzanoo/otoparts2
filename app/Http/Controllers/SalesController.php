<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        $users = User::all();
        $sales = Sales::with('users')->get();        

        return view('penjualan.sales', compact('sales', 'users'));
    }

    public function add(Request $request) {
        $sales = Sales::create([
            'tanggal' => $request->tanggal,
            'id_user' => $request->kasir
        ]);

        return redirect()->route('details', ['id' => $sales->id_penjualan]);
    }
}
