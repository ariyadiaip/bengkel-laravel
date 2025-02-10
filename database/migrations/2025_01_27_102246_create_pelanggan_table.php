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
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->increments('id_pelanggan'); // PRIMARY KEY, UNSIGNED, AUTO_INCREMENT
            $table->string('nama_pelanggan', 30)->notNull(); // NOT NULL, VARCHAR(30)
            $table->string('alamat', 50)->notNull(); // NOT NULL, VARCHAR(50)
            $table->string('no_telepon', 15)->notNull(); // NOT NULL, VARCHAR(15)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
