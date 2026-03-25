<?php

namespace Tests\Feature;

use App\Models\User;
use Filament\Auth\Pages\Login;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentLoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        Filament::setCurrentPanel(Filament::getPanel('sarab'));
        Filament::bootCurrentPanel();
    }

    public function test_filament_login_page_loads(): void
    {
        $this->get('/sarab/login')->assertOk();
    }

    public function test_seeded_filament_admin_can_log_in(): void
    {
        $user = User::where('email', 'sarab@gmail.com')->firstOrFail();

        Livewire::test(Login::class)
            ->set('data.email', 'sarab@gmail.com')
            ->set('data.password', '123456')
            ->call('authenticate')
            ->assertHasNoErrors()
            ->assertRedirect(Filament::getUrl());

        $this->assertAuthenticatedAs($user);
    }

    public function test_authenticated_filament_admin_can_access_cms_pages(): void
    {
        $user = User::where('email', 'sarab@gmail.com')->firstOrFail();

        $this->actingAs($user);

        $this->get('/sarab')->assertRedirect('/sarab/homes');
        $this->get('/sarab/homes')->assertOk();
        $this->get('/sarab/projects')->assertOk();
        $this->get('/sarab/services')->assertOk();
        $this->get('/sarab/abouts')->assertOk();
        $this->get('/sarab/stats')->assertOk();
        $this->get('/sarab/blog-posts')->assertOk();
        $this->get('/sarab/customers')->assertOk();
    }
}
