<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->decimal('totalPayment', 14, 2);
            $table->string('paymentStatus');
            $table->string('orderStatus');
            $table->string('invoice');
            $table->text('address');
            $table->date('estimationDate')->nullable();


            $table->foreignId('deliveries_id')->constrained('deliveries')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('payment_method_id')->constrained('payment_methods')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('shipping_method_id')->constrained('shipping_methods')->onUpdate('cascade')->onDelete('restrict');

            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('restrict');

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
        Schema::dropIfExists('orders');
    }
};
