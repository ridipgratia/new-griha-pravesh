<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficaryDetailsExcelDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficary_details_excel_data', function (Blueprint $table) {
            $table->id();
            $table->integer('district_id');
            $table->integer('block_id');
            $table->integer('gp_id');
            $table->integer('village_id')->nullable();
            $table->string('reg_no');
            $table->string('name');
            $table->string('lat')->nullable();
            $table->string('lon')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('beneficary_details_excel_data');
    }
}
