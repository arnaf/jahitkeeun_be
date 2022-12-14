<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConvectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convections', function (Blueprint $table) {
            $table->id();
            // $table->string('name');
            $table->string('photo')->nullable();
            $table->string('phone')->nullable();
            $table->date('dateBirth')->nullable();
            $table->string('placeBirth')->nullable();
            $table->string('status');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('convections');
    }
};
