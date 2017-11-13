<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeekItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('week_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('week_id');
            $table->foreign('week_id')->references('id')->on('weeks')->onDelete('cascade');
            $table->string('title');
            $table->decimal('rate');
            $table->decimal('sun')->nullable();
            $table->decimal('mon')->nullable();
            $table->decimal('tue')->nullable();
            $table->decimal('wed')->nullable();
            $table->decimal('thu')->nullable();
            $table->decimal('fri')->nullable();
            $table->decimal('sat')->nullable();
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
        Schema::dropIfExists('week_items');
    }
}
