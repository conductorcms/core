<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreaInstancesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widget_area_instances', function ($table)
        {
            $table->increments('id');
            $table->integer('area_id')->unsigned();
            $table->integer('instance_id')->unsigned();

            $table->foreign('area_id')
                ->references('id')->on('widget_areas')
                ->onDelete('cascade');

            $table->foreign('instance_id')
                ->references('id')->on('widget_instances')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('widget_area_instances');
    }

}
