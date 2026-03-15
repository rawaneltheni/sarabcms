@extends('layouts.app')

@section('title', $post->title)

@section('content')
<style>
    .blog-article-page {
        background: linear-gradient(180deg, #050608 0%, #0b0e14 100%);
        color: #fff;
        padding: 26px 0 90px;
    }

    .blog-article-shell {
        max-width: 1160px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .blog-article-top {
        margin-bottom: 28px;
    }

    .blog-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #fbbf24;
        text-decoration: none;
        font-weight: 700;
        margin-bottom: 18px;
    }

    .blog-article-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        gap: 26px;
        align-items: start;
    }

    .blog-article-main,
    .blog-article-side-card {
        border-radius: 28px;
        border: 1px solid rgba(255,255,255,.08);
        background: rgba(255,255,255,.03);
        overflow: hidden;
    }

    .blog-article-header {
        padding: 34px 34px 18px;
    }

    .blog-article-meta {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        color: rgba(255,255,255,.65);
        font-size: 13px;
        margin-bottom: 14px;
    }

    .blog-article-header h1 {
        font-size: clamp(2.4rem, 4vw, 4rem);
        line-height: 1.06;
        font-weight: 800;
        letter-spacing: -0.04em;
        margin-bottom: 16px;
    }

    .blog-article-excerpt {
        max-width: 760px;
        color: rgba(255,255,255,.74);
        line-height: 1.8;
        font-size: 1.03rem;
    }

    .blog-article-image {
        width: 100%;
        max-height: 520px;
        object-fit: cover;
        display: block;
    }

    .blog-article-body {
        padding: 30px 34px 40px;
        color: rgba(255,255,255,.82);
        line-height: 1.95;
        font-size: 1rem;
    }

    .blog-article-body p + p {
        margin-top: 1.1rem;
    }

    .blog-article-side {
        display: grid;
        gap: 18px;
        position: sticky;
        top: 96px;
    }

    .blog-article-side-card {
        padding: 22px;
    }

    .blog-article-side-card h3 {
        margin: 0 0 14px;
        font-size: 1rem;
        font-weight: 800;
        color: #fff;
    }

    .blog-side-item + .blog-side-item {
        margin-top: 14px;
        padding-top: 14px;
        border-top: 1px solid rgba(255,255,255,.08);
    }

    .blog-side-item a {
        color: #fff;
        text-decoration: none;
        font-weight: 700;
        line-height: 1.5;
    }

    .blog-side-item a:hover {
        color: #fbbf24;
    }

    .blog-side-date {
        display: block;
        font-size: 12px;
        color: rgba(255,255,255,.55);
        margin-top: 6px;
    }

    .blog-side-cta {
        display: inline-flex;
        justify-content: center;
        width: 100%;
        padding: 13px 20px;
        border-radius: 999px;
        background: linear-gradient(135deg, #f59e0b, #fbbf24);
        color: #0c0b09;
        text-decoration: none;
        font-weight: 800;
    }

    @media (max-width: 1024px) {
        .blog-article-grid {
            grid-template-columns: 1fr;
        }

        .blog-article-side {
            position: static;
        }
    }

    @media (max-width: 640px) {
        .blog-article-shell {
            padding: 0 14px;
        }

        .blog-article-header,
        .blog-article-body,
        .blog-article-side-card {
            padding-left: 18px;
            padding-right: 18px;
        }
    }
</style>

<div class="blog-article-page">
    <div class="blog-article-shell">
        <div class="blog-article-top">
            <a class="blog-back" href="{{ route('blog.index') }}">← Back to blog</a>
        </div>

        <div class="blog-article-grid">
            <article class="blog-article-main">
                <header class="blog-article-header">
                    <div class="blog-article-meta">
                        <span>Sarab.tech blog</span>
                        <span>•</span>
                        <span>{{ optional($post->date)->format('M d, Y') ?? $post->created_at?->format('M d, Y') }}</span>
                    </div>
                    <h1>{{ $post->title }}</h1>
                    @if($post->excerpt)
                        <p class="blog-article-excerpt">{{ $post->excerpt }}</p>
                    @endif
                </header>

                @if($post->image_url)
                    <img class="blog-article-image" src="{{ $post->image_url }}" alt="{{ $post->title }}">
                @endif

                <div class="blog-article-body">
                    {!! nl2br(e($post->content ?: 'This article does not have full content yet.')) !!}
                </div>
            </article>

            <aside class="blog-article-side">
                <div class="blog-article-side-card">
                    <h3>Need something similar?</h3>
                    <p style="color: rgba(255,255,255,.7); line-height: 1.8; margin-bottom: 14px;">
                        Talk to the Sarab team about your next website, app, AI, or digital product idea.
                    </p>
                    <a class="blog-side-cta" href="{{ route('contact-us') }}">Start a Project</a>
                </div>

                @if($relatedPosts->isNotEmpty())
                    <div class="blog-article-side-card">
                        <h3>More from the blog</h3>
                        @foreach($relatedPosts as $relatedPost)
                            <div class="blog-side-item">
                                <a href="{{ route('blog.show', $relatedPost->slug) }}">{{ $relatedPost->title }}</a>
                                <span class="blog-side-date">{{ optional($relatedPost->date)->format('M d, Y') ?? $relatedPost->created_at?->format('M d, Y') }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </aside>
        </div>
    </div>
</div>
@endsection
