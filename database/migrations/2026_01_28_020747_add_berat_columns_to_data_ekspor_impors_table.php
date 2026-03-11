<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

   public function up(): void
{
    Schema::table('data_ekspor_impors', function (Blueprint $table) {
        $table->double('berat_ekspor')->nullable()->after('nilai_ekspor');
        $table->double('berat_impor')->nullable()->after('nilai_impor');
    });
}

public function down(): void
{
    Schema::table('data_ekspor_impors', function (Blueprint $table) {
        $table->dropColumn(['berat_ekspor', 'berat_impor']);
    });
}

};
