<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function purchases() {
        return $this->belongsTo(Purchase::class, 'id_pembelian', 'id_pembelian');
    }

    public function products() {
        return $this->belongsTo(Product::class, 'id_barang', 'id_barang');
    }
}
