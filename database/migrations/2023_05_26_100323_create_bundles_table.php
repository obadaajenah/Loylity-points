<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBundlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bundles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price')->default(0);
            $table->integer('bonus')->nullable();
            $table->integer('gems')->nullable();
            $table->integer('expiration_period')->nullable();
            $table->integer('golden_offers_number')->nullable();
            $table->integer('silver_offers_number')->nullable();
            $table->integer('bronze_offers_number')->nullable();
            $table->integer('new_offers_number')->nullable();
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
        Schema::dropIfExists('bundles');
    }
}
