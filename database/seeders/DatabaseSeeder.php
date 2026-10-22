<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory(2)->create();

        $this->call([
            CategorySeeder::class,
            TagSeeder::class,
        ]);
        $users = User::all();
        $categories = Category::all();
        $tags = Tag::all();

        $authorAndCategory = fn (array $attributes) => [
            'user_id' => $users->random()->id,
            'category_id' => $categories->random()->id,
        ];

        Post::factory(9)->published()->state($authorAndCategory)->create();
        Post::factory(3)->state($authorAndCategory)->create();

        Post::all()->each(function (Post $post) use ($tags) {
            $post->tags()->attach($tags->random(2));
        });
    }
}