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
            ['name' => 'JavaScript', 'accepted' => true],
            ['name' => 'PHP', 'accepted' => true],
            ['name' => 'Junior', 'accepted' => true],
            ['name' => 'Mid', 'accepted' => true],
            ['name' => 'Python', 'accepted' => true],
            ['name' => 'Java', 'accepted' => true],
            ['name' => 'Node', 'accepted' => true],
            ['name' => 'SQL', 'accepted' => true],
            ['name' => 'Docker', 'accepted' => true],
            ['name' => 'Laravel', 'accepted' => true],
        ];



        foreach ($tags as $key => $value) {
            Tag::create($value);
        }


        Offer::factory()->count(50)->create()->each(function ($offer) {
            $tagIds = Tag::inRandomOrder()->limit(3)->pluck('id')->toArray();
            $offer->tags()->sync($tagIds);
        });
    }
}