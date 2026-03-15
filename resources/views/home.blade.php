@extends('layouts.app')

@section('title', 'Home')

@section('content')
<style>

.slider-venor-section {
    position: relative;
    height: 100vh;
    min-height: 800px;
    overflow: hidden;
}

.slider-venor {
    height: 100%;
}

.slider-inner-venor {
    position: relative;
    height: 100vh;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
}

.slider-content {
    max-width: 800px;
    color: white;
    z-index: 2;
    position: relative;
}

.slider-content h1 {
    font-size: 4.5rem;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 1rem;
    letter-spacing: -0.02em;
}

.slider-content h1.active {
    animation: fadeInUp 1s ease-out;
}

.slider-content h2 {
    font-size: 3.5rem;
    font-weight: 700;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.slider-content h2.active {
    animation: fadeInUp 1s ease-out 0.2s both;
}

.slider-body {
    font-size: 1.3rem;
    line-height: 1.6;
    max-width: 600px;
    margin-bottom: 3rem;
    opacity: 0;
}

.slider-body.active {
    animation: fadeInUp 1s ease-out 0.4s both;
}

.button-slider-b {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn-slider {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(45deg, #f59e0b, #fbbf24);
    color: white;
    padding: 1rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(245, 158, 11, 0.4);
}

.btn-slider:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(245, 158, 11, 0.6);
}

/* ========================================
   SERVICES SECTION
======================================== */
.services-section {
    padding: 120px 0;
    background: #f8fafc;
}

.services-section h3 {
    font-size: 3rem;
    font-weight: 700;
    text-align: center;
    margin-bottom: 1rem;
    position: relative;
    color: #0f172a;
}

.services-section h3 span {
    background: linear-gradient(45deg, #f59e0b, #fbbf24);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.description-services {
    max-width: 860px;
    margin: 0 auto;
    text-align: center;
    color: #475569;
}

.service-boxes-slider {
    margin-top: 4rem;
    display: grid;
    gap: 1.2rem;
}

.card-parent {
    margin: 2rem;
}

.card-inner-row {
    display: flex;
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.1);
    transition: all 0.4s ease;
    height: 450px;
}

.card-inner-row:hover {
    transform: translateY(-15px);
    box-shadow: 0 30px 80px rgba(0,0,0,0.15);
}

.card.featured {
    flex: 1;
    padding: 3rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.card.featured::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #f59e0b, #fbbf24);
}

.heading-wrapper {
    margin-bottom: 2rem;
}

.heading {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.heading i {
    font-size: 2.2rem;
    color: #f59e0b;
}

.paragraph-wrapper {
    flex: 1;
}

.paragraph {
    color: #64748b;
    line-height: 1.7;
    font-size: 1.1rem;
}

.project-button {
    margin-top: 2rem;
}

.project-button a {
    display: inline-flex;
    align-items: center;
    gap: 0.8rem;
    color: #f59e0b;
    font-weight: 600;
    text-decoration: none;
    padding: 0.8rem 0;
    transition: all 0.3s ease;
    border-bottom: 2px solid transparent;
}

.project-button a:hover {
    border-bottom-color: #f59e0b;
    transform: translateX(5px);
}

.card-img {
    flex: 0 0 350px;
    position: relative;
    overflow: hidden;
}

.card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.card-img:hover img {
    transform: scale(1.05);
}

.about-section {
    padding: 110px 0;
    background: #ffffff;
}

.about-grid {
    display: grid;
    grid-template-columns: 1.1fr 1fr;
    gap: 2.5rem;
    align-items: center;
}

.about-title-small {
    color: #f59e0b;
    font-size: 1rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 0.8rem;
}

.about-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 1rem;
}

.about-text {
    color: #475569;
    line-height: 1.8;
    margin-bottom: 1.2rem;
}

.about-features {
    margin: 0;
    padding-left: 1.2rem;
    color: #334155;
}

.about-features li {
    margin-bottom: 0.7rem;
}

.about-images {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.about-images .about-img-main {
    grid-column: 1 / -1;
    height: 300px;
}

.about-images img {
    width: 100%;
    height: 190px;
    object-fit: cover;
    border-radius: 16px;
}

/* ========================================
   ANIMATIONS
======================================== */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.to-top-left {
    animation: toTopLeft 0.8s ease-out both;
}

@keyframes toTopLeft {
    0% {
        opacity: 0;
        transform: translate(-50px, 50px);
    }
    100% {
        opacity: 1;
        transform: translate(0, 0);
    }
}

/* ========================================
   RESPONSIVE
======================================== */
@media (max-width: 768px) {
    .slider-content h1 { font-size: 3rem; }
    .slider-content h2 { font-size: 2.5rem; }
    .services-section { padding: 80px 0; }
    .about-grid { grid-template-columns: 1fr; }
    .card-inner-row {
        flex-direction: column;
        height: auto;
    }
    .card-img { flex: none; height: 250px; }
}

@media (max-width: 480px) {
    .btn-slider { padding: 0.8rem 1.5rem; font-size: 0.9rem; }
}
</style>

@php
    $resolveImageUrl = function (?string $path): string {
        $value = (string) ($path ?? '');

        if ($value === '') {
            return '';
        }

        if (filter_var($value, FILTER_VALIDATE_URL) || \Illuminate\Support\Str::startsWith($value, ['//'])) {
            return $value;
        }

        $trimmed = ltrim($value, '/');

        if (\Illuminate\Support\Str::startsWith($trimmed, ['public/'])) {
            return asset(ltrim(substr($trimmed, 7), '/'));
        }

        if (\Illuminate\Support\Str::startsWith($trimmed, ['images/', 'storage/'])) {
            return asset($trimmed);
        }

        if (\Illuminate\Support\Str::startsWith($trimmed, ['home/', 'services/', 'service/', 'blog/', 'projects/', 'about/', 'abouts/'])) {
            return asset('storage/' . $trimmed);
        }

        return asset($trimmed);
    };

    $primarySlide = $slides->first();
@endphp

<section class="slider-venor-section">
    <div class="slider-venor">
        @if($primarySlide)
        <div class="slider-inner-venor" data-background-image-url="{{ $resolveImageUrl($primarySlide->image) }}" style="background-image: url('{{ $resolveImageUrl($primarySlide->image) }}')">
            <div class="container">
                <div class="slider-content">
                    <h1 class="active">{{ $primarySlide->h1 }}</h1>
                    <h2 class="active">{{ $primarySlide->h2 }}</h2>
                    <div class="slider-body active">{!! $primarySlide->body !!}</div>
                    <div class="button-slider-b">
                        <a href="{{ $primarySlide->btn_link ?: route('contact-us') }}" class="btn btn-slider">
                            <span>{{ $primarySlide->btn_text ?: 'Start a Project' }}</span>
                            <svg width="11.4" height="9.2"><use xlink:href="#arrow"></use></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

<section class="services-section">
    <div class="container">
        <h3>How can <span>we help?</span></h3>
        <div class="description-services">
            <p>We help premium brands <strong>achieve their future</strong> through innovation and creative perspectives. <strong>We grow your company</strong> through proprietary in-house ideas, tested and perfected <strong>over the years.</strong></p>
        </div>

        <div class="service-boxes-slider">
            @forelse($services as $service)
            <div class="card-parent">
                <div class="card-inner-row">
                    <div class="card featured to-top-left">
                        <div class="heading-wrapper">
                            <h4 class="heading"><i class="{{ $service->icon }}"></i> {{ $service->title }}</h4>
                        </div>
                        <div class="paragraph-wrapper">
                            <p class="paragraph">{{ $service->description }}</p>
                        </div>
                        <div class="project-button">
                            <a href="{{ $service->url ?: route('contact-us') }}" title="{{ $service->title }}">
                                <span>Read more</span>
                                <svg viewBox="0 0 80 80">
                                    <polyline points="19.89 15.25 64.03 15.25 64.03 59.33"></polyline>
                                    <line x1="64.03" y1="15.25" x2="14.03" y2="65.18"></line>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="card-img">
                        <img class="img-fluid project-image" width="400" height="400" src="{{ $resolveImageUrl($service->image) }}" alt="{{ $service->title }}">
                    </div>
                </div>
            </div>
            @empty
            <div class="card-parent">
                <div class="card-inner-row">
                    <div class="card featured to-top-left">
                        <div class="heading-wrapper">
                            <h4 class="heading">New services are being prepared</h4>
                        </div>
                        <div class="paragraph-wrapper">
                            <p class="paragraph">Please check back soon, or contact us directly for current offers.</p>
                        </div>
                        <div class="project-button">
                            <a href="{{ route('contact-us') }}" title="Start a project">
                                <span>Start a project</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

@if($about)
<section class="about-section">
    <div class="container">
        <div class="about-grid">
            <div>
                <div class="about-title-small">{{ $about->heading1 }}</div>
                <h3 class="about-title">{{ $about->heading2 }}</h3>
                <p class="about-text">{{ $about->description }}</p>

                @if(is_array($about->features) && count($about->features))
                    <ul class="about-features">
                        @foreach($about->features as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="about-images">
                @if(!empty($about->image1))
                    <img class="about-img-main" src="{{ $resolveImageUrl($about->image1) }}" alt="About image 1">
                @endif
                @if(!empty($about->image2))
                    <img src="{{ $resolveImageUrl($about->image2) }}" alt="About image 2">
                @endif
                @if(!empty($about->image3))
                    <img src="{{ $resolveImageUrl($about->image3) }}" alt="About image 3">
                @endif
            </div>
        </div>
    </div>
</section>
@endif

{{-- STATS SECTION --}}
<section class="fun-facts-section light-section" id="fun-facts">
    <div class="container">
        <h3 class="fun-facts-heading1">Sarab in numbers</h3>
        <p>Over the years we have done many things that we are proud of. This motivates us to continue looking for new challenges in order to improve our services.</p>

        <div class="row fun-facts-timer">
            @foreach($stats as $stat)
            <div class="col-md-3">
                <div class="radial">
                    <span class="timer" data-from="0" data-to="{{ $stat->number }}" data-speed="4000">{{ $stat->number }}</span>
                    <h4>{{ $stat->label }}</h4>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
