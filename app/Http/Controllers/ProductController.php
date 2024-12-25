<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index() {
        if (Auth::user()->role != 1 && Auth::user()->role != 2){
            return redirect('dashboard');
        }
        $brands = Brand::all();
        $products = Product::with('brands')->get();
        return view('barang.product', compact('products', 'brands'));
    }

    public function add(Request $request) {
        Product::create([
            'id_merek' => $request->merek,
            'nama_barang' => $request->nama_barang,
            'jenis_barang' => $request->jenis_barang,
            'stok' => $request->stok,
            'lokasi_rak' => $request->lokasi_rak,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
        ]);
        return redirect('barang');
    }

    public function delete(Request $request, $id) {
        $product = Product::find($id);
        $product->delete();
        return redirect('barang');
    }

    public function edit(Request $request, $id) {
        $product = Product::find($id);
        $product->update([
            'id_merek' => $request->merek,
            'nama_barang' => $request->nama_barang,
            'jenis_barang' => $request->jenis_barang,
            'stok' => $request->stok,
            'lokasi_rak' => $request->lokasi_rak,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
        ]);
        return redirect('barang');
    }
}
