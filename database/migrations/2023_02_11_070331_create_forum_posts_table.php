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
        Schema::create('forum_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('topic');
            $table->longText('content');
            $table->unsignedInteger('forumID');
            
            $table->foreign('forumID')
            ->references('id')->on('forums')->onDelete('cascade');

            $table->unsignedbigInteger('userCreatedID');
            $table->foreign('userCreatedID')
            ->references('id')->on('users')->onDelete('cascade');
            
            $table->timestamps();
            $table->string('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_posts');
    }
};
