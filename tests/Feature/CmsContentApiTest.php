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
            ->assertJsonPath('data.0.h1', 'SARAB')
            ->assertJsonPath('data.0.h2', 'TECH')
            ->assertJsonPath('data.0.body', 'Shaping your digital success story together.')
            ->assertJsonPath('data.0.btn_text', 'Contact Us')
            ->assertJsonPath('data.0.btn_link', '/contact');
    }

    public function test_customers_endpoint_returns_ordered_customers_with_new_fields(): void
    {
        $response = $this->getJson('/api/customers');

        $response
            ->assertOk()
            ->assertJsonPath('data.0.name', 'Sarab Client One')
            ->assertJsonPath('data.0.order', 1)
            ->assertJsonPath('data.1.name', 'Sarab Client Two')
            ->assertJsonPath('data.1.order', 2)
            ->assertJsonPath('data.2.name', 'Sarab Client Three')
            ->assertJsonPath('data.2.order', 3);
    }
}
