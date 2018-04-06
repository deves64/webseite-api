<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Messages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->uuid('id');

            $table->uuid('sender_id')->nullable();
            $table->foreign('sender_id')
                  ->references('id')
                  ->on('persons');

            $table->uuid('receiver_id')->nullable();
            $table->foreign('receiver_id')
                  ->references('id')
                  ->on('persons');

            $table->uuid('sender_client_id')->nullable();
            $table->foreign('sender_client_id')
                  ->references('id')
                  ->on('clients');

            $table->uuid('receiver_client_id')->nullable();
            $table->foreign('receiver_client_id')
                  ->references('id')
                  ->on('clients');

            $table->string('subject');
            $table->string('message');
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
        Schema::dropIfExists('messages');
    }
}
