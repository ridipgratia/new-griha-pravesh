<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficaryMappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficary_mapping', function (Blueprint $table) {
            $table->id();
            $table->integer('district_id');
            $table->integer('block_id');
            $table->integer('gp_id');
            $table->integer('village_id');
            $table->string('reg_no');
            $table->string('name');
            $table->string('lat');
            $table->string('lon');
            $table->integer('status');
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
        Schema::dropIfExists('beneficary_mapping');
    }
}
