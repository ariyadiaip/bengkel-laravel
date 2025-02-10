<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("
            CREATE FUNCTION nextServiceDate(tanggal_transaksi DATE) 
            RETURNS DATE
            DETERMINISTIC
            BEGIN
                RETURN DATE_ADD(tanggal_transaksi, INTERVAL 90 DAY);
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP FUNCTION IF EXISTS nextServiceDate;");
    }
};
