<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proxies', function (Blueprint $table) {
            $table->id();
            $table->string('address', 255); // IP:Port format
            $table->string('credentials', 255)->nullable(); // user:pass
            $table->enum('type', ['http', 'socks4', 'socks5'])->default('http');
            $table->enum('status', ['active', 'banned', 'cooling'])->default('active');
            $table->unsignedInteger('fail_count')->default(0);
            $table->unsignedInteger('success_count')->default(0);
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('banned_until')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'last_used_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proxies');
    }
};
