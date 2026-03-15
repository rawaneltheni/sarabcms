@extends('layouts.app')
@section('title', 'Start a Project')

@section('content')
<style>
    .breadcrumb-area { padding: 100px 0 60px; text-align: center; }
    .breadcrumb-title { font-size: 3.5rem; font-weight: 700; letter-spacing: -1px; }

    .contact-section-page { padding-bottom: 100px; }

    /* Glassmorphism Card Effect */
    .contact-container {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 40px;
        backdrop-filter: blur(10px);
    }

    .contact-info-label { color: #888; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 2px; margin-bottom: 10px; display: block; }
    .contact-info-value { font-size: 1.5rem; font-weight: 500; margin-bottom: 30px; display: block; color: #fff; text-decoration: none; }
    .contact-info-value:hover { color: #fff; opacity: 0.8; }

    /* Modern Form Styling */
    .form-control {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff;
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        background: rgba(255, 255, 255, 0.08);
        border-color: #fff;
        box-shadow: none;
        color: #fff;
    }

    .btn-style1 {
        background: #fff;
        color: #000;
        padding: 15px 40px;
        border-radius: 8px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: none;
        width: 100%;
        transition: transform 0.2s ease;
    }
    .btn-style1:hover { transform: translateY(-2px); background: #f0f0f0; }

    .form-alert {
        border-radius: 10px;
        padding: 12px 14px;
        margin-bottom: 16px;
        font-size: 0.95rem;
        border: 1px solid transparent;
    }

    .form-alert.success {
        background: rgba(80, 216, 144, 0.12);
        border-color: rgba(80, 216, 144, 0.35);
        color: #dcfce7;
    }

    .form-alert.error {
        background: rgba(248, 113, 113, 0.12);
        border-color: rgba(248, 113, 113, 0.35);
        color: #fee2e2;
    }
</style>

<div class="breadcrumb-area">
    <div class="container">
        <h1 class="breadcrumb-title">Let’s build something <br>extraordinary.</h1>
    </div>
</div>

<div class="contact-section-page">
    <div class="container">
        <div class="contact-container">
            <div class="row">
                <div class="col-md-4 mb-5 mb-md-0">
                    <span class="contact-info-label">Direct Line</span>
                    <a href="tel:+12029984099" class="contact-info-value">+1 (202) 998 4099</a>

                    <span class="contact-info-label">Email Us</span>
                    <a href="mailto:hello@sarab.tech" class="contact-info-value">hello@sarab.tech</a>

                    <span class="contact-info-label">Office</span>
                    <address class="contact-info-value">Digital Nomad / <br>Remote Worldwide</address>
                </div>

                <div class="col-md-8">
                    @if(session('contact_success'))
                        <div class="form-alert success">{{ session('contact_success') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="form-alert error">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label class="contact-info-label">Full Name</label>
                                <input type="text" name="name" placeholder="John Doe" class="form-control" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="contact-info-label">Email Address</label>
                                <input type="email" name="email" placeholder="john@example.com" class="form-control" value="{{ old('email') }}" required>
                            </div>
                        </div>
                        <label class="contact-info-label">Tell us about your project</label>
                        <textarea name="message" class="form-control" placeholder="What are you looking to build?" rows="5" required>{{ old('message') }}</textarea>

                        <button type="submit" class="btn btn-style1">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
