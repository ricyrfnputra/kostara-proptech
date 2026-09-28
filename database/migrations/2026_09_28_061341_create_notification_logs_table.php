<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bill_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['h_minus_3', 'h_minus_1', 'h_plus_1']);
            $table->enum('channel', ['log', 'whatsapp'])->default('log');
            $table->text('message');
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->unique(['bill_id', 'type', 'channel']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_logs');
    }
};