<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('benefit');
            $table->text('description');
            $table->text('requirement');
            $table->string('keyword');
            $table->string('language');
            $table->unsignedTinyInteger('rank');
            $table->unsignedInteger('view');
            $table->unsignedInteger('type');
            $table->unsignedInteger('status');
            $table->unsignedTinyInteger('expired');
            $table->dateTime('expired_date');
            $table->dateTime('start_date');
            $table->unsignedInteger('company_id');
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade');
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('cascade');
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
        Schema::dropIfExists('jobs');
    }
}
