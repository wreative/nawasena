<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApplicationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_the_application_exact_json_version()
    {
        $response = $this->get('/version');

        $response->assertJsonStructure([
            'App', 'Laravel', 'PHP', 'API'
        ]);
    }
}