<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->decimal('starting_price', 10, 2);
            $table->decimal('current_price', 10, 2)->default(0);
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'ended', 'cancelled'])->default('active');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            $table->index('user_id');
            $table->index('status');
            $table->index('end_time');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};