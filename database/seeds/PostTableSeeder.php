<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PostTableSeeder extends Seeder
{
    public function run()
    {
        $categories = \App\Category::select('id')->get();
        foreach (range(1, 100) as $i) {
            factory(\App\Post::class)->create([
                'category_id' => $categories->random()->id,
                'created_at' => Carbon::now()->subHours(rand(0, 720)),
            ]);
        }
    }
}
