<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Company extends Model
{
    use HasFactory, HasSlug;

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function applications(): HasManyThrough
    {
        return $this->hasManyThrough(Application::class, Offer::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('name')->saveSlugsTo('slug');
    }

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'status',
        'email',
        'description',
        'address',
        'loc_x',
        'loc_y',
        'image'
    ];
}