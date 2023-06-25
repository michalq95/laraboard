<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Providers\OfferProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Offer extends Model
{
    use HasFactory, HasSlug;


    protected $fillable = ['title', 'company_id', 'slug', 'description', 'status', 'bracket_low', 'bracket_high', 'currency', 'expire_date', 'icon'];

    protected $dates = ['expire_date', 'created_at', 'updated_at'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function getApplicationForUser($userId)
    {
        return $this->applications()->where('user_id', $userId)->first();
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom(['id', 'title'])->saveSlugsTo('slug');
    }
}