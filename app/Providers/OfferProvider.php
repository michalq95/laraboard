<?php

namespace App\Providers;

use App\Models\Offer;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class OfferProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Offer::creating(function ($offer) {
            if (Auth::check()) {
                $offer->expire_date = Carbon::now()->addMonth();
                $offer->company_id = Auth::user()->company->id;
            }
        });

        Offer::created((function ($offer) {


            $tags = explode(',', request()->input('tags'));
            $tagIds = [];
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
                $tagIds[] = $tag->id;
            }
            $offer->tags()->sync($tagIds);
        }));

        Offer::updating(function ($offer) {
            if (Auth::check()) {
                $offer->expire_date = Carbon::now()->addMonth();
                $offer->company_id = Auth::user()->company->id;
            }
        });

        // Offer::updated(function ($offer) {

        // });
    }
}