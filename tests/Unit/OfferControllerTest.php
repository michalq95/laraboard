<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Offer;
use App\Models\Company;
use App\Http\Resources\OfferResource;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithoutEvents;
use Laravel\Sanctum\Sanctum;

class OfferControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
}