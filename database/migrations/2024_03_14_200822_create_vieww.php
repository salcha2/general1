<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateVieww extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW general_view AS
            SELECT 
                g.*,
                d.DEVICE_TYPE AS device_type,
                e.ENTITY AS entity,
                e.COMPANY AS company,
                s.STATE AS state,
                ra.username AS reciver,
                ia.username AS inserted_B,
                ma.username AS modified_B
            FROM Inventory.`General` g
            LEFT JOIN Inventory.DeviceType d ON g.DEVICE_ID = d.ID
            LEFT JOIN Inventory.Entities e ON g.ORIGIN = e.ID
            LEFT JOIN Inventory.Status s ON g.STATE_ID = s.ID
            LEFT JOIN Inventory.admin_users ra ON g.RECIPIENT = ra.id
            LEFT JOIN Inventory.admin_users ia ON g.INSERTED_BY = ia.id
            LEFT JOIN Inventory.admin_users ma ON g.MODIFIED_BY = ma.id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS general_view");
    }
}


