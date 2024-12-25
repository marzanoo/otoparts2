<?php

namespace App\Http\Controllers;

use App\Models\Details;
use App\Models\Product;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DetailsController extends Controller
{
    public function index($id){
        if (Auth::user()->role != 1 && Auth::user()->role != 3){
            return redirect('dashboard');
        }
        $sales = Sales::findOrFail($id);
        $products = Product::all();
        $details = Details::with('sales', 'products')->where('id_penjualan', $id)->get();

        return view('details.detail-penjualan', compact('sales', 'details', 'products'));
    }

    public function add(Request $request) {

        Details::create([
            'id_penjualan' => $request->id_penjualan,
            'id_barang' => $request->barang,
            'jumlah' => $request->jumlah,
            'subtotal' => $request->subtotal
        ]);

        $sales = Sales::find($request->id_penjualan);
        if ($sales) {
            $sales->total += $request->subtotal;
            $sales->save();
        }
        $products = Product::find($request->barang);
        if ($products) {
            $products->stok -= $request->jumlah;
            $products->save();
        }

        return redirect()->back();
    }
    
    public function update(Request $request, $id_penjualan, $id_barang) {
        $detail = Details::where('id_penjualan', $id_penjualan)
                        ->where('id_barang', $id_barang)
                        ->first();

        if ($detail) {
            $detail->jumlah = $request->jumlah;
            $detail->subtotal = $request->subtotal;
            $detail->save();

            return redirect()->back()->with('success', 'Detail penjualan berhasil diubah');
        }

        return redirect()->back()->with('error', 'Detail penjualan tidak ditemukan');
    }

    public function delete(Request $request, $id_penjualan, $id_barang) {
        $subtotal = Details::where('id_penjualan', $id_penjualan)
                                  ->where('id_barang', $id_barang)
                                  ->value('subtotal');
        $jumlah = Details::where('id_penjualan', $id_penjualan)
                                  ->where('id_barang', $id_barang)
                                  ->value('jumlah');
        DB::table('details')
            ->where('id_penjualan', $id_penjualan)
            ->where('id_barang', $id_barang)
            ->delete();
        $sales = Sales::find($id_penjualan);
        if ($sales) {
            $sales->total -= $subtotal;
            $sales->save();
        }
        $product = Product::find($id_barang);
        if ($product) {
            $product->stok += $jumlah;
            $product->save();
        }
        return redirect()->back();
    }


}
