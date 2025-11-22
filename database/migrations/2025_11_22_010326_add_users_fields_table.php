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
        Schema::table('users', function (Blueprint $table) {
            // Champ pour la dernière connexion
            $table->timestamp('last_login_at')->nullable()->after('updated_at');
            
            // Champs pour la suspension
            $table->timestamp('suspended_at')->nullable()->after('last_login_at');
            $table->foreignId('suspended_by')->nullable()->constrained('users')->after('suspended_at');
            
            // Champs pour la réactivation
            $table->timestamp('reactivated_at')->nullable()->after('suspended_by');
            $table->foreignId('reactivated_by')->nullable()->constrained('users')->after('reactivated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['suspended_by']);
            $table->dropForeign(['reactivated_by']);
            $table->dropColumn([
                'last_login_at',
                'suspended_at',
                'suspended_by',
                'reactivated_at',
                'reactivated_by'
            ]);
        });
    }
};