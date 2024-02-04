<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('texts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comment_id')
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('text', 2000);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('texts');
    }
};
