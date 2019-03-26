<?php

use App\Enums\Job\Status;
use App\Enums\Job\Type;
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
            $table->string('id', 15)->primary();
            $table->string('title');
            $table->string('salary');
            $table->text('benefit');
            $table->text('description');
            $table->text('requirement');
            $table->string('keyword');
            $table->string('language');
            $table->integer('year_experience');
            $table->unsignedTinyInteger('rank');
            $table->unsignedInteger('view')->default(0);
            $table->unsignedInteger('type')->default(Type::NORMAL);
            $table->unsignedInteger('status')->default(Status::ACTIVE);
            $table->unsignedTinyInteger('expired');
            $table->dateTime('expired_date');
            $table->dateTime('start_date');
            $table->string('company_id', 15);
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
