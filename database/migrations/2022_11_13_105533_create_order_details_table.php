<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();

            $table->decimal('price', 14, 2);
            $table->integer('quantity');
            $table->date('pickup');
            $table->text('desc')->nullable();
            $table->text('photoClient1')->nullable();
            $table->text('photoClient2')->nullable();
            $table->text('photoClient3')->nullable();
            $table->text('photoClient4')->nullable();
            $table->text('photoClient5')->nullable();
            $table->text('photoTaylor1')->nullable();
            $table->text('photoTaylor2')->nullable();
            $table->text('photoTaylor3')->nullable();
            $table->text('photoTaylor4')->nullable();
            $table->text('photoTaylor5')->nullable();
            $table->text('orderStatus')->nullable();

            $table->foreignId('service_id')->constrained('services')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('order_id')->constrained('orders')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('order_details');
    }
};
