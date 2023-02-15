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
            Schema::create('books', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('author');
                $table->text('description');
                $table->text('image');
                $table->integer('status');
                $table->string('slug');
                $table->unsignedInteger('type_id');
                $table->foreign('type_id')
                ->references('id')->on('types')->onDelete('cascade');
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
        Schema::dropIfExists('books');
    }
};
