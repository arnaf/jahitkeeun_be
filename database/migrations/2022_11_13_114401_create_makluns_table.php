<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaklunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('makluns', function (Blueprint $table) {
            $table->id();

            $table->text('title');
            $table->text('desc');
            $table->decimal('price', 14, 2);
            $table->date('dueTime');
            $table->string('status');

            $table->foreignId('taylor_id')->constrained('taylors')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('client_id')->constrained('clients')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('convection_id')->constrained('convections')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('makluns');
    }
};
