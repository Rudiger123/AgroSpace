<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('avis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('consumer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('offer_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('note'); // 1 à 5
            $table->text('commentaire')->nullable();
            $table->boolean('is_verified')->default(false); // Achat vérifié
            $table->boolean('is_visible')->default(true);
            $table->timestamp('date_creation')->useCurrent();
            $table->timestamps();

            $table->unique(['producer_id', 'consumer_id', 'offer_id']);
            $table->index(['producer_id', 'is_visible']);
            $table->index('note');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avis');
    }
};
