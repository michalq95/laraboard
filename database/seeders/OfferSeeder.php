<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            ['name' => 'JavaScript'],
            ['name' => 'PHP'],
            ['name' => 'Junior'],
            ['name' => 'Mid'],
            ['name' => 'Python'],
            ['name' => 'Java'],
            ['name' => 'Node'],
            ['name' => 'SQL'],
            ['name' => 'Docker'],
            ['name' => 'Laravel'],
        ];



        foreach ($tags as $key => $value) {
            Tag::create($value);
        }


        Offer::factory()->count(50)->create()->each(function ($offer) {
            $tagIds = Tag::inRandomOrder()->limit(3)->pluck('id')->toArray();
            $offer->tags()->attach($tagIds);
        });
    }
}