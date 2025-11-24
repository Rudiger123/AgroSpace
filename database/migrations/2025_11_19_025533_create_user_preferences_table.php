<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Langue et région
            $table->string('language', 10)->default('fr');
            $table->string('timezone', 50)->default('Africa/Douala');
            $table->string('currency', 10)->default('XAF');
            
            // Notifications par type
            $table->boolean('notify_new_offers')->default(true);
            $table->boolean('notify_new_demands')->default(true);
            $table->boolean('notify_articles')->default(true);
            $table->boolean('notify_chat_messages')->default(true);
            $table->boolean('notify_admin_alerts')->default(true);
            
            // Canaux de notification
            $table->boolean('email_notifications')->default(true);
            $table->boolean('push_notifications')->default(true);
            $table->boolean('sms_notifications')->default(false);
            
            // Interface
            $table->string('theme')->default('light'); // light, dark, auto
            $table->boolean('compact_view')->default(false);
            $table->boolean('show_tutorials')->default(true);
            
            $table->timestamps();
            
            // Index unique pour s'assurer qu'un utilisateur n'a qu'une préférence
            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_preferences');
    }
};