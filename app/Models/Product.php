<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'id_barang'; // Sesuaikan dengan kolom primary key

    public function brands()
    {
        return $this->belongsTo(Brand::class, 'id_merek', 'id_merek');
    }

    public function details() {
        return $this->hasMany(Details::class, 'id_barang', 'id_barang');
    }

    public function purchasedetails() {
        return $this->hasMany(PurchaseDetail::class, 'id_barang', 'id_barang');
    }
}
