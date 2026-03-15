<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\BlogPost;
use App\Models\Home;
use App\Models\Project;
use App\Models\Service;
use App\Models\Stat;
use App\Models\User;
use Database\Seeders\PageContentSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        Home::updateOrCreate(
            ['order' => 1],
            [
                'image' => 'home/01KJXF3QFCB3YC63K1SVE8HH5S.jpg',
                'h1' => 'Build faster.',
                'h2' => 'Grow smarter.',
                'body' => 'We design digital products with clear goals and clean execution.',
                'btn_text' => 'Start a project',
                'btn_link' => '/contact',
            ]
        );

        Home::updateOrCreate(
            ['order' => 2],
            [
                'image' => 'home/01KJXF4S8FMT3A0ST5D9623E5N.jpg',
                'h1' => 'Ideas to impact.',
                'h2' => 'Results that last.',
                'body' => 'From concept to launch, we keep every step focused and simple.',
                'btn_text' => 'View portfolio',
                'btn_link' => '/portfolio',
            ]
        );

        Service::updateOrCreate(
            ['order' => 1],
            [
                'icon' => 'fa fa-code',
                'title' => 'Web Development',
                'description' => 'Modern websites that are fast, stable, and easy to manage.',
                'image' => 'services/01KJXEP091J88BH9C9C1G3THSJ.jpg',
                'url' => '/portfolio',
            ]
        );

        Service::updateOrCreate(
            ['order' => 2],
            [
                'icon' => 'fa fa-mobile',
                'title' => 'App Development',
                'description' => 'Useful mobile apps built around real user needs.',
                'image' => 'services/01KJXEQ2B9Y82GF5CRGTMZA2H1.jpg',
                'url' => '/portfolio',
            ]
        );

        Stat::updateOrCreate(
            ['order' => 1],
            ['icon' => 'fa fa-briefcase', 'number' => '25', 'label' => 'Projects Delivered']
        );

        Stat::updateOrCreate(
            ['order' => 2],
            ['icon' => 'fa fa-users', 'number' => '40', 'label' => 'Happy Clients']
        );

        Stat::updateOrCreate(
            ['order' => 3],
            ['icon' => 'fa fa-star', 'number' => '5', 'label' => 'Years Experience']
        );

        Stat::updateOrCreate(
            ['order' => 4],
            ['icon' => 'fa fa-globe', 'number' => '8', 'label' => 'Countries Reached']
        );

        About::updateOrCreate(
            ['id' => 1],
            [
                'heading1' => 'Who we are',
                'heading2' => 'A small team with big focus.',
                'description' => 'We create digital work that is clear, useful, and built for growth.',
                'image1' => 'about/01KJXFXRGWHR0ZYV89EVV9PGYP.jpg',
                'image2' => 'images/media/1694258162web.jpg',
                'image3' => 'images/media/1632921978quin-service-webdesign1.webp',
                'features' => [
                    'Simple communication.',
                    'Clean delivery process.',
                    'Strong long-term support.',
                ],
            ]
        );

        Project::updateOrCreate(
            ['slug' => 'startup-web-platform'],
            [
                'title' => 'Startup Web Platform',
                'image_path' => 'projects/01KJN7SEC9JGFSVSW03XKMX2XK.png',
                'category' => 'Web',
                'description' => 'A fast website for product launch and lead growth.',
            ]
        );

        Project::updateOrCreate(
            ['slug' => 'booking-mobile-app'],
            [
                'title' => 'Booking Mobile App',
                'image_path' => 'projects/01KJNGCER9EJSM9YZ4JS1BTJPK.jpg',
                'category' => 'App',
                'description' => 'A clean booking flow with quick confirmations.',
            ]
        );

        Project::updateOrCreate(
            ['slug' => 'smart-support-chatbot'],
            [
                'title' => 'Smart Support Chatbot',
                'image_path' => 'projects/01KJWC6S9XWHVW4VV75VXT5YJE.png',
                'category' => 'Chatbot',
                'description' => 'An assistant that answers common questions in seconds.',
            ]
        );

        BlogPost::updateOrCreate(
            ['slug' => 'why-simple-websites-win'],
            [
                'title' => 'Why Simple Websites Win',
                'image' => 'blog/01KJXESC2GPY3PJ2Q0AQYKY5H5.jpg',
                'excerpt' => 'Simple pages load faster and convert better.',
                'date' => now()->toDateString(),
                'content' => 'Keep layouts clear. Keep calls to action direct. Keep loading speed high.',
            ]
        );

        $this->call(PageContentSeeder::class);
    }
}
