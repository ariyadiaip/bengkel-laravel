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
        Schema::create('suku_cadang', function (Blueprint $table) {
            $table->string('id_suku_cadang', 8)->primary(); // PRIMARY KEY, VARCHAR(8)
            $table->string('nama_suku_cadang', 30)->notNull(); // NOT NULL, VARCHAR(30)
            $table->unsignedInteger('harga_satuan')->notNull(); // NOT NULL, INT UNSIGNED
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suku_cadang');
    }
};
