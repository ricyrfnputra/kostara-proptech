<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['owner', 'tenant'])->default('tenant')->after('password');
            $table->string('phone', 20)->nullable()->after('role');
            $table->foreignId('room_id')
                ->nullable()
                ->unique()
                ->after('phone')
                ->constrained('rooms')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('room_id');
            $table->dropColumn(['role', 'phone']);
        });
    }
};