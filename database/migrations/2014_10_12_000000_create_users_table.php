<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',250);
            $table->string('email',250)->unique();
            $table->string('password',250);
            $table->string('type',250);
            $table->string('first_name',250);
            $table->string('last_name',250);
            $table->string('address',250);
            $table->string('city',250);
            $table->string('country',250);
            $table->integer('postal_code');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
