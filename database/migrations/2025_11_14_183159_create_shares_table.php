<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shares', function (Blueprint $table) {
            $table->id();
            $table->morphs('shareable');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('platform');
            $table->string('ip_address');
            $table->text('user_agent')->nullable();
            $table->timestamps();
            
           // $table->index(['shareable_type', 'shareable_id']);
            $table->index('user_id');
            $table->index('platform');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shares');
    }
};