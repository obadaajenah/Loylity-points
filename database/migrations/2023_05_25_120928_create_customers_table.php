<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->unsigned()->cascadeOnDelete();
            $table->foreignId('segmentation_id')->default(4)->constrained('segmentations')->unsigned()->cascadeOnDelete();
            $table->string('nickName')->nullable();
            $table->integer('cur_bonus')->default(0);
            $table->integer('total_bonus')->default(0);
            $table->integer('cur_gems')->default(0);
            $table->integer('total_gems')->default(0);
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
        Schema::dropIfExists('customers');
    }
}
