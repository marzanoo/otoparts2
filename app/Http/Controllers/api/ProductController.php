<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Method untuk menampilkan daftar produk
    public function index()
    {
        $products = Product::with('brands:id_merek,nama_merek')->get();
        return new ProductResource(true, 'List Data Barang', $products);
    }

    public function store(Request $request)
    {        
        $request->validate([
            'id_merek' => 'required|exists:brands,id_merek',  // Pastikan id_merek ada di tabel brands
            'nama_barang' => 'required|string',
            'jenis_barang' => 'required|string',
            'lokasi_rak' => 'required|string',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);
        $product = new Product;
        $product->id_merek = $request->id_merek;
        $product->nama_barang = $request->nama_barang;
        $product->jenis_barang = $request->jenis_barang;
        $product->lokasi_rak = $request->lokasi_rak;
        $product->harga_beli = $request->harga_beli;
        $product->harga_jual = $request->harga_jual;
        $product->stok = $request->stok;
        $data = $product->save();
        if($data != false)
        {
            $response = [
                'error' => false,
                'success' => 1,
                'message' => 'Data Berhasil Disimpan',
            ];
        } else {
            $response = [
                'error' => true,
                'success' => 0,
                'message' => 'Data Gagal Disimpan',
            ];
        }
        return response()->json($response);
    }

    public function cari(Request $request)
    {
        $product = Product::where('nama_barang', 'like', '%'.$request->cari.'%')->get();

        return new ProductResource(true, 'List Data Merek', $product);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_merek' => 'required|exists:brands,id_merek', // Pastikan id_merek ada di tabel brands
            'nama_barang' => 'required|string',
            'jenis_barang' => 'required|string',
            'lokasi_rak' => 'required|string',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'error' => true,
                'success' => 0,
                'message' => 'Produk tidak ditemukan',
            ], 404);
        }

        $product->id_merek = $request->id_merek;
        $product->nama_barang = $request->nama_barang;
        $product->jenis_barang = $request->jenis_barang;
        $product->lokasi_rak = $request->lokasi_rak;
        $product->harga_beli = $request->harga_beli;
        $product->harga_jual = $request->harga_jual;
        $product->stok = $request->stok;

        if ($product->save()) {
            return response()->json([
                'error' => false,
                'success' => 1,
                'message' => 'Data berhasil diupdate',
            ]);
        } else {
            return response()->json([
                'error' => true,
                'success' => 0,
                'message' => 'Data gagal diupdate',
            ]);
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'error' => true,
                'success' => 0,
                'message' => 'Produk tidak ditemukan',
            ], 404);
        }

        if ($product->delete()) {
            return response()->json([
                'error' => false,
                'success' => 1,
                'message' => 'Data berhasil dihapus',
            ]);
        } else {
            return response()->json([
                'error' => true,
                'success' => 0,
                'message' => 'Data gagal dihapus',
            ]);
        }
    }

}
