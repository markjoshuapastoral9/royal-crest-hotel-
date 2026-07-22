@extends('layouts.app')
@section('title', 'Room Service - Royal Crest Hotel')

@section('content')
<div class="page-hero">
    <div class="container">
        <h1 class="text-white">Room Service</h1>
        <p class="text-white-50">Dining in the comfort of your room</p>
    </div>
</div>

<section style="padding:50px 0; background:var(--bg-dark,#101111);">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag">24/7 Service</span>
            <h2 class="section-title">Enjoy Meals in Complete Privacy</h2>
            <div class="section-divider"></div>
            <p class="text-muted">Order from our extensive menu and have it delivered to your room any time, day or night</p>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-lg-8 mx-auto">
                <div class="rounded-4 p-4 text-center" style="background:var(--surface,#1a1214);border:1px solid var(--border);">
                    <i class="bi bi-clock-history text-gold fs-1 mb-3 d-block"></i>
                    <h4 class="text-white mb-3">Available 24 Hours a Day</h4>
                    <p class="text-muted mb-4">Our room service is available around the clock to serve you. Simply dial extension 100 from your room phone to place an order.</p>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3 rounded" style="background:rgba(166,130,74,0.1);">
                                <i class="bi bi-telephone text-gold fs-4 mb-2 d-block"></i>
                                <div class="small text-white fw-semibold">Call Extension</div>
                                <div class="text-gold fw-bold">100</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded" style="background:rgba(166,130,74,0.1);">
                                <i class="bi bi-stopwatch text-gold fs-4 mb-2 d-block"></i>
                                <div class="small text-white fw-semibold">Delivery Time</div>
                                <div class="text-gold fw-bold">20-30 mins</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded" style="background:rgba(166,130,74,0.1);">
                                <i class="bi bi-credit-card text-gold fs-4 mb-2 d-block"></i>
                                <div class="small text-white fw-semibold">Payment</div>
                                <div class="text-gold fw-bold">Charge to Room</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mb-4">
            <h3 class="text-white">Popular Room Service Items</h3>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="rounded-4 p-4" style="background:var(--surface,#1a1214);border:1px solid var(--border);">
                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0">
                            <div style="width:80px;height:80px;background:rgba(166,130,74,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-egg-fried text-gold fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="text-white mb-1">Breakfast in Bed</h5>
                                <span class="text-gold fw-bold">₱450+</span>
                            </div>
                            <p class="text-muted small mb-2">Start your day with a complete breakfast delivered to your room</p>
                            <span class="badge" style="background:rgba(166,130,74,0.2);color:var(--gold);">6:00 AM - 10:30 AM</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="rounded-4 p-4" style="background:var(--surface,#1a1214);border:1px solid var(--border);">
                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0">
                            <div style="width:80px;height:80px;background:rgba(166,130,74,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-cup-straw text-gold fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="text-white mb-1">Midnight Snacks</h5>
                                <span class="text-gold fw-bold">₱280+</span>
                            </div>
                            <p class="text-muted small mb-2">Light bites and comfort food available throughout the night</p>
                            <span class="badge" style="background:rgba(166,130,74,0.2);color:var(--gold);">11:00 PM - 5:00 AM</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="rounded-4 p-4" style="background:var(--surface,#1a1214);border:1px solid var(--border);">
                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0">
                            <div style="width:80px;height:80px;background:rgba(166,130,74,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-cup-hot text-gold fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="text-white mb-1">Coffee & Pastries</h5>
                                <span class="text-gold fw-bold">₱200+</span>
                            </div>
                            <p class="text-muted small mb-2">Fresh coffee and baked goods for your morning or afternoon</p>
                            <span class="badge" style="background:rgba(166,130,74,0.2);color:var(--gold);">24/7 Available</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="rounded-4 p-4" style="background:var(--surface,#1a1214);border:1px solid var(--border);">
                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0">
                            <div style="width:80px;height:80px;background:rgba(166,130,74,0.1);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-wine text-gold fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="text-white mb-1">Beverages & Bar</h5>
                                <span class="text-gold fw-bold">₱180+</span>
                            </div>
                            <p class="text-muted small mb-2">Full bar service with wines, cocktails, and premium spirits</p>
                            <span class="badge" style="background:rgba(166,130,74,0.2);color:var(--gold);">11:00 AM - 12:00 MN</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-4 p-4 mt-5" style="background:var(--surface,#1a1214);border:1px solid var(--border);">
            <h4 class="text-white mb-4">Special Occasions</h4>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-heart text-gold fs-4"></i>
                        <div>
                            <h6 class="text-white mb-1">Romantic Dinner Setup</h6>
                            <p class="text-muted small mb-0">We can arrange a romantic candlelit dinner in your room. Contact us 24 hours in advance.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-cake2 text-gold fs-4"></i>
                        <div>
                            <h6 class="text-white mb-1">Birthday Surprises</h6>
                            <p class="text-muted small mb-0">Celebrate with a special birthday cake delivery. Pre-order through front desk.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('dining.menu') }}" class="btn btn-gold">View Full Menu</a>
        </div>
    </div>
</section>
@endsection
