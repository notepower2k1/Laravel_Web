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
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->text('image');
            $table->boolean('isCompleted');
            $table->boolean('isPublic');
            $table->tinyInteger('language'); //0 - VN //1 - English
            $table->string('slug');
            $table->text('file');
            $table->unsignedInteger('type_id');
            $table->foreign('type_id')
            ->references('id')->on('document_types')->onDelete('cascade');
            $table->timestamp('deleted_at')->nullable();;
            $table->timestamps();
            $table->unsignedbigInteger('userCreatedID');
            $table->foreign('userCreatedID')
            ->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
