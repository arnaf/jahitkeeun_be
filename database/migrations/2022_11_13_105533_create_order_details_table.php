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
            $table->text('photoClient1');
            $table->text('photoClient2');
            $table->text('photoClient3');
            $table->text('photoClient4');
            $table->text('photoClient5');
            $table->text('photoTaylor1');
            $table->text('photoTaylor2');
            $table->text('photoTaylor3');
            $table->text('photoTaylor4');
            $table->text('photoTaylor5');

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
