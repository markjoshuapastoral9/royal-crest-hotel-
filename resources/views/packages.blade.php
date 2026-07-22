@extends('layouts.app')
@section('title', 'Special Packages - Royal Crest Hotel')

@push('styles')
<style>
    /* Skeleton Loader Styles - Dark Theme */
    .skeleton {
        background: linear-gradient(90deg, rgba(255,255,255,0.05) 25%, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0.05) 75%);
        background-size: 200% 100%;
        animation: loading 1.5s ease-in-out infinite;
        border-radius: 8px;
    }

    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    .skeleton-card {
        padding: 1.5rem;
        background: var(--surface, #1a1214);
        border: 1px solid var(--border, rgba(255,255,255,0.1));
        border-radius: 12px;
    }

    .skeleton-image {
        height: 200px;
        margin-bottom: 1rem;
    }

    .skeleton-text {
        height: 20px;
        margin-bottom: 10px;
    }

    .skeleton-text.short {
        width: 60%;
    }

    /* Fade-in Animation */
    .fade-in {
        opacity: 0;
        animation: fadeIn 0.6s ease-in forwards;
    }

    @keyframes fadeIn {
        to { opacity: 1; }
    }

    /* Stagger animation for cards */
    .package-card {
        animation: slideUp 0.6s ease-out forwards;
        opacity: 0;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .package-card:nth-child(1) { animation-delay: 0.1s; }
    .package-card:nth-child(2) { animation-delay: 0.2s; }
    .package-card:nth-child(3) { animation-delay: 0.3s; }
    .package-card:nth-child(4) { animation-delay: 0.4s; }
    .package-card:nth-child(5) { animation-delay: 0.5s; }
    .package-card:nth-child(6) { animation-delay: 0.6s; }

    /* Package Card Styles - Dark Theme */
    .package-card .card {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        background: var(--surface, #1a1214);
        border: 1px solid var(--border, rgba(255,255,255,0.1));
        box-shadow: 0 4px 6px -1px rgba(0,0,0,.3);
        transition: all 0.3s ease;
    }

    .package-card .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,.4);
        border-color: rgba(201,168,76,0.3);
    }

    .package-image {
        height: 250px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .package-card:hover .package-image {
        transform: scale(1.1);
    }

    .package-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(201,168,76,0.9);
        color: #000;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        z-index: 10;
        letter-spacing: 1px;
    }

    .inclusions-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.5rem;
        margin: 1rem 0;
    }

    .inclusion-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: rgba(192,192,192,0.9);
    }

    .inclusion-item i {
        color: #C9A84C;
    }

    .price-section {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .current-price {
        font-size: 2rem;
        font-weight: 700;
        color: #C9A84C;
    }

    .original-price {
        font-size: 1.25rem;
        color: rgba(192,192,192,0.5);
        text-decoration: line-through;
    }

    .savings-badge {
        background: rgba(201,168,76,0.15);
        border: 1px solid rgba(201,168,76,0.4);
        color: #C9A84C;
        padding: 0.35rem 0.85rem;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    /* Progress Indicator */
    .progress-indicator {
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 3px;
        background: linear-gradient(90deg, #C9A84C, #f59e0b);
        z-index: 9999;
        transition: width 0.3s ease;
    }

    .card-body {
        color: #fff;
    }

    .card-body h3 {
        color: #fff;
        font-weight: 600;
    }

    .card-body .text-muted {
        color: rgba(192,192,192,0.8) !important;
    }
</style>
@endpush

@section('content')
<!-- Progress Indicator -->
<div class="progress-indicator" id="progressBar"></div>

<!-- Hero Section -->
<div class="page-hero">
    <div class="container">
        <h1 class="text-white">Exclusive Packages</h1>
        <p class="text-white-50">Experience luxury with our curated packages combining accommodation, dining, and spa treatments</p>
    </div>
</div>

<!-- Packages Section -->
<section style="padding:50px 0; background:var(--bg-dark,#101111);">
    <div class="container">
        <!-- Loading Skeleton (shown initially) -->
        <div id="loadingSkeleton" class="row g-4 mb-4">
            <div class="col-md-6 col-lg-4" v-for="i in 6">
                <div class="skeleton-card">
                    <div class="skeleton skeleton-image"></div>
                    <div class="skeleton skeleton-text"></div>
                    <div class="skeleton skeleton-text short"></div>
                    <div class="skeleton skeleton-text"></div>
                </div>
            </div>
        </div>

        <!-- Actual Packages (shown after loading) -->
        <div id="packagesContainer" style="display: none;">
            <div class="row g-4">
                @foreach($packages as $package)
                <div class="col-md-6 col-lg-4 package-card">
                    <div class="card border-0 h-100">
                        @if($package->discount_percentage > 0)
                        <div class="package-badge">
                            SAVE {{ $package->discount_percentage }}%
                        </div>
                        @endif

                        <div class="position-relative overflow-hidden">
                            <img src="{{ asset($package->image ?? 'images/placeholder-package.jpg') }}" 
                                 class="card-img-top package-image" 
                                 alt="{{ $package->name }}"
                                 loading="lazy">
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h3 class="h4 mb-3">{{ $package->name }}</h3>
                            <p class="text-muted mb-3">{{ $package->description }}</p>

                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="bi bi-moon-stars me-1"></i>
                                    Minimum {{ $package->min_nights }} {{ Str::plural('night', $package->min_nights) }}
                                </small>
                            </div>

                            <div class="inclusions-grid">
                                @foreach($package->inclusion_list as $inclusion)
                                <div class="inclusion-item">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>{{ $inclusion }}</span>
                                </div>
                                @endforeach
                            </div>

                            <div class="price-section mt-auto">
                                <div class="current-price">₱{{ number_format($package->price, 0) }}</div>
                                @if($package->original_price)
                                <div class="original-price">₱{{ number_format($package->original_price, 0) }}</div>
                                @endif
                            </div>

                            @if($package->savings > 0)
                            <div class="savings-badge mt-2">
                                You save ₱{{ number_format($package->savings, 0) }}
                            </div>
                            @endif

                            <a href="{{ auth()->check() ? route('packages.book', $package->slug) : route('login', ['redirect' => route('packages.book', $package->slug)]) }}" 
                               class="btn btn-gold w-100 mt-3">
                                <i class="bi bi-calendar-check me-2"></i>Book This Package
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5" style="background: var(--surface, #1a1214); border-top: 1px solid var(--border, rgba(255,255,255,0.1));">
    <div class="container text-center fade-in">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="display-5 fw-bold mb-3 text-white">Can't Find the Perfect Package?</h2>
                <p class="lead mb-4" style="color: rgba(192,192,192,0.8);">Contact us and we'll create a custom package tailored to your needs</p>
                <a href="{{ route('contact') }}" class="btn btn-gold btn-lg px-5" style="border-radius: 30px;">
                    <i class="bi bi-envelope me-2"></i>Contact Us
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Simulate loading time (1.5 seconds)
    setTimeout(function() {
        document.getElementById('loadingSkeleton').style.display = 'none';
        document.getElementById('packagesContainer').style.display = 'block';
        
        // Update progress bar
        updateProgress(100);
    }, 1500);

    // Progress indicator on scroll
    window.addEventListener('scroll', function() {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        updateProgress(scrolled);
    });

    function updateProgress(percent) {
        document.getElementById('progressBar').style.width = percent + '%';
    }

    // Initial progress
    updateProgress(0);
});
</script>
@endpush
