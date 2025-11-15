<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Céréales & Grains',
                'icon' => '🌾',
                'color' => '#f59e0b',
                'description' => 'Maïs, riz, mil, sorgho, blé et autres céréales'
            ],
            [
                'name' => 'Légumes & Fruits',
                'icon' => '🥬',
                'color' => '#22c55e',
                'description' => 'Légumes frais, fruits tropicaux et produits maraîchers'
            ],
            [
                'name' => 'Élevage & Volaille',
                'icon' => '🐓',
                'color' => '#ef4444',
                'description' => 'Poulets, œufs, bovins, caprins, ovins'
            ],
            [
                'name' => 'Produits Laitiers',
                'icon' => '🥛',
                'color' => '#3b82f6',
                'description' => 'Lait, fromage, yaourt et dérivés'
            ],
            [
                'name' => 'Tubercules & Racines',
                'icon' => '🥔',
                'color' => '#8b5cf6',
                'description' => 'Manioc, igname, patate douce, pomme de terre'
            ],
            [
                'name' => 'Produits Transformés',
                'icon' => '🏭',
                'color' => '#ec4899',
                'description' => 'Farine, huile, conserves, produits séchés'
            ],
            [
                'name' => 'Épices & Condiments',
                'icon' => '🌶️',
                'color' => '#f97316',
                'description' => 'Piment, gingembre, ail, oignon, épices locales'
            ],
            [
                'name' => 'Matériel Agricole',
                'icon' => '🚜',
                'color' => '#14b8a6',
                'description' => 'Outils, machines, équipements agricoles'
            ],
            [
                'name' => 'Services Agricoles',
                'icon' => '🤝',
                'color' => '#6366f1',
                'description' => 'Labour, transport, conseil, formation'
            ],
            [
                'name' => 'Intrants & Semences',
                'icon' => '🌱',
                'color' => '#10b981',
                'description' => 'Engrais, pesticides, semences certifiées'
            ]
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'icon' => $category['icon'],
                'color' => $category['color'],
                'description' => $category['description'],
                'is_active' => true
            ]);
        }
    }
}
