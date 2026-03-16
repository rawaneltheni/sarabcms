<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\BlogPost;
use App\Models\ChatSession;
use App\Models\Home;
use App\Models\Project;
use App\Models\Service;
use App\Models\Stat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::where('email', 'sarab@gmail.com')->delete();

        User::create([
            'name' => 'Sarab',
            'email' => 'sarab@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        if (! Home::query()->exists()) {
            Home::create([
                'order' => 1,
                'h1' => 'Welcome to Sarab Tech',
                'h2' => 'Build with confidence',
                'body' => 'This is example homepage slider content seeded for Filament.',
                'btn_text' => 'Contact us',
                'btn_link' => '/contact',
            ]);
        }

        if (! Service::query()->exists()) {
            Service::create([
                'order' => 1,
                'icon' => 'fa fa-code',
                'title' => 'Example Service',
                'description' => 'This is example service content. You can edit it in Filament.',
                'url' => '/portfolio',
            ]);
        }

        if (! Stat::query()->exists()) {
            Stat::create([
                'order' => 1,
                'icon' => 'fa fa-chart-line',
                'number' => '10',
                'label' => 'Example Projects',
            ]);
        }

        if (! About::query()->exists()) {
            About::create([
                'heading1' => 'About Sarab',
                'heading2' => 'Example about heading',
                'description' => 'This is example about content seeded for the Filament panel.',
                'features' => [
                    'Example feature one',
                    'Example feature two',
                ],
            ]);
        }

        if (! Project::query()->exists()) {
            Project::create([
                'title' => 'Example Project',
                'slug' => 'example-project',
                'category' => 'Web',
                'description' => 'This is example project content managed from Filament.',
            ]);
        }

        if (! BlogPost::query()->exists()) {
            BlogPost::create([
                'title' => 'Example Blog Post',
                'slug' => 'example-blog-post',
                'excerpt' => 'Short example excerpt for seeded blog post.',
                'date' => now()->toDateString(),
                'content' => 'This is example blog content. You can replace it from Filament.',
            ]);
        }

        if (! ChatSession::query()->exists()) {
            ChatSession::create([
                'session_id' => (string) Str::uuid(),
                'language' => 'en',
                'messages_count' => 1,
                'started_at' => now(),
                'last_message_at' => now(),
                'first_page_url' => '/',
                'last_page_url' => '/',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Seeder',
            ]);
        }
    }
}
