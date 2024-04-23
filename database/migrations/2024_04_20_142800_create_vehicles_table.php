<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->uuid()->default(Uuid::uuid4()->toString())->unique();
            $table->integer('year')->nullable(false);
            $table->string('brand')->nullable(false);
            $table->string('model')->nullable(false);
            $table->string('license_plate')->nullable();
            $table->enum('status',['new','used'])->nullable(false);
            $table->enum('transmission', ['automatic', 'manual'])->nullable(false);
            $table->integer('mileage')->nullable(false);
            $table->foreignId('announcement_id')->constrained();
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
        Schema::dropIfExists('vehicles');
    }
};
