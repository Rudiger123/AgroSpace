<?php

// database/migrations/xxxx_create_message_reads_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('message_reads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('read_at')->useCurrent();

            // Un user lit un message une seule fois
            $table->unique(['message_id', 'user_id']);
            $table->index('read_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_reads');
    }
};
