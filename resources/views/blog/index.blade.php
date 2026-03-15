@extends('layouts.app')

@section('title', 'Blog')

@section('content')
<style>
    .blog-page {
        background: radial-gradient(circle at top, rgba(245, 158, 11, 0.12), transparent 28%), #06070a;
        color: #fff;
        padding: 32px 0 80px;
    }

    .blog-shell {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .blog-hero {
        display: grid;
        grid-template-columns: minmax(0, 1.1fr) minmax(320px, 0.9fr);
        gap: 28px;
        align-items: stretch;
        margin-bottom: 56px;
    }

    .blog-hero-copy {
        padding: 28px 0;
    }

    .blog-kicker {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: #fbbf24;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 18px;
    }

    .blog-title {
        font-size: clamp(2.6rem, 5vw, 4.9rem);
        line-height: 1.02;
        letter-spacing: -0.04em;
        font-weight: 800;
        margin-bottom: 18px;
        color: #fff;
    }

    .blog-intro {
        max-width: 640px;
        font-size: 1.05rem;
        line-height: 1.8;
        color: rgba(255, 255, 255, 0.72);
        margin-bottom: 26px;
    }

    .blog-actions {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
    }

    .blog-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 14px 24px;
        border-radius: 999px;
        text-decoration: none;
        font-weight: 700;
        transition: .25s ease;
    }

    .blog-btn-primary {
        background: linear-gradient(135deg, #f59e0b, #fbbf24);
        color: #090909;
        box-shadow: 0 18px 38px rgba(245, 158, 11, 0.25);
    }

    .blog-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 24px 46px rgba(245, 158, 11, 0.34);
    }

    .blog-btn-secondary {
        border: 1px solid rgba(255, 255, 255, 0.16);
        color: #fff;
        background: rgba(255, 255, 255, 0.04);
    }

    .blog-btn-secondary:hover {
        background: rgba(255, 255, 255, 0.08);
    }

    .blog-featured {
        position: relative;
        overflow: hidden;
        border-radius: 28px;
        background: linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,.02));
        border: 1px solid rgba(255,255,255,.09);
        min-height: 500px;
        display: flex;
        align-items: flex-end;
    }

    .blog-featured-media,
    .blog-featured-media img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
    }

    .blog-featured-media img {
        object-fit: cover;
    }

    .blog-featured-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(7, 9, 15, 0.05) 0%, rgba(7, 9, 15, 0.9) 100%);
    }

    .blog-featured-content {
        position: relative;
        z-index: 2;
        padding: 28px;
    }

    .blog-meta {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: rgba(255,255,255,.75);
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .blog-featured-content h2 {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1.15;
        margin-bottom: 12px;
    }

    .blog-featured-content p {
        color: rgba(255,255,255,.78);
        line-height: 1.8;
        margin-bottom: 16px;
    }

    .blog-section-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 20px;
        margin-bottom: 26px;
    }

    .blog-section-head h3 {
        font-size: 2rem;
        font-weight: 800;
        color: #fff;
    }

    .blog-section-head p {
        max-width: 560px;
        color: rgba(255,255,255,.65);
        line-height: 1.7;
    }

    .blog-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 22px;
    }

    .blog-card {
        display: flex;
        flex-direction: column;
        overflow: hidden;
        border-radius: 24px;
        background: rgba(255,255,255,.04);
        border: 1px solid rgba(255,255,255,.08);
        transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
        min-height: 100%;
    }

    .blog-card:hover {
        transform: translateY(-6px);
        border-color: rgba(251,191,36,.35);
        box-shadow: 0 26px 50px rgba(0,0,0,.28);
    }

    .blog-card-image {
        aspect-ratio: 16 / 10;
        background: linear-gradient(135deg, rgba(245,158,11,.16), rgba(59,130,246,.14));
        overflow: hidden;
    }

    .blog-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .blog-card-body {
        padding: 22px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        flex: 1;
    }

    .blog-card-body h4 {
        font-size: 1.3rem;
        line-height: 1.35;
        color: #fff;
        font-weight: 700;
    }

    .blog-card-body p {
        color: rgba(255,255,255,.68);
        line-height: 1.75;
    }

    .blog-read {
        margin-top: auto;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #fbbf24;
        text-decoration: none;
        font-weight: 700;
    }

    .blog-empty {
        border-radius: 24px;
        border: 1px dashed rgba(255,255,255,.16);
        padding: 50px 24px;
        text-align: center;
        color: rgba(255,255,255,.72);
        background: rgba(255,255,255,.02);
    }

    .blog-pagination {
        margin-top: 32px;
    }

    .blog-pagination nav {
        display: flex;
        justify-content: center;
    }

    @media (max-width: 1024px) {
        .blog-hero,
        .blog-grid {
            grid-template-columns: 1fr;
        }

        .blog-featured {
            min-height: 420px;
        }
    }

    @media (max-width: 640px) {
        .blog-page {
            padding-top: 12px;
        }

        .blog-shell {
            padding: 0 14px;
        }

        .blog-featured-content,
        .blog-card-body {
            padding: 18px;
        }

        .blog-section-head {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>

<div class="blog-page">
    <div class="blog-shell">
        <section class="blog-hero">
            <div class="blog-hero-copy">
                <div class="blog-kicker">Sarab.tech blog</div>
                <h1 class="blog-title">Stories, ideas, and updates from the Sarab team.</h1>
                <p class="blog-intro">
                    Explore insights, project highlights, product thinking, and practical digital advice published directly from the content your team manages in Filament.
                </p>
                <div class="blog-actions">
                    <a href="#articles" class="blog-btn blog-btn-primary">Browse Articles</a>
                    <a href="{{ route('contact-us') }}" class="blog-btn blog-btn-secondary">Start a Project</a>
                </div>
            </div>

            @if($featuredPost)
                <article class="blog-featured">
                    @if($featuredPost->image_url)
                        <div class="blog-featured-media">
                            <img src="{{ $featuredPost->image_url }}" alt="{{ $featuredPost->title }}">
                        </div>
                    @endif
                    <div class="blog-featured-overlay"></div>
                    <div class="blog-featured-content">
                        <div class="blog-meta">
                            <span>Featured article</span>
                            <span>•</span>
                            <span>{{ optional($featuredPost->date)->format('M d, Y') ?? $featuredPost->created_at?->format('M d, Y') }}</span>
                        </div>
                        <h2>{{ $featuredPost->title }}</h2>
                        <p>{{ $featuredPost->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($featuredPost->content), 170) }}</p>
                        <a href="{{ route('blog.show', $featuredPost->slug) }}" class="blog-btn blog-btn-primary">Read Article</a>
                    </div>
                </article>
            @else
                <div class="blog-featured">
                    <div class="blog-featured-overlay"></div>
                    <div class="blog-featured-content">
                        <div class="blog-meta">
                            <span>Blog coming soon</span>
                        </div>
                        <h2>Fresh articles will appear here as soon as your team publishes them in Filament.</h2>
                        <p>Once you add blog posts from the CMS, they will automatically show up on this page.</p>
                    </div>
                </div>
            @endif
        </section>

        <section id="articles">
            <div class="blog-section-head">
                <div>
                    <h3>Latest Articles</h3>
                    <p>All blog posts below are loaded from your Filament blog entries.</p>
                </div>
            </div>

            @if($posts->count())
                <div class="blog-grid">
                    @foreach($posts as $post)
                        <article class="blog-card">
                            <div class="blog-card-image">
                                @if($post->image_url)
                                    <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
                                @endif
                            </div>
                            <div class="blog-card-body">
                                <div class="blog-meta">
                                    <span>{{ optional($post->date)->format('M d, Y') ?? $post->created_at?->format('M d, Y') }}</span>
                                </div>
                                <h4>{{ $post->title }}</h4>
                                <p>{{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 130) }}</p>
                                <a class="blog-read" href="{{ route('blog.show', $post->slug) }}">Read more <span>→</span></a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="blog-pagination">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="blog-empty">
                    No blog posts yet. Add one in Filament and it will appear here automatically.
                </div>
            @endif
        </section>
    </div>
</div>
@endsection
