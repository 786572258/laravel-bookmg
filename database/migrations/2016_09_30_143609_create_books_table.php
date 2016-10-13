<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
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
            $table->string('bookname', 100);
            $table->string('publisher', 100);
            $table->string('author', 50);
            $table->decimal('price', 6, 2)->default(0);
            $table->text('content');
            $table->tinyInteger('recom')->default(0);
            $table->integer('cid');
            $table->string('tags');
            $table->string('pic');
            $table->integer('user_id');
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
        Schema::drop('books');
    }
}
