<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFSBaseTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fs_bls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bls_key', 12);
            $table->string('name', 255);
        });

        Schema::create('fs_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('user');
            $table->timestamp('date')->useCurrent();
            $table->timestamp('received')->useCurrent();
            
            $table->smallInteger('sleep')->nullable();
            $table->smallInteger('mood')->nullable();
            $table->smallInteger('digestion')->nullable();

        });

        Schema::create('fs_log_food', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('user');
            $table->timestamp('date')->useCurrent();
            $table->timestamp('received')->useCurrent();
            
            $table->unsignedBigInteger('bls')->nullable();
            $table->string('bls_key')->nullable();
            $table->string('food', 255)->nullable();
            
            $table->string('meal_type', 128)->nullable();

            $table->smallInteger('people')->unsigned();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fs_bls');
        Schema::dropIfExists('fs_log');
        Schema::dropIfExists('fs_log_food');
    }
}
