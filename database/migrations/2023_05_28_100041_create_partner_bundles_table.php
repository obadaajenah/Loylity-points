<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerBundlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_bundles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->nullable()->constrained('partners')->unsigned()->cascadeOnDelete();
            $table->foreignId('bundle_id')->nullable()->constrained('bundles')->unsigned()->cascadeOnDelete();
            $table->boolean('status')->default(1);
            $table->integer('price');
            $table->integer('golden_offers_number')->default(0);
            $table->integer('silver_offers_number')->default(0);
            $table->integer('bronze_offers_number')->default(0);
            $table->integer('new_offers_number')->default(0);
            $table->date('start_date');
            $table->date('end_date');
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
        Schema::dropIfExists('partner_bundles');
    }
}
