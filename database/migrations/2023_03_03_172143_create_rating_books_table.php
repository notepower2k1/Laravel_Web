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
        Schema::create('rating_books', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bookID');
            $table->tinyInteger('score');
            $table->foreign('bookID')
            ->references('id')->on('books')->onDelete('cascade');
            $table->unsignedbigInteger('userID');
            $table->foreign('userID')
            ->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('rating_books');
    }
};
