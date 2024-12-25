<?php

namespace App\Http\Controllers;

use App\Models\Details;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function home()
    {
        $total_penjualan = DB::table('sales')->count(); // Hitung jumlah baris di tabel sales
        $total_pembelian = Purchase::count();
        $total_barang_keluar = Details::sum('jumlah');
        $total_barang_masuk = PurchaseDetail::sum('jumlah');
        return view('dashboard', compact('total_penjualan', 'total_pembelian', 'total_barang_keluar', 'total_barang_masuk')); // Kirim data ke view
    }
}
