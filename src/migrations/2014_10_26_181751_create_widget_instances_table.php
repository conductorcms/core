<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWidgetInstancesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widget_instances', function ($table)
        {
            $table->increments('id');
            $table->integer('widget_id')->unsigned();
            $table->string('name');
            $table->string('slug');
            $table->text('options');
            $table->timestamps();

            $table->foreign('widget_id')
                ->references('id')->on('widgets')
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
        Schema::drop('widget_instances');
    }

}
