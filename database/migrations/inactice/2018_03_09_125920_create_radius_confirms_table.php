<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRadiusConfirmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radius_confirms', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('hash')->nullable();
            $table->boolean('completed')->default(false);

            $table->uuid('radius_user_id')->nullable();

            $table->foreign('radius_user_id')
                  ->references('id')
                  ->on('radius_users');

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
        Schema::dropIfExists('radius_confirm');
    }
}
