<?php

// database/migrations/xxxx_create_conversation_user_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('conversation_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('joined_at')->useCurrent();
            $table->timestamp('last_read_at')->nullable();
            $table->timestamps();

            // Un utilisateur ne peut être qu'une fois dans une conversation
            $table->unique(['conversation_id', 'user_id']);

            // Index pour requêtes fréquentes
            $table->index('user_id');
            $table->index('last_read_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversation_user');
    }
};
