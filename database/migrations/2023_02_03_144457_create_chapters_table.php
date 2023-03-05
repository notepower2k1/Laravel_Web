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
        Schema::create('chapters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->longText('content');
            $table->string('slug'); 
            $table->unsignedInteger('book_id');
            $table->foreign('book_id')
            ->references('id')->on('books')->onDelete('cascade');
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
        Schema::dropIfExists('chapters');
    }
};
