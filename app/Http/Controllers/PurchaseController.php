<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
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
    public function delete(Request $request, $id) {
        $purchaseDetails = PurchaseDetail::where('id_pembelian', $id)->get();
        foreach ($purchaseDetails as $purchaseDetail) {
            $product = Product::find($purchaseDetail->id_barang);
            
            if ($product) {
                $product->stok -= $purchaseDetail->jumlah; // Kurangi stok barang berdasarkan jumlah pembelian
                $product->save();
            }
        }
        $purchase = Purchase::find($id);
        if ($purchase) {
            $purchase->delete();
        }

        return redirect('pembelian');
    }

    public function edit(Request $request, $id) {
        $purchase = Purchase::find($id);
        $purchase->update([
            'tanggal' => $request->tanggal,
            'total' => $request->total,
            'id_distributor' => $request->distributor
        ]); 

        return redirect('pembelian');
    }
}