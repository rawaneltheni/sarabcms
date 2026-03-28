<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CmsContentApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_homes_endpoint_returns_seeded_home_content(): void
    {
        $response = $this->getJson('/api/homes');

        $response
            ->assertOk()
            ->assertJsonPath('data.0.h1', 'Seeking')
            ->assertJsonPath('data.0.h2', 'digital solutions?')
            ->assertJsonPath('data.0.body', 'Are you looking for Digital Transformation, sarab is a Tech Company Established with one purpose: to help you define your brand. We offer impeccable service combining a nice and user-friendly designs with quality programming.')
            ->assertJsonPath('data.0.btn_text', 'Get in touch')
            ->assertJsonPath('data.0.btn_link', '/contact');
    }

    public function test_customers_endpoint_returns_an_empty_collection_when_no_customers_are_seeded(): void
    {
        $response = $this->getJson('/api/customers');

        $response
            ->assertOk()
            ->assertExactJson([
                'data' => [],
            ]);
    }
}
