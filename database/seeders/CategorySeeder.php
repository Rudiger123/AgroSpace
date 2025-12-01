<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Catégories pour les ARTICLES DE BLOG (posts)
        $postCategories = [
            [
                'name' => 'Conseils Techniques',
                'slug' => 'conseils-techniques',
                'icon' => '📚',
                'color' => '#10B981',
                'description' => 'Conseils et astuces pour améliorer vos pratiques agricoles',
                'type' => 'post',
                'is_active' => true,
            ],
            [
                'name' => 'Innovations',
                'slug' => 'innovations',
                'icon' => '🚀',
                'color' => '#3B82F6',
                'description' => 'Les dernières innovations technologiques dans l\'agriculture',
                'type' => 'post',
                'is_active' => true,
            ],
            [
                'name' => 'Marché Agricole',
                'slug' => 'marche-agricole',
                'icon' => '📊',
                'color' => '#F59E0B',
                'description' => 'Analyse du marché et tendances économiques',
                'type' => 'post',
                'is_active' => true,
            ],
            [
                'name' => 'Durabilité',
                'slug' => 'durabilite',
                'icon' => '🌍',
                'color' => '#059669',
                'description' => 'Pratiques durables et agriculture responsable',
                'type' => 'post',
                'is_active' => true,
            ],
            [
                'name' => 'Météo & Climat',
                'slug' => 'meteo-climat',
                'icon' => '⛅',
                'color' => '#0EA5E9',
                'description' => 'Impact du climat sur l\'agriculture et prévisions',
                'type' => 'post',
                'is_active' => true,
            ],
            [
                'name' => 'Success Stories',
                'slug' => 'success-stories',
                'icon' => '🏆',
                'color' => '#EC4899',
                'description' => 'Témoignages et réussites d\'agriculteurs',
                'type' => 'post',
                'is_active' => true,
            ],
            [
                'name' => 'Formations & Événements',
                'slug' => 'formations-evenements',
                'icon' => '🎓',
                'color' => '#8B5CF6',
                'description' => 'Formations, ateliers et événements agricoles',
                'type' => 'post',
                'is_active' => true,
            ],
            [
                'name' => 'Santé & Nutrition',
                'slug' => 'sante-nutrition',
                'icon' => '🍎',
                'color' => '#EF4444',
                'description' => 'Qualité nutritionnelle et santé des produits agricoles',
                'type' => 'post',
                'is_active' => true,
            ],
        ];

        // Catégories pour les OFFRES (offers)
        $offerCategories = [
            [
                'name' => 'Céréales & Grains',
                'icon' => '🌾',
                'color' => '#f59e0b',
                'description' => 'Maïs, riz, mil, sorgho, blé et autres céréales',
                'type' => 'offer',
                'is_active' => true,
            ],
            [
                'name' => 'Légumes & Fruits',
                'icon' => '🥬',
                'color' => '#22c55e',
                'description' => 'Légumes frais, fruits tropicaux et produits maraîchers',
                'type' => 'offer',
                'is_active' => true,
            ],
            [
                'name' => 'Élevage & Volaille',
                'icon' => '🐓',
                'color' => '#ef4444',
                'description' => 'Poulets, œufs, bovins, caprins, ovins',
                'type' => 'offer',
                'is_active' => true,
            ],
            [
                'name' => 'Produits Laitiers',
                'icon' => '🥛',
                'color' => '#3b82f6',
                'description' => 'Lait, fromage, yaourt et dérivés',
                'type' => 'offer',
                'is_active' => true,
            ],
            [
                'name' => 'Tubercules & Racines',
                'icon' => '🥔',
                'color' => '#8b5cf6',
                'description' => 'Manioc, igname, patate douce, pomme de terre',
                'type' => 'offer',
                'is_active' => true,
            ],
            [
                'name' => 'Produits Transformés',
                'icon' => '🏭',
                'color' => '#ec4899',
                'description' => 'Farine, huile, conserves, produits séchés',
                'type' => 'offer',
                'is_active' => true,
            ],
            [
                'name' => 'Épices & Condiments',
                'icon' => '🌶️',
                'color' => '#f97316',
                'description' => 'Piment, gingembre, ail, oignon, épices locales',
                'type' => 'offer',
                'is_active' => true,
            ],
            [
                'name' => 'Miel & Apiculture',
                'icon' => '🍯',
                'color' => '#d97706',
                'description' => 'Miel, propolis, cire et produits apicoles',
                'type' => 'offer',
                'is_active' => true,
            ],
            [
                'name' => 'Poissons & Aquaculture',
                'icon' => '🐟',
                'color' => '#0ea5e9',
                'description' => 'Poissons d\'élevage et produits de la pêche',
                'type' => 'offer',
                'is_active' => true,
            ],
            [
                'name' => 'Semences & Plants',
                'icon' => '🌱',
                'color' => '#10b981',
                'description' => 'Semences certifiées, plants, boutures',
                'type' => 'offer',
                'is_active' => true,
            ],
            [
                'name' => 'Services Agricoles',
                'icon' => '🤝',
                'color' => '#6366f1',
                'description' => 'Labour, transport, conseil, formation',
                'type' => 'offer',
                'is_active' => true,
            ],
            [
                'name' => 'Matériel Agricole',
                'icon' => '🚜',
                'color' => '#14b8a6',
                'description' => 'Outils, machines, équipements agricoles à vendre',
                'type' => 'offer',
                'is_active' => true,
            ],
        ];

        // Catégories pour les DEMANDES (demands)
        $demandCategories = [
            [
                'name' => 'Céréales Recherchées',
                'icon' => '🌾',
                'color' => '#fbbf24',
                'description' => 'Demandes de céréales et grains',
                'type' => 'demand',
                'is_active' => true,
            ],
            [
                'name' => 'Fruits & Légumes',
                'icon' => '🥦',
                'color' => '#34d399',
                'description' => 'Demandes de fruits et légumes frais',
                'type' => 'demand',
                'is_active' => true,
            ],
            [
                'name' => 'Viandes & Volaille',
                'icon' => '🍗',
                'color' => '#f87171',
                'description' => 'Demandes de viande, poulet et œufs',
                'type' => 'demand',
                'is_active' => true,
            ],
            [
                'name' => 'Produits Laitiers',
                'icon' => '🧀',
                'color' => '#60a5fa',
                'description' => 'Demandes de lait, fromage et produits laitiers',
                'type' => 'demand',
                'is_active' => true,
            ],
            [
                'name' => 'Tubercules & Racines',
                'icon' => '🍠',
                'color' => '#a78bfa',
                'description' => 'Demandes de manioc, igname, patate douce',
                'type' => 'demand',
                'is_active' => true,
            ],
            [
                'name' => 'Équipements Agricoles',
                'icon' => '⚙️',
                'color' => '#06b6d4',
                'description' => 'Demandes d\'équipements et machines agricoles',
                'type' => 'demand',
                'is_active' => true,
            ],
            [
                'name' => 'Intrants & Engrais',
                'icon' => '🧪',
                'color' => '#10b981',
                'description' => 'Demandes d\'engrais, pesticides et intrants',
                'type' => 'demand',
                'is_active' => true,
            ],
            [
                'name' => 'Services Recherchés',
                'icon' => '🛠️',
                'color' => '#8b5cf6',
                'description' => 'Demandes de services agricoles',
                'type' => 'demand',
                'is_active' => true,
            ],
            [
                'name' => 'Produits Bio',
                'icon' => '🍃',
                'color' => '#22c55e',
                'description' => 'Demandes spécifiques de produits biologiques',
                'type' => 'demand',
                'is_active' => true,
            ],
            [
                'name' => 'Restauration & Hôtellerie',
                'icon' => '🏨',
                'color' => '#ec4899',
                'description' => 'Demandes des restaurants et hôtels',
                'type' => 'demand',
                'is_active' => true,
            ],
            [
                'name' => 'Transformation',
                'icon' => '🏭',
                'color' => '#f97316',
                'description' => 'Demandes de matières premières pour transformation',
                'type' => 'demand',
                'is_active' => true,
            ],
            [
                'name' => 'Exportation',
                'icon' => '📦',
                'color' => '#3b82f6',
                'description' => 'Demandes pour exportation à l\'international',
                'type' => 'demand',
                'is_active' => true,
            ],
        ];

        // Combiner toutes les catégories
        $allCategories = array_merge($postCategories, $offerCategories, $demandCategories);

        foreach ($allCategories as $category) {
            // Vérifier si le slug existe déjà
            $existingCategory = Category::where('slug', $category['slug'] ?? Str::slug($category['name']))->first();
            
            if (!$existingCategory) {
                Category::create([
                    'name' => $category['name'],
                    'slug' => $category['slug'] ?? Str::slug($category['name']),
                    'icon' => $category['icon'],
                    'color' => $category['color'],
                    'description' => $category['description'],
                    'type' => $category['type'],
                    'is_active' => $category['is_active'],
                ]);
            }
        }

        $this->command->info(sprintf(
            '✅ %d catégories créées : %d posts, %d offres, %d demandes',
            count($allCategories),
            count($postCategories),
            count($offerCategories),
            count($demandCategories)
        ));
    }
}