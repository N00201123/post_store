<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::factory()
        ->times(3)
        ->create();

        foreach(Tag::all() as $tag) 
        {
            $posts = Post::inRandomOrder()->take(rand(1,3))->pluck('id');
            $tag->posts()->attach($posts);
        }
    }
}
