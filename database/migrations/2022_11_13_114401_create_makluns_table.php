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

            $table->foreignId('maklun_maker_id')->constrained('users')->onUpdate('cascade')->onDelete('restrict');

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
