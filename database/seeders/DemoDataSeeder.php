<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();

        $categories = collect();

        for ($i = 1; $i <= 10; $i++) {
            $categories->push(
                Category::create([
                    'name'        => 'Category ' . $i,
                    'description' => fake()->paragraph(),
                    'status'      => 'active',
                ])
            );
        }

        for ($i = 1; $i <= 100; $i++) {

            $title = fake()->sentence(6);

            $article = Article::create([
                'title'     => $title,
                'image'     => 'https://picsum.photos/seed/' . Str::slug($title) . '/900/500',
                'content' => collect(fake()->paragraphs(6))
                    ->map(fn($p) => "<p>{$p}</p>")
                    ->implode("\n"),
                'status'    => fake()->randomElement(['draft', 'published']),
                'user_id'   => $user->id,
                'comments_enabled' => fake()->randomElement([true, false]),
            ]);

            $article->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
