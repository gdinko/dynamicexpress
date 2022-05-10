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

            $table->integer('dynamic_express_id')->nullable()->index();
            $table->string('name');
            $table->string('office_type');
            $table->integer('country_iso')->index();
            $table->integer('site_id')->nullable();
            $table->string('city')->nullable();
            $table->string('post_code')->nullable()->index();
            $table->string('address')->nullable();
            $table->string('lat');
            $table->string('lng');
            $table->json('meta')->nullable();
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
