<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = ['name', 'accepted'];
    public $timestamps = false;

    public function offers(): BelongsToMany
    {
        return $this->belongsToMany(Offer::class);
    }
}
