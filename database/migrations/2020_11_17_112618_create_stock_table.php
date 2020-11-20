<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('publish')->default(1);
            $table->bigInteger('sort')->nullable();
            $table->string('title', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('cover', 255)->nullable();
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
        Schema::dropIfExists('stock');
    }
}
