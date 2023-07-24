<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OfferTest extends TestCase
{
    use RefreshDatabase;
    public function testOfferCanBeCreated()
    {

        $user = User::factory()->create();
        $company = Company::factory()->create([
            'user_id' => $user->id,
        ]);

        $offer = Offer::factory()->create([
            'company_id' => $company->id,
        ]);

        $this->assertInstanceOf(Offer::class, $offer);
        $this->assertEquals("active", $offer->status);
    }
}