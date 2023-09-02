<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSegmentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('segmentations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->integer('period')->nullable();
            $table->integer('gems')->nullable();
            $table->boolean('relation')->default(1); // if true => relation is AND , if false => relation is OR
            $table->integer('offerMaxGems')->default(0);
            $table->integer('offerMaxBonus')->default(0);
        });

        DB::table('segmentations')->insert([
            'id' => 1,
            'name' => 'Golden',
            'type' => 'VIP'
        ]);
        DB::table('segmentations')->insert([
            'id' => 2,
            'name' => 'Silver',
            'type' => 'VIP'
        ]);
        DB::table('segmentations')->insert([
            'id' => 3,
            'name' => 'Bronze',
            'type' => 'VIP'
        ]);
        DB::table('segmentations')->insert([
            'id' => 4,
            'name' => 'New',
            'type' => 'New',
            'period' => 0,
            'gems' => 0,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('segmentations');
    }
}
