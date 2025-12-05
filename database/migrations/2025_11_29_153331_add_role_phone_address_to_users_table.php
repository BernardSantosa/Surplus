<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'role')) {
                // Defines the role column with 'donor' and 'receiver' options
                $table->enum('role', ['donor', 'receiver'])->default('receiver');
            }

            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 25)->nullable();
            }

            if (!Schema::hasColumn('users', 'address')) {
                $table->string('address', 255)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'address']);
        });
    }
};