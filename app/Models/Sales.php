<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primary_key = 'id_penjualan';

    public function users () {

        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
