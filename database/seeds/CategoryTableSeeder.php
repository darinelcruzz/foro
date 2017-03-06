<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    public function run()
    {
        Category::forceCreate([
            'name' => 'Laravel',
            'slug' => 'laravel',
        ]);

        Category::forceCreate([
            'name' => 'PHP',
            'slug' => 'php',
        ]);

        Category::forceCreate([
            'name' => 'Javascript',
            'slug' => 'javascript',
        ]);

        Category::forceCreate([
            'name' => 'CSS',
            'slug' => 'css',
        ]);

        Category::forceCreate([
            'name' => 'Vue.js',
            'slug' => 'vue-js',
        ]);

        Category::forceCreate([
            'name' => 'Sass',
            'slug' => 'sass',
        ]);

        Category::forceCreate([
            'name' => 'Git',
            'slug' => 'git',
        ]);

        Category::forceCreate([
            'name' => 'Otras tecnologías',
            'slug' => 'otras-tecnologias',
        ]);
    }
}
