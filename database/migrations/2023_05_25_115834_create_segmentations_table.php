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
            $table->timestamps();
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
