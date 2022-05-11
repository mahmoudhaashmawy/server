<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->default(0);
            $table->string('name')->nullable();
            $table->string('location', 40)->nullable();
            $table->string('map_latitude', 40)->nullable();
            $table->string('map_longitude', 40)->nullable();
            $table->string('duration', 40)->nullable();
            $table->timestamp('departure_time')->nullable();
            $table->timestamp('return_time')->nullable();
            $table->integer('capacity')->default(0);
            $table->decimal('price',18,8)->default(0);
            $table->json('images')->nullable();
            $table->text('details')->nullable();
            $table->json('included')->nullable();
            $table->json('excluded')->nullable();
            $table->json('tour_plan')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('plans');
    }
}
