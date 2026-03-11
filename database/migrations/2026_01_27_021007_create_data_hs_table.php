<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('data_hs', function (Blueprint $table) {
    $table->id();
    $table->string('kode_hs');
    $table->string('nama_barang');
    $table->double('nilai_ekspor')->nullable();
    $table->double('nilai_impor')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_hs');
    }
};
