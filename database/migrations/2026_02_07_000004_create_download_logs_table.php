<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('download_logs', function (Blueprint $table) {
            $table->id();
            $table->text('url');
            $table->string('shortcode', 100)->nullable();
            $table->string('media_type', 50)->nullable(); // post, reel, story, igtv, carousel
            $table->string('status', 20)->default('pending'); // pending, success, failed
            $table->string('strategy_used', 50)->nullable(); // direct, rapidapi, etc.
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('error_message')->nullable();
            $table->unsignedInteger('media_count')->default(0);
            $table->timestamps();
            
            $table->index(['status', 'created_at']);
            $table->index('media_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('download_logs');
    }
};
