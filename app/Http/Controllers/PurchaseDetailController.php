<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Http\Request;

class PurchaseDetailController extends Controller
{
    public function index($id){

        $purchases = Purchase::findOrFail($id);
        $products = Product::all();
        $purchasedetails = PurchaseDetail::with('purchases', 'products')->where('id_pembelian', $id)->get();

        return view('details.detail-pembelian', compact('purchases', 'purchasedetails', 'products'));
    }

    public function add(Request $request) {

        PurchaseDetail::create([
            'id_pembelian' => $request->id_pembelian,
            'id_barang' => $request->barang,
            'jumlah' => $request->jumlah,
            'subtotal' => $request->subtotal
        ]);

        $purchases = Purchase::find($request->id_pembelian);
        if ($purchases) {
            $purchases->total += $request->subtotal;
            $purchases->save();
        }

        $products = Product::find($request->barang);
        if ($products) {
            $products->stok += $request->jumlah;
            $products->save();
        }

        return redirect()->back();
    }
}
