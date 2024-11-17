<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('pemesanan_menus', function (Blueprint $table) {
        $table->decimal('harga', 15, 2)->default(0);
    });
}

public function down()
{
    Schema::table('pemesanan_menus', function (Blueprint $table) {
        $table->dropColumn('harga');
    });
}

};
