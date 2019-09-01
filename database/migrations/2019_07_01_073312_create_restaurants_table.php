<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('name', 100);
            $table->char('type', 40);
            $table->bigInteger('owner_id')->unsigned();
            $table->time('starts_at');
            $table->time('colses_at');
            $table->char('district', 30);
            $table->char('area', 50);
            $table->char('Road_name', 130)->nullable();
            $table->char('Road_no', 40);
            $table->char('House_name', 130)->nullable();
            $table->char('House_no', 40);
            $table->char('Level', 30);
            $table->unique('name');

            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
}
