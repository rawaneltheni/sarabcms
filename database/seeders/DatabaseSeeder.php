<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\BlogPost;
use App\Models\ChatSession;
use App\Models\Customer;
use App\Models\Home;
use App\Models\Project;
use App\Models\Service;
use App\Models\Stat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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

        DB::table('home_sliders')->delete();
        DB::table('services')->delete();
        DB::table('stats')->delete();
        DB::table('abouts')->delete();
        DB::table('projects')->delete();
        DB::table('blog_posts')->delete();
        DB::table('customers')->delete();

        About::create([
            'heading1' => 'Empowering Your',
            'heading2' => 'Success Journey.',
            'description' => 'Enhance your online presence with Sarab. Specializing in web and app development, we create seamless, innovative solutions to shape your digital success story together.',
            'features' => [
                'Our expert team creates visually captivating and highly functional websites that make a lasting impact.',
                'We develop cutting-edge mobile apps that deliver seamless experiences and cater to your specific needs.',
                'Our top priority is exceptional customer service, ensuring your satisfaction every step of the way.',
            ],
        ]);

        Service::insert([
            [
                'order' => 1,
                'icon' => 'fa fa-code',
                'title' => 'Web Development',
                'description' => 'Visually captivating and highly functional websites.',
                'image' => null,
                'url' => '/portfolio',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order' => 2,
                'icon' => 'fa fa-mobile-screen',
                'title' => 'App Development',
                'description' => 'Cutting-edge mobile apps that deliver seamless experiences.',
                'image' => null,
                'url' => '/portfolio',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order' => 3,
                'icon' => 'fa fa-comments',
                'title' => 'Chatbot Systems',
                'description' => 'Intelligent conversational agents like rodood.ly.',
                'image' => null,
                'url' => '/portfolio',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Stat::insert([
            [
                'order' => 1,
                'icon' => 'fa fa-users',
                'number' => '0',
                'label' => 'Happy Customers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order' => 2,
                'icon' => 'fa fa-graduation-cap',
                'number' => '0',
                'label' => 'Trainees',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order' => 3,
                'icon' => 'fa fa-chart-line',
                'number' => '0',
                'label' => 'Service Users',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order' => 4,
                'icon' => 'fa fa-folder-open',
                'number' => '0',
                'label' => 'Great Projects',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Project::insert([
            [
                'image_path' => null,
                'title' => 'E-Commerce Platform',
                'slug' => 'e-commerce-platform',
                'category' => 'Web',
                'description' => 'A full-featured e-commerce platform with real-time inventory management, seamless payment gateway integration, and a responsive, mobile-first design.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image_path' => null,
                'title' => 'rodood.ly Chatbot',
                'slug' => 'rodood-ly-chatbot',
                'category' => 'Chatbot',
                'description' => 'An intelligent conversational agent designed to automate customer support, handle inquiries 24/7, and integrate seamlessly with existing CRM systems.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image_path' => null,
                'title' => 'Healthcare App',
                'slug' => 'healthcare-app',
                'category' => 'App',
                'description' => 'A secure and intuitive mobile application for patients to book appointments, access medical records, and consult with doctors via telemedicine.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image_path' => null,
                'title' => 'Fintech Dashboard',
                'slug' => 'fintech-dashboard',
                'category' => 'Web',
                'description' => 'A comprehensive financial dashboard providing real-time analytics, transaction monitoring, and customizable reporting for enterprise clients.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

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
