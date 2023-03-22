<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BaseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_users(): void
    {
        $response = $this->getJson('/api/company/');
        $response->assertStatus(401);
    }
}
