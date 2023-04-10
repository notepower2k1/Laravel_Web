<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('identifier_id');
            $table->unsignedInteger('type_id');
            $table->foreign('type_id')
            ->references('id')->on('notification_types')->onDelete('cascade');
            $table->unsignedbigInteger('senderID');
            $table->foreign('senderID')
            ->references('id')->on('users')->onDelete('cascade');
            $table->unsignedbigInteger('receiverID');
            $table->foreign('receiverID')
            ->references('id')->on('users')->onDelete('cascade');
            $table->boolean('status')->default('1');
            $table->timestamp('deleted_at')->nullable();;
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
        Schema::dropIfExists('notifications');
    }
};
