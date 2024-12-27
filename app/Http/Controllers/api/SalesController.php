<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SalesResource;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        $users = User::all();
        $sales = Sales::with('users:id,name')->get();
        return new SalesResource(true, 'List Data Penjualan', $sales);
    }

    public function count(){
        $sales = Sales::count();
        return new SalesResource(true, 'Jumlah Data Penjualan', $sales);
    }

    public function sum(){
        $sales = Sales::sum('total');
        return new SalesResource(true, 'Total Pemasukan Penjualan', $sales);
    }
    
}
