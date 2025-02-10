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
        // Trigger for no kuitansi
        DB::unprepared("
            CREATE TRIGGER before_insert_kuitansi 
            BEFORE INSERT ON transaksi 
            FOR EACH ROW 
            BEGIN 
                DECLARE next_id INT;
                DECLARE formatted_date VARCHAR(9);
                SET formatted_date = DATE_FORMAT(NEW.tanggal_transaksi, '%Y-%m%d');
                SELECT value INTO next_id FROM counter WHERE key_name = 'no_kuitansi' FOR UPDATE;
                SET NEW.no_kuitansi = CONCAT('TMM-', formatted_date, LPAD(next_id, 4, '0'));
                UPDATE counter SET value = value + 1 WHERE key_name = 'no_kuitansi';
            END;
        ");

        // Trigger for no work order
        DB::unprepared("
            CREATE TRIGGER before_insert_work_order 
            BEFORE INSERT ON transaksi 
            FOR EACH ROW 
            BEGIN 
                DECLARE next_id INT;
                DECLARE formatted_date VARCHAR(8);
                SET formatted_date = DATE_FORMAT(NEW.tanggal_transaksi, '%Y%m%d');
                SELECT value INTO next_id FROM counter WHERE key_name = 'no_work_order' FOR UPDATE;
                SET NEW.no_work_order = CONCAT('WO-', formatted_date, LPAD(next_id, 4, '0'));
                UPDATE counter SET value = value + 1 WHERE key_name = 'no_work_order';
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS before_insert_kuitansi;");
        DB::unprepared("DROP TRIGGER IF EXISTS before_insert_work_order;");
    }
};
