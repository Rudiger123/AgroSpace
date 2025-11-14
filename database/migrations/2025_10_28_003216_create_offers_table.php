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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producer_id')->constrained('users')->onDelete('cascade');
            $table->string('titre');
            $table->text('description');
            $table->decimal('prix', 10, 2);
            $table->integer('quantite');
            $table->string('unite'); // kg, tonne, sac, pièce
            $table->string('localisation');
            $table->string('region')->nullable();
            $table->string('ville')->nullable();
            $table->timestamp('date_publication');
            $table->timestamp('date_expiration')->nullable();
            $table->enum('statut', ['validé', 'expirée', 'vendue', 'suspendue', 'en attente', 'rejeté'])->default('en attente');
            $table->boolean('is_published')->default('true');
            $table->text('conditions_livraison')->nullable();
            $table->string('contact')->nullable();
            $table->integer('views_count')->default(0);
            $table->integer('contacts_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['statut', 'date_publication']);
            $table->index('producer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
