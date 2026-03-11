<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up()
{
    Schema::table('data_hs', function (Blueprint $table) {
        $table->double('berat_ekspor')->nullable();
        $table->double('berat_impor')->nullable();
    });
}

public function down()
{
    Schema::table('data_hs', function (Blueprint $table) {
        $table->dropColumn(['berat_ekspor', 'berat_impor']);
    });
}

};
