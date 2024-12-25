<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    public function index() {
        if (Auth::user()->role != 1 && Auth::user()->role != 2){
            return redirect('dashboard');
        }
        $brands = Brand::all();
        return view('merek.brand', compact('brands'));
    }

    public function add(Request $request) {
        Brand::create([
            'nama_merek' => $request->nama_merek,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect('merek');
    }

    public function delete(Request $request, $id) {
        $brand = Brand::find($id);
        $brand->delete();
        return redirect('merek');
    }

    public function edit(Request $request, $id) {
        $brand = Brand::find($id);
        $brand->update([
            'nama_merek' => $request->nama_merek,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect('merek');
    }
}
