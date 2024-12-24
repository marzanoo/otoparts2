<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Details extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function sales() {
        return $this->belongsTo(Sales::class, 'id_penjualan', 'id_penjualan');
    }

    public function products() {
        return $this->belongsTo(Product::class, 'id_barang', 'id_barang');
    }
}
