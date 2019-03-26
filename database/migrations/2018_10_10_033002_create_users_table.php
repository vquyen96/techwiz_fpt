<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'users';

    /**
     * Run the migrations.
     * @table users
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) {
            return;
        }
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->string('id', 15)->primary();
            $table->string('name', 127);
            $table->string('email', 127);
            $table->string('password', 127);
            $table->text('description');
            $table->string('avatar_url', 255);
            $table->unsignedTinyInteger('role');
            $table->string('tel', 31);
            $table->unsignedTinyInteger('verified');
            $table->unsignedTinyInteger('status');

            $table->rememberToken();
            $table->timestamps();
            
            $table->unique(['email']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->set_schema_table);
    }
}
