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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->increments('id_transaksi'); // PRIMARY KEY, UNSIGNED, AUTO_INCREMENT
            $table->string('no_kuitansi', 17)->unique()->notNull(); // UNIQUE, NOT NULL, VARCHAR(17)
            $table->string('no_work_order', 16)->unique()->notNull(); // UNIQUE, NOT NULL, VARCHAR(16)
            $table->date('tanggal_transaksi')->notNull(); // NOT NULL, DATE
            $table->date('tanggal_kembali')->notNull(); // NOT NULL, DATE
            $table->unsignedInteger('grand_total')->notNull(); // UNSIGNED, NOT NULL, INT
            $table->enum('status_pembayaran', ['Lunas', 'Belum Lunas'])->default('Belum Lunas'); // NOT NULL, ENUM
            $table->text('saran_mekanik')->nullable(); // TEXT
            $table->unsignedInteger('id_mekanik'); // UNSIGNED, INT(10)
            $table->unsignedInteger('id_kendaraan'); // UNSIGNED, INT(10)

            $table->foreign('id_mekanik')->references('id_mekanik')->on('mekanik')->onDelete('cascade'); // Foreign Key to mekanik table
            $table->foreign('id_kendaraan')->references('id_kendaraan')->on('kendaraan')->onDelete('cascade'); // Foreign Key to kendaraan table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
