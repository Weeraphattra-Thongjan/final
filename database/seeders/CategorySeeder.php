<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'ทั่วไป', 'slug' => 'general'],
            ['name' => 'ความรัก', 'slug' => 'love'],
            ['name' => 'อาหาร', 'slug' => 'food'],
            ['name' => 'ความงาม', 'slug' => 'beauty'],
            ['name' => 'เทคโนโลยี', 'slug' => 'technology'],
            ['name' => 'สุขภาพ', 'slug' => 'health'],
            ['name' => 'การเรียน', 'slug' => 'study'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
