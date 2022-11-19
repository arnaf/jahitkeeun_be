<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaklunAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maklun_applies', function (Blueprint $table) {
            $table->id();

            $table->string('status');
            $table->decimal('bid', 14, 2);
            $table->text('desc')->nullable();


            $table->foreignId('taylor_id')->constrained('taylors')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('maklun_id')->constrained('makluns')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('maklun_applies');
    }
};
