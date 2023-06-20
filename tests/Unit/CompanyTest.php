<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;
    public function testCompanyCanBeCreated()
    {
        $user = User::factory()->create();

        $company = Company::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(Company::class, $company);
        $this->assertEquals($user->id, $company->user_id);
        $this->assertNotEmpty($company->name);
        $this->assertNotEmpty($company->slug);
        $this->assertEquals('active', $company->status);
        $this->assertNotEmpty($company->description);
        $this->assertEquals('Warszawa', $company->address);
        $this->assertNotNull($company->loc_x);
        $this->assertNotNull($company->loc_y);
    }
}