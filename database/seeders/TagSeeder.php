<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        Tag::factory()->createMany([
            ['name' => 'Débutant', 'slug' => 'debutant'],
            ['name' => 'Astuce', 'slug' => 'astuce'],
            ['name' => 'Sécurité', 'slug' => 'securite'],
            ['name' => 'Performance', 'slug' => 'performance'],
            ['name' => 'Tests', 'slug' => 'tests'],
            ['name' => 'Blade', 'slug' => 'blade'],
        ]);
    }
}