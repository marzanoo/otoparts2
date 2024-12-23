<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    public function index() {
        $distributors = Distributor::all();

        return view('distributor.distributor', compact('distributors'));
    }

    public function add(Request $request) {
        Distributor::create([
            'nama_distributor' => $request->nama_distributor,
            'alamat' => $request->alamat,
            'kontak' => $request->kontak,
            'email' => $request->email
        ]);
        return redirect('distributor');
    }

    public function delete(Request $request, $id) {
        $distributor = Distributor::find($id);
        $distributor->delete();
        return redirect('distributor');
    }

    public function edit(Request $request, $id) {
        $distributor = Distributor::find($id);
        $distributor->update([
            'nama_distributor' => $request->nama_distributor,
            'alamat' => $request->alamat,
            'kontak' => $request->kontak,
            'email' => $request->email
        ]);
        return redirect('distributor');
    }
}
