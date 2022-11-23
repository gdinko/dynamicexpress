<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToCarrierDynamicExpressOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carrier_dynamic_express_offices', function (Blueprint $table) {
            $table
                ->char('city_uuid', 36)
                ->nullable()
                ->after('site_id')
                ->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carrier_dynamic_express_offices', function (Blueprint $table) {
            $table->dropColumn('city_uuid');
        });
    }
}
