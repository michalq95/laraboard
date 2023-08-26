<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_factory()
    {
        $user = User::factory()->count(1)->make();
        $this->assertNotEmpty($user);
    }
}