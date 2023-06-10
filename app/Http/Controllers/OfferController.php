<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Http\Resources\OfferResource;
use App\Models\Company;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return OfferResource::collection(Offer::orderBy('created_at', 'desc'));
    }

    public function public_index(Request $request)
    {
        $offers = Offer::where('status', 'active')->orderBy('created_at', 'desc')->get();
        // return OfferResource::collection($offers);


        // $offers = Cache::remember('active_offers', 3600, function () {
        //     return Offer::where('status', 'active')->orderBy('created_at', 'desc')->get();
        // });
        return OfferResource::collection($offers);
    }

    public function getCompanyOffers($companyId)
    {
        // $offers = Offer::where('company_id', $companyId)->paginate(25);
        // return OfferResource::collection($offers);
        $offers = Company::find($companyId)->offers()->paginate(25);
        return OfferResource::collection($offers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOfferRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOfferRequest $request)
    {
        $company = Company::where('id', $request->company_id)->first();
        $user = $request->user();

        if ($user->id !== $company->user_id) {
            return abort(403, "Unauthorized");
        }

        $result = Offer::create($request->validated());



        return new OfferResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        return new OfferResource($offer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOfferRequest  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOfferRequest $request, Offer $offer)
    {
        $data = $request->validated();

        $tags = explode(',', request()->input('tags'));
        $tagIds = [];
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
            $tagIds[] = $tag->id;
        }
        $offer->tags()->sync($tagIds);

        $offer->update($data);



        // dump($request->validated());
        return new OfferResource($offer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer, Request $request)
    {
        $user = $request->user();
        if ($user->id !== $offer->user_id) {
            return abort(403, "Unauthorized");
        }
        $offer->delete();
        return response('', 204);
    }
}