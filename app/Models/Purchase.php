<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'id_pembelian';

    public function distributors() {

        return $this->belongsTo(Distributor::class, 'id_distributor', 'id_distributor');
    }

    public function purchasedetails() {
        return $this->hasMany(PurchaseDetail::class, 'id_pembelian', 'id_pembelian');
    }
}
