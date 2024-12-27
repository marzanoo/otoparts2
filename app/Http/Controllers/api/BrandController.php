<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brand = Brand::all();
        return new BrandResource(true, 'List Data Merek', $brand);
    }

    public function store(Request $request)
    {
        $brand = new Brand;
        $brand->nama_merek = $request->nama_merek;
        $brand->deskripsi = $request->deskripsi;
        $data = $brand->save();

        if($data != false)
        {
            $response["error"] = FALSE;
            $response["success"] = 1;
            $response["message"] = "Data Berhasil Disimpan";
        }else
        {
            $response["error"] = TRUE;
            $response["success"] = 0;
            $response["message"] = "Data Gagal Disimpan";
        }

        echo json_encode($response);
    }

    public function cari(Request $request)
    {
        $brand = Brand::where('nama_merek', 'like', '%'.$request->cari.'%')->get();

        return new BrandResource(true, 'List Data Merek', $brand);
    }
}
