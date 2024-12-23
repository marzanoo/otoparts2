<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index () {
        $users = User::all();
        $sales = Sales::with('users')->get();

        return view('penjualan.sales', compact('sales', 'users'));
    }
}
