<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRadiusUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radius_users', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('forename');
            $table->string('surname');
            $table->string('email')->unique();
            $table->string('username');
            $table->string('password');
            $table->boolean('suspended')->default(true);
            $table->timestamps();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('radius_users');
    }
}
