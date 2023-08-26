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

    public function it_fetches_active_offers_with_keywords()
    {
        $offer1 = Offer::factory()->make(['title' => 'Keyword Offer']);
        $offer2 = Offer::factory()->make(['title' => 'Another Offer']);

        // Mock the Offer model to return the mock offers
        $this->mock(Offer::class, function ($mock) use ($offer1, $offer2) {
            $mock->shouldReceive('with')->andReturnSelf();
            $mock->shouldReceive('where')->andReturnSelf();
            $mock->shouldReceive('orderBy')->andReturnSelf();
            $mock->shouldReceive('get')->andReturn(collect([$offer1]));
        });

        $response = $this->get('/api/offer?keyword=Keyword');
        dump($response);
        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => 'Keyword Offer']);
        $response->assertJsonMissing(['title' => 'Another Offer']);
    }

    /** @test */
    public function it_fetches_active_offers_without_keywords()
    {
        $offers = Offer::factory()->count(5)->create();

        $response = $this->get('/api/offer');

        $response->assertStatus(200);
        $response->assertJsonCount($offers->count(), 'data');
    }
}