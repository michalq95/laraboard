<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;


class Offer extends Model
{
    use HasFactory, HasSlug;


    protected $fillable = ['title', 'company_id', 'slug', 'description', 'status', 'bracket_low', 'bracket_high', 'expire_date', 'tags'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom(['id', 'title'])->saveSlugsTo('slug');
    }
}