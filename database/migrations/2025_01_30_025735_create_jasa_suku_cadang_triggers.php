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
        // Trigger for jasa
        DB::unprepared("
            CREATE TRIGGER before_insert_jasa 
            BEFORE INSERT ON jasa 
            FOR EACH ROW 
            BEGIN 
                DECLARE next_id INT;
                SELECT value INTO next_id FROM counter WHERE key_name = 'id_jasa' FOR UPDATE;
                SET NEW.id_jasa = CONCAT('JS-', LPAD(next_id, 5, '0'));
                UPDATE counter SET value = value + 1 WHERE key_name = 'id_jasa';
            END;
        ");

        // Trigger for suku cadang
        DB::unprepared("
            CREATE TRIGGER before_insert_suku_cadang 
            BEFORE INSERT ON suku_cadang 
            FOR EACH ROW 
            BEGIN 
                DECLARE next_id INT;
                SELECT value INTO next_id FROM counter WHERE key_name = 'id_suku_cadang' FOR UPDATE;
                SET NEW.id_suku_cadang = CONCAT('SC-', LPAD(next_id, 5, '0'));
                UPDATE counter SET value = value + 1 WHERE key_name = 'id_suku_cadang';
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS before_insert_jasa;");
        DB::unprepared("DROP TRIGGER IF EXISTS before_insert_suku_cadang;");
    }
};
