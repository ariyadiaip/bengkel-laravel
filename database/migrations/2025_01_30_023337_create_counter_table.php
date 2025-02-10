<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('counter', function (Blueprint $table) {
            $table->string('key_name', 50)->primary(); // PRIMARY KEY, VARCHAR(50)
            $table->unsignedInteger('value'); // UNSIGNED, INT(10)
        });

        // Insert default values
        DB::table('counter')->insert([
            ['key_name' => 'id_jasa', 'value' => 10001],
            ['key_name' => 'id_suku_cadang', 'value' => 20001],
            ['key_name' => 'no_work_order', 'value' => 1],
            ['key_name' => 'no_kuitansi', 'value' => 1]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counter');
    }
};
