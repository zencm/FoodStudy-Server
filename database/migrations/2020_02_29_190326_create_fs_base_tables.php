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
            $table->increments('id');
            $table->string('bls_key', 12);
            $table->string('name_de', 255);
            $table->string('name_en', 255);
        });
        
        Schema::create('fs_studies', function (Blueprint $table) {
        	
            $table->increments('id');
            $table->string('name', 255);
            $table->string('prefix', 32)->unique();
            
            $table->timestamp('from')->useCurrent();
            $table->timestamp('until')->nullable();
            
            $table->boolean('reg_public')->default(false);
            $table->string('reg_key', 128)->nullable();
            
            $table->unsignedInteger('reg_limit')->nullable();
            
            $table->unsignedInteger('user_count')->default(0);
        });
        

        Schema::create('fs_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('user');
            $table->unsignedInteger('study');
            $table->timestamp('date')->useCurrent();
            $table->timestamp('received')->useCurrent();
            
            $table->smallInteger('sleep')->nullable();
            $table->smallInteger('mood')->nullable();
            $table->smallInteger('digestion')->nullable();

            $table->index(['date']);


        });

        Schema::create('fs_log_food', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('user');
            $table->unsignedInteger('study');
            $table->timestamp('date')->useCurrent();
            $table->timestamp('received')->useCurrent();
            
            $table->unsignedInteger('bls')->nullable();
            $table->string('bls_key')->nullable();
            $table->text('food')->nullable();
            
            $table->string('meal_type', 128)->nullable();

            $table->smallInteger('people')->unsigned();

            $table->index(['date']);
            
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
        Schema::dropIfExists('fs_studies');
        Schema::dropIfExists('fs_log');
        Schema::dropIfExists('fs_log_food');
    }
}
