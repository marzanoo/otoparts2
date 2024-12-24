<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'id_distributor';

    public function purchases() {
        return $this->hasMany(Purchase::class, 'id_distributor', 'id_distributor');
    }
}
