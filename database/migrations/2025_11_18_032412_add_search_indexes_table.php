<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add indexes for better search performance
        
        // Posts table
        Schema::table('posts', function (Blueprint $table) {
            $table->index(['title', 'published', 'created_at']);
            $table->index('content'); // For full-text search
        });

        // Offers table
        Schema::table('offers', function (Blueprint $table) {
            $table->index(['titre', 'statut', 'created_at']);
            $table->index('description');
        });

        // Demands table
        Schema::table('demands', function (Blueprint $table) {
            $table->index(['title', 'status', 'created_at']);
            $table->index('description');
        });

        // Categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->index(['name', 'is_active']);
        });

        // Users table
        Schema::table('users', function (Blueprint $table) {
            $table->index(['name', 'email', 'status']);
        });

        // Comments table
        Schema::table('comments', function (Blueprint $table) {
            $table->index(['content', 'status', 'created_at']);
        });

        // Newsletter subscribers table
        Schema::table('newsletter_subscribers', function (Blueprint $table) {
            $table->index(['email', 'name', 'unsubscribed_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['title', 'published', 'created_at']);
            $table->dropIndex(['content']);
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->dropIndex(['titre', 'statut', 'created_at']);
            $table->dropIndex(['description']);
        });

        Schema::table('demands', function (Blueprint $table) {
            $table->dropIndex(['title', 'status', 'created_at']);
            $table->dropIndex(['description']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['name', 'is_active']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['name', 'email', 'status']);
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex(['content', 'status', 'created_at']);
        });

        Schema::table('newsletter_subscribers', function (Blueprint $table) {
            $table->dropIndex(['email', 'name', 'unsubscribed_at']);
        });
    }
};