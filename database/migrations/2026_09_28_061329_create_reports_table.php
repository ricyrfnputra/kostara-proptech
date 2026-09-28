<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->foreignId('room_id')->constrained()->restrictOnDelete();
            $table->string('title');
            $table->text('description');
            $table->enum('category', [
                'listrik', 'air', 'ac', 'furnitur', 'bangunan', 'keamanan', 'lainnya',
            ]);
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->enum('status', ['diajukan', 'diproses', 'selesai'])->default('diajukan');
            $table->string('photo')->nullable();
            $table->timestamps();

            $table->index(['status', 'priority']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};