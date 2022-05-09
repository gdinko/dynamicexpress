<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarrierDynamicExpressOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrier_dynamic_express_offices', function (Blueprint $table) {
            $table->id();

            $table->integer('dynamic_express_id')->index();
            $table->string('name');
            $table->string('office_type');
            $table->integer('country_iso')->index();
            $table->integer('site_id');
            $table->string('city');
            $table->string('post_code')->index();
            $table->string('address');
            $table->string('lat');
            $table->string('lng');
            $table->boolean('parcel_pickup')->nullable(0);
            $table->boolean('parcel_acceptance')->nullable(0);
            $table->integer('max_parcel_dimensions_w');
            $table->integer('max_parcel_dimensions_h');
            $table->integer('max_parcel_dimensions_l');
            $table->integer('max_parcel_weight');
            $table->string('business_hours_d1');
            $table->string('business_hours_d2');
            $table->string('business_hours_d3');
            $table->string('business_hours_d4');
            $table->string('business_hours_d5');
            $table->string('business_hours_d6');
            $table->string('business_hours_d7');
            $table->string('info')->nullable();
            $table->string('distance')->nullable();
            $table->integer('subcon_id')->nullable(0);
            $table->string('office_ref')->nullable();

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
        Schema::dropIfExists('carrier_dynamic_express_offices');
    }
}
