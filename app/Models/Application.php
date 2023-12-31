<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = ["application", "resume", "offer_id", "user_id", "status"];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}