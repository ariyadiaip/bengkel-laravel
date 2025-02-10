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
        Schema::create('kendaraan', function (Blueprint $table) {
            $table->increments('id_kendaraan'); // PRIMARY KEY, UNSIGNED, AUTO_INCREMENT
            $table->string('no_polisi', 11)->unique()->notNull(); // UNIQUE, NOT NULL, VARCHAR(11)
            $table->string('tipe', 10)->notNull(); // NOT NULL, VARCHAR(10)
            $table->string('model', 20)->notNull(); // NOT NULL, VARCHAR(20)
            $table->year('tahun')->notNull(); // NOT NULL, YEAR(4)
            $table->unsignedInteger('id_pelanggan'); // UNSIGNED, INT
            
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan')->onDelete('cascade'); // Foreign Key to pelanggan table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraan');
    }
};
