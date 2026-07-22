@extends('layouts.app')
@section('title', 'Our Restaurant - Royal Crest Hotel')

@section('content')
<div class="page-hero">
    <div class="container">
        <h1 class="text-white">Our Restaurant</h1>
        <p class="text-white-50">Experience fine dining excellence at Royal Crest</p>
    </div>
</div>

<section style="padding:50px 0; background:var(--bg-dark,#101111);">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="rounded-4" style="background:var(--surface,#1a1214);border:1px solid var(--border);padding:2rem;">
                    <span class="section-tag">Culinary Excellence</span>
                    <h2 class="section-title">A Dining Experience Like No Other</h2>
                    <div class="section-divider left"></div>
                    <p class="text-muted mb-4">
                        The Royal Crest signature restaurant serves an exquisite array of Filipino and international cuisine. <strong class="text-gold">Suite guests enjoy complimentary meals</strong> based on room category. Our culinary team crafts every dish with passion and care.
                    </p>
                    <div class="alert mb-4" style="background:rgba(201,168,76,0.15);border:1px solid rgba(201,168,76,0.3);border-radius:10px;padding:1rem;">
                        <i class="bi bi-star-fill text-gold me-2"></i>
                        <strong class="text-gold">Complimentary Dining by Room Category</strong>
                        <ul class="text-muted small mb-0 mt-2 ps-3">
                            <li>Budget Rooms (₱3,000-4,999): No meals included</li>
                            <li>Standard Rooms (₱5,000-7,999): Breakfast included</li>
                            <li>Suites (₱8,000-15,499): Breakfast & dinner included</li>
                            <li>Premium Suites (₱15,500+): All-day dining (breakfast, lunch, dinner)</li>
                        </ul>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-clock text-gold fs-5"></i>
                                <div>
                                    <div class="small text-muted">Breakfast</div>
                                    <div class="fw-semibold text-white">6:00 AM - 10:30 AM</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-clock text-gold fs-5"></i>
                                <div>
                                    <div class="small text-muted">Lunch</div>
                                    <div class="fw-semibold text-white">11:30 AM - 2:30 PM</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-clock text-gold fs-5"></i>
                                <div>
                                    <div class="small text-muted">Dinner</div>
                                    <div class="fw-semibold text-white">6:00 PM - 10:30 PM</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-clock text-gold fs-5"></i>
                                <div>
                                    <div class="small text-muted">Bar</div>
                                    <div class="fw-semibold text-white">11:00 AM - 12:00 MN</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('dining.menu') }}" class="btn btn-gold">View Menu</a>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('images/restaurant-hero.jpg') }}" alt="Restaurant" class="img-fluid rounded-4" style="height:500px;width:100%;object-fit:cover;">
            </div>
        </div>

        <div class="row g-4 mt-4">
            <div class="col-md-4">
                <div class="facility-card">
                    <div class="facility-icon">
                        <i class="bi bi-award"></i>
                    </div>
                    <h5>Award-Winning Chef</h5>
                    <p>Our executive chef has received numerous culinary awards</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="facility-card">
                    <div class="facility-icon">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <h5>Local Ingredients</h5>
                    <p>We source fresh ingredients from local farms daily</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="facility-card">
                    <div class="facility-icon">
                        <i class="bi bi-cup-hot"></i>
                    </div>
                    <h5>All-Day Dining</h5>
                    <p>Enjoy breakfast, lunch, and dinner at your convenience</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
