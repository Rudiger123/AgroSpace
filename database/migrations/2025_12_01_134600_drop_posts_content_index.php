<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Vérifier si nous sommes sur PostgreSQL
        if (DB::connection()->getDriverName() === 'pgsql') {
            // Supprimer l'index problématique sur la colonne content
            DB::statement('DROP INDEX IF EXISTS posts_content_index');
            
            // Optionnel: Si vous avez d'autres index similaires
            DB::statement('DROP INDEX IF EXISTS posts_content_gin_idx');
            DB::statement('DROP INDEX IF EXISTS posts_excerpt_index');
            
            // Pour éviter tout problème avec excerpt aussi (car c'est un text)
            DB::statement('DROP INDEX IF EXISTS posts_excerpt_idx');
        }
        
        // Pour MySQL (si applicable)
        if (DB::connection()->getDriverName() === 'mysql') {
            Schema::table('posts', function ($table) {
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $indexes = $sm->listTableIndexes('posts');
                
                // Supprimer les index sur content et excerpt
                foreach (['content', 'excerpt'] as $column) {
                    $indexName = "posts_{$column}_index";
                    if (array_key_exists($indexName, $indexes)) {
                        $table->dropIndex($indexName);
                    }
                }
            });
        }
    }

    public function down(): void
    {
        // En cas de rollback, nous ne recréons PAS les index 
        // car ils causent des problèmes
        // $this->down() peut rester vide ou log un warning
    }
};