<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseDetailController extends Controller
{
    public function index($id){
        if (Auth::user()->role != 1){
            return redirect('dashboard');
        }
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
    public function delete(Request $request, $id_pembelian, $id_barang) {
        $subtotal = PurchaseDetail::where('id_pembelian', $id_pembelian)
                                  ->where('id_barang', $id_barang)
                                  ->value('subtotal');
        $jumlah = PurchaseDetail::where('id_pembelian', $id_pembelian)
                                  ->where('id_barang', $id_barang)
                                  ->value('jumlah');
        DB::table('purchase_details')
            ->where('id_pembelian', $id_pembelian)
            ->where('id_barang', $id_barang)
            ->delete();
        $purchase = Purchase::find($id_pembelian);
        if ($purchase) {
            $purchase->total -= $subtotal;
            $purchase->save();
        }
        $product = Product::find($id_barang);
        if ($product) {
            $product->stok -= $jumlah;
            $product->save();
        }
        return redirect()->back();
    }
    
}
