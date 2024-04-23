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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->uuid()->default(Uuid::uuid4()->toString())->unique();
            $table->string('title')->nullable(false);
            $table->text('description')->nullable(false);
            $table->text('image_path')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('city')->nullable(false);
            $table->decimal('price',10,2)->nullable(false);
            $table->string('phone_number')->nullable(false);
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
        Schema::dropIfExists('announcements');
    }
};
