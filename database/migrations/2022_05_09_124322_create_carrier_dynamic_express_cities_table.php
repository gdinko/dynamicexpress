<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarrierDynamicExpressCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrier_dynamic_express_cities', function (Blueprint $table) {
            $table->id();

            $table->integer('country_iso')->index();
            $table->integer('site_id')->index();
            $table->string('name')->index();
            $table->string('region')->nullable();
            $table->string('municipality')->nullable();
            $table->string('site_type')->nullable();
            $table->string('post_code')->index();
            $table->string('eknm')->nullable();
            $table->char('delivery_weekdays', 7)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carrier_dynamic_express_cities');
    }
}
