<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\OfferResource;
use App\Models\Company;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class OfferController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum')->only('show');
    // }

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
        $keywords = $request->input('keyword');
        $query = Offer::with(["company", "tags"])
            ->where('status', 'active')
            ->orderBy('created_at', 'desc');

        if (!empty($keywords)) {
            $keywords = explode(" ", $keywords);
            $query->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->where('title', 'LIKE', "%$keyword%")
                        ->orWhereHas('tags', function ($query) use ($keyword) {
                            $query->where('name', 'LIKE', "%$keyword%");
                        });
                }
            });
            $offers = $query->get();
        } else {
            $offers = Cache::remember('offers', 60 * 60 * 24, function () use ($query) {
                return $query->get();
            });
        }
        return OfferResource::collection($offers);
    }

    public function getCompanyOffers($companyId)
    {
        if (auth('sanctum')?->user()?->company?->id == $companyId) {
            $offers = Offer::with(['company', 'tags'])->where('company_id', $companyId)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $offers = Offer::with(['company', 'tags'])->where('company_id', $companyId)
                ->where('status', 'active')->orderBy('created_at', 'desc')
                ->get();
        }
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
    public function show(Request $request, Offer $offer)
    {

        $application = null;
        if (auth('sanctum')->user()) {
            $application = $offer->getApplicationForUser(auth('sanctum')->user()->id);
        }
        return (new OfferResource($offer))->additional([
            'application' => $application ? new ApplicationResource($application) : null,
        ]);
    }

    public function showBySlug(Request $request, Offer $offer)
    {

        $application = null;
        if (auth('sanctum')->user()) {
            $application = $offer->getApplicationForUser(auth('sanctum')->user()->id);
        }
        return (new OfferResource($offer))->additional([
            'application' => $application ? new ApplicationResource($application) : null,
        ]);
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
        $company_id = $request->user()->company->id;
        if ($offer->company_id != $company_id) {
            return abort(403, "Unauthorized");
        }

        $data = $request->validated();

        $tags = explode(',', request()->input('tags'));
        $tagIds = [];
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
            $tagIds[] = $tag->id;
        }
        $offer->tags()->sync($tagIds);
        $offer->update($data);

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