<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('id_barang');
            $table->unsignedBigInteger('id_merek');
            $table->string('nama_barang', 100);
            $table->string('jenis_barang', 50);
            $table->integer('lokasi_rak');
            $table->decimal('harga_beli', 12,2);
            $table->decimal('harga_jual', 12,2);
            $table->timestamps();

            $table->foreign('id_merek')->references('id_merek')->on('brands')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
