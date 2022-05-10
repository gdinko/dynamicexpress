<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarrierDynamicExpressPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrier_dynamic_express_payments', function (Blueprint $table) {
            $table->id();

            $table->string('num')->index()->unique();
            $table->string('rid')->index();
            $table->string('pay_type');
            $table->date('pay_date')->index();
            $table->decimal('amount');
            $table->json('meta')->nullable();            

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
        Schema::dropIfExists('carrier_dynamic_express_payments');
    }
}
