<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->string('color')->default('#22c55e');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('demands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('quantity')->nullable();
            $table->string('city');
            $table->enum('region', [
                'Adamaoua', 'Centre', 'Est', 'Extrême-Nord',
                'Littoral', 'Nord', 'Nord-Ouest', 'Ouest',
                'Sud', 'Sud-Ouest'
            ]);
            $table->date('validity_date');
            $table->decimal('budget', 12, 2)->nullable();
            $table->enum('urgency', ['low', 'medium', 'high'])->default('medium');
            $table->enum('status', ['active', 'satisfied', 'expired', 'cancelled'])->default('active');
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('contacts_received')->default(0);
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'validity_date']);
            $table->index('category_id');
            $table->index('region');
        });

        Schema::create('demand_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('demand_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('message');
            $table->decimal('proposed_price', 12, 2)->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demand_responses');
        Schema::dropIfExists('demands');
        Schema::dropIfExists('categories');
    }
};