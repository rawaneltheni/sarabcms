<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Stat;
use App\Models\Home;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Home::orderBy('order')->get();
        $services = Service::orderBy('order')->get();
        $stats = Stat::orderBy('order')->get();
        $about = About::first();

        return view('home', compact('slides', 'services', 'stats', 'about'));
    }
}
