<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcement', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('author_id')->unsigned();
            $table->foreign('author_id')->references('id')->on('author')->cascadeOnUpdate()->cascadeOnDelete();
            $table->tinyInteger('publish')->default(1);
            $table->bigInteger('sort')->nullable();
            $table->string('title', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->text('desc')->nullable();
            $table->text('text')->nullable();
            $table->text('met_keywords')->nullable();
            $table->text('met_description')->nullable();
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
        Schema::dropIfExists('announcement');
    }
}
