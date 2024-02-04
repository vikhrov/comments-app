<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('user_name', 128);
            $table->string('email', 256);
            $table->string('home_page', 256)->nullable();
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('comments')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
