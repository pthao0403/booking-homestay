<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('CloudStay');
    }

    public function test_rooms_api_returns_a_successful_response(): void
    {
        $response = $this->get('/api/rooms');

        $response->assertOk();
    }
}
