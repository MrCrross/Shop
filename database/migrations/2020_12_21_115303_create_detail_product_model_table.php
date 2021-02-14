<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailProductModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_product_model', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_model_id')->nullable()->references('id')->on('product_models');
            $table->unsignedBigInteger('detail_id')->nullable()->references('id')->on('details');
            $table->string('value');
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
        Schema::dropIfExists('detail_model');
    }
}
