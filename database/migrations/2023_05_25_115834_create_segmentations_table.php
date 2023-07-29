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
            $table->date('period')->nullable();
            $table->integer('gems')->nullable();
            $table->boolean('relation')->default(1); // if true => relation is AND , if false => relation is OR
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
            'type' => 'New'
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
