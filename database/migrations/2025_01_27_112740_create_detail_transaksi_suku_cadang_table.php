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
        Schema::create('detail_transaksi_suku_cadang', function (Blueprint $table) {
            $table->increments('id_detail_suku_cadang'); // PRIMARY KEY, UNSIGNED, AUTO_INCREMENT
            $table->unsignedInteger('qty')->notNull(); // UNSIGNED, NOT NULL, INT
            $table->unsignedInteger('diskon')->notNull(); // UNSIGNED, NOT NULL, INT
            $table->unsignedInteger('harga_setelah_diskon')->notNull(); // UNSIGNED, NOT NULL, INT
            $table->unsignedInteger('id_transaksi'); // UNSIGNED, INT(10)
            $table->string('id_suku_cadang', 8); // VARCHAR(8)

            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi')->onDelete('cascade'); // Foreign Key to transaksi table
            $table->foreign('id_suku_cadang')->references('id_suku_cadang')->on('suku_cadang')->onDelete('cascade'); // Foreign Key to suku_cadang table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi_suku_cadang');
    }
};
