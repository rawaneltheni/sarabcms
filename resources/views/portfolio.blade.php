@extends('layouts.app')
@section('title', 'Portfolio')
@section('content')

<style>
/* Portfolio Section */
.portfolio-section-page {
    padding: 40px 0; /* Reduced from 80px */
    background-color: #fff;
    overflow: hidden;
}
.projects-page-row {
    max-width: 1200px;
    margin: 0 auto;
}
.project-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 120px;
    position: relative;
    gap: 50px;
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s ease, transform 0.6s ease;
}
.flex-reverse { flex-direction: row-reverse; }

/* Image Styling */
.project__img_container { flex: 1; display: flex; justify-content: center; z-index: 2; }
.image-wrapper {
    width: 450px;
    height: 450px;
    border-radius: 50%;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    border: 8px solid #f8f9fa;
    position: relative;
}
.image-wrapper::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 50%;
    box-shadow: inset 0 0 20px rgba(0,0,0,0.1);
    pointer-events: none;
}
.image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.image-wrapper:hover img { transform: scale(1.1); }

/* Content Styling */
.project__info_content { flex: 1; z-index: 2; padding: 30px; }
.case_category {
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #666;
    display: block;
    margin-bottom: 10px;
    font-weight: 500;
}
.project_title {
    font-size: 42px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #222;
    line-height: 1.2;
}
.project_description {
    font-size: 18px;
    line-height: 1.8;
    color: #555;
    margin-bottom: 30px;
    max-width: 500px;
}
.project_index {
    position: absolute;
    font-size: 250px;
    font-weight: 900;
    color: rgba(0,0,0,0.03);
    top: -50px;
    left: -20px;
    line-height: 1;
    z-index: 1;
    pointer-events: none;
    user-select: none;
    font-family: 'Poppins', sans-serif;
}
.flex-reverse .project_index { left: auto; right: -20px; }

/* Button Styling */
.project-button { margin-top: 30px; }
.explore-btn {
    display: inline-block;
    padding: 15px 35px;
    background: transparent;
    border: 2px solid #222;
    text-decoration: none;
    color: #222;
    font-weight: 600;
    font-size: 16px;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    z-index: 1;
}
.explore-btn span { position: relative; z-index: 2; }
.explore-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: #222;
    transition: left 0.3s ease;
    z-index: 1;
}
.explore-btn:hover {
    color: #fff;
    border-color: #222;
}
.explore-btn:hover::before { left: 0; }

/* Responsive Design */
@media (max-width: 991px) {
    .project-item, .flex-reverse { flex-direction: column; text-align: center; gap: 30px; margin-bottom: 80px; }
    .image-wrapper { width: 300px; height: 300px; }
    .project_index { font-size: 150px; top: -20px; left: 50%; transform: translateX(-50%); }
    .flex-reverse .project_index { left: 50%; transform: translateX(-50%); }
    .project__info_content { text-align: center; padding: 20px; }
    .project_description { margin: auto; }
    .project_title { font-size: 32px; }
}
@media (max-width: 576px) {
    .image-wrapper { width: 250px; height: 250px; border-width: 5px; }
    .project_index { font-size: 120px; }
    .project_title { font-size: 28px; }
    .project_description { font-size: 16px; }
    .explore-btn { padding: 12px 25px; font-size: 14px; }
}
</style>

<!-- Portfolio Section -->
<div class="portfolio-section-page">
    <div class="container">
        <div class="projects-page-row">
            @forelse($projects as $index => $project)
                <div class="project-item {{ $index % 2 != 0 ? 'flex-reverse' : '' }}" style="animation-delay: {{ ($index + 1) * 0.1 }}s;">
                    <div class="project_index">
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </div>
                    <div class="project__img_container">
                        <div class="image-wrapper">
                            @if($project->image_url)
                                <img class="img-fluid" src="{{ $project->image_url }}" alt="{{ $project->title }}" loading="lazy">
                            @endif
                        </div>
                    </div>
                    <div class="project__info_content">
                        <span class="case_category">{{ $project->category }}</span>
                        <h2 class="project_title">{{ $project->title }}</h2>
                        <div class="project_description">
                            <p>{{ $project->description }}</p>
                        </div>
                        <div class="project-button">
                            <a href="{{ route('contact-us') }}" class="explore-btn">
                                <span>Start Similar Project</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="project__info_content" style="text-align:center; margin: 30px auto; max-width: 700px;">
                    <h2 class="project_title" style="font-size: 2rem;">Portfolio updates are coming soon</h2>
                    <div class="project_description">
                        <p>We are preparing new project case studies. Contact us to discuss your product idea today.</p>
                    </div>
                    <div class="project-button">
                        <a href="{{ route('contact-us') }}" class="explore-btn">
                            <span>Start a Project</span>
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.2, rootMargin: '0px 0px -50px 0px' });

    document.querySelectorAll('.project-item').forEach(item => observer.observe(item));
});
</script>

@endsection
