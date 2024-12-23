<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected $primaryKey = 'id_merek'; // Sesuaikan dengan kolom primary key

    public function products()
    {
        return $this->hasMany(Product::class, 'id_merek', 'id_merek');
    }
}
