<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddresesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('fullAddress');
            $table->string('posCode');
            $table->char('province_id', 2);
            $table->char('regency_id', 4);
            $table->char('district_id', 7);
            $table->char('village_id', 10);

            // $table->string('phone');
            // $table->date('dateBirth');
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            // $table->string('status');
            $table->foreign('province_id')
            ->references('id')
            ->on('provinces')
            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('regency_id')
                ->references('id')
                ->on('regencies')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('district_id')
            ->references('id')
            ->on('districts')
            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('village_id')
            ->references('id')
            ->on('villages')
            ->onUpdate('cascade')->onDelete('restrict');




            $table->foreignId('addresslabel_id')->constrained('address_labels')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('addresses');
    }
};
