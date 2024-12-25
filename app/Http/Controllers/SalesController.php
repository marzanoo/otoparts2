<?php

namespace App\Http\Controllers;

use App\Models\Details;
use App\Models\Product;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function index()
    {
        if (Auth::user()->role != 1 && Auth::user()->role != 3){
            return redirect('dashboard');
        }
        
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

    public function delete(Request $request, $id) {
        $details = Details::where('id_penjualan', $id)->get();
        foreach ($details as $row) {
            $product = Product::find($row->id_barang);
            
            if ($product) {
                $product->stok += $row->jumlah;
                $product->save();
            }
        }
        $sales = Sales::find($id);
        if ($sales) {
            $sales->delete();
        }

        return redirect('penjualan');
    }

    public function edit(Request $request, $id) {
        $sales = Sales::find($id);
        $sales->update([
            'tanggal' => $request->tanggal,
            'total' => $request->total,
            'id_user' => $request->kasir
        ]); 

        return redirect('penjualan');
    }
}
