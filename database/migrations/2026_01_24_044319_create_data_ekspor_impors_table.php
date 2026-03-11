<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_ekspor_impors', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->string('bulan');
            $table->double('nilai_ekspor')->nullable();
            $table->double('nilai_impor')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_ekspor_impors');
    }
};

