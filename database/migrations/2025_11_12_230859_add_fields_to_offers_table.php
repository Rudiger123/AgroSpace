<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            // Champs de validation
            $table->timestamp('date_validation')->nullable()->after('statut');
            $table->foreignId('validated_by')->nullable()->constrained('users')->nullOnDelete()->after('date_validation');
            $table->text('validation_note')->nullable()->after('validated_by');
            
            // Champs de rejet
            $table->timestamp('date_rejection')->nullable()->after('validation_note');
            $table->foreignId('rejected_by')->nullable()->constrained('users')->nullOnDelete()->after('date_rejection');
            $table->text('rejection_reason')->nullable()->after('rejected_by');
            
            // Index pour améliorer les performances
            $table->index('validated_by');
            $table->index('rejected_by');
        });
    }

    public function down(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropForeign(['validated_by']);
            $table->dropForeign(['rejected_by']);
            
            $table->dropIndex(['statut', 'date_publication']);
            $table->dropIndex(['validated_by']);
            $table->dropIndex(['rejected_by']);
            
            $table->dropColumn([
                'date_validation',
                'validated_by',
                'validation_note',
                'date_rejection',
                'rejected_by',
                'rejection_reason',
            ]);
        });
    }
};