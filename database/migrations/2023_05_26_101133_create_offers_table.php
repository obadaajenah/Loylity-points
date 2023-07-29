<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('partner_id')->nullable()->constrained('partners')->unsigned()->cascadeOnDelete();
            $table->foreignId('segmentation_id')->nullable()->constrained('segmentations')->unsigned()->cascadeOnDelete();
            $table->string('img_url')->default('uploads/offers/default.jpg');
            $table->integer('valueInBonus')->nullable();   
            $table->integer('valueInGems')->nullable();
            $table->integer('quantity')->default(1);
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
        Schema::dropIfExists('offers');
    }
}
