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

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return OfferResource::collection(Offer::orderBy('created_at', 'desc')->paginate(25));
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
        // $result = new Offer($request->validated());
        // $result->expire_date = Carbon::now()->addMonth();
        // $result->save();
        $result = Offer::create($request->validated());
        // $tags = explode(',', $request->input('tags'));
        // $tagIds = [];
        // foreach ($tags as $tagName) {
        //     $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
        //     $tagIds[] = $tag->id;
        // }
        // $result->tags()->sync($tagIds);


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
        $offer->update($request->validated());
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