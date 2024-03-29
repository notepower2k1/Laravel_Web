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
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('content');
            $table->unsignedInteger('identifier_id');
            $table->unsignedInteger('type_id');
            $table->foreign('type_id')
            ->references('id')->on('comment_types')->onDelete('cascade');
            $table->unsignedbigInteger('userID');
            $table->foreign('userID')
            ->references('id')->on('users')->onDelete('cascade');
            $table->integer('totalReplies');
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
        Schema::dropIfExists('comments');
    }
};
