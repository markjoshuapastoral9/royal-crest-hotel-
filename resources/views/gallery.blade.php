@extends('layouts.app')
@section('title', __('site.gal_title'))

@push('styles')
<style>
.gal-hero { background: linear-gradient(135deg, #101111 0%, #1e1613 50%, #101111 100%); padding: 100px 0 60px; border-bottom: 1px solid rgba(166,130,74,.2); }
.gal-tabs .nav-link { background: rgba(255,255,255,.04); border: 1px solid rgba(166,130,74,.2); color: #B8AFA6; border-radius: 30px; font-size: .8rem; font-weight: 600; letter-spacing: .5px; padding: 7px 20px; transition: all .25s; font-family: 'Inter', sans-serif; }
.gal-tabs .nav-link:hover { background: rgba(166,130,74,.1); color: #E6E2DA; border-color: rgba(166,130,74,.4); }
#galleryTabs .nav-link.active { background-color: #A6824A !important; color: #101111 !important; border-color: #A6824A !important; box-shadow: 0 4px 15px rgba(166,130,74,.35) !important; }
.gallery-item { overflow: hidden; border-radius: 12px; cursor: pointer; border: 1px solid rgba(166,130,74,.12); transition: all .35s; }
.gallery-item:hover { border-color: rgba(166,130,74,.4); box-shadow: 0 8px 24px rgba(0,0,0,.5); transform: translateY(-3px); }
.gallery-item img { transition: transform .4s ease; width: 100%; object-fit: cover; display: block; }
.gallery-item:hover img { transform: scale(1.07); }
.gal-section-title { color: #E6E2DA; font-size: 1rem; font-weight: 700; margin-bottom: 1.2rem; font-family: 'Inter', sans-serif; display: flex; align-items: center; gap: 8px; padding-bottom: .6rem; border-bottom: 1px solid rgba(166,130,74,.15); }
.gal-section-title i { color: #A6824A; }
.gal-empty { text-align: center; padding: 4rem 1rem; color: #9a9189; }
.gal-empty i { font-size: 3rem; color: rgba(166,130,74,.3); display: block; margin-bottom: 1rem; }
</style>
@endpush

@section('content')

{{-- Hero --}}
<div class="gal-hero">
    <div class="container text-center">
        <span class="section-tag">{{ __('site.gal_tag') }}</span>
        <h1 class="mt-2" style="color:#E6E2DA;font-family:'Playfair Display',serif;font-size:clamp(1.8rem,4vw,3rem);">{{ __('site.gal_title') }}</h1>
        <p style="color:#9a9189;font-family:'Inter',sans-serif;font-size:.95rem;margin-top:.5rem;">{{ __('site.gal_subtitle') }}</p>
    </div>
</div>

{{-- Gallery --}}
<section style="padding:70px 0;background:#101111;">
<div class="container">

    {{-- Filter Tabs --}}
    @php
    $galCategories = [
        'hotel'      => __('site.gal_cat_hotel'),
        'rooms'      => __('site.gal_cat_rooms'),
        'facilities' => __('site.gal_cat_facilities'),
        'restaurant' => __('site.gal_cat_restaurant'),
        'pool'       => __('site.gal_cat_pool'),
        'events'     => __('site.gal_cat_events'),
    ];
    @endphp
    <ul class="nav gal-tabs justify-content-center mb-5 gap-2 flex-wrap" id="galleryTabs">
        <li class="nav-item">
            <button class="nav-link active px-4" data-filter="all">{{ __('site.gal_filter_all') }}</button>
        </li>
        @foreach($galCategories as $cat => $label)
        <li class="nav-item">
            <button class="nav-link px-4" data-filter="{{ $cat }}">{{ $label }}</button>
        </li>
        @endforeach
    </ul>

    @if($galleries->isNotEmpty())
    @foreach($galleries as $category => $images)
    <div class="gallery-section mb-5" data-category="{{ $category }}">
        <div class="gal-section-title">
            <i class="bi bi-images"></i>{{ $galCategories[$category] ?? ucfirst($category) }}
        </div>
        <div class="row g-3">
            @foreach($images as $img)
            <div class="col-lg-3 col-md-4 col-6 gallery-filter-item" data-cat="{{ $category }}">
                <div class="gallery-item" style="height:200px;"
                     onclick="openLightbox('{{ $img->image_url }}', '{{ $img->title ?? $category }}')">
                    <img src="{{ $img->image_url }}" style="height:200px;" alt="{{ $img->title ?? $category }}"
                         onerror="this.src='https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&q=60'">
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
    @else
    <div class="gal-empty">
        <i class="bi bi-images"></i>
        <p>{{ __('site.gal_coming_soon') }}</p>
        <a href="{{ route('rooms.index') }}" class="btn btn-gold mt-2">{{ __('site.gal_browse_rooms') }}</a>
    </div>
    @endif

</div>
</section>

{{-- Lightbox Modal --}}
<div class="modal fade" id="lightboxModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0" style="background:#1e1a1b;">
            <div class="modal-header border-0 pb-0" style="border-bottom:1px solid rgba(166,130,74,.15)!important;">
                <h6 class="modal-title" style="color:#E6E2DA;font-family:'Inter',sans-serif;" id="lightboxTitle"></h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-3">
                <img id="lightboxImg" src="" class="img-fluid rounded-3" style="max-height:80vh;" alt="">
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openLightbox(src, title) {
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightboxTitle').textContent = title;
    new bootstrap.Modal(document.getElementById('lightboxModal')).show();
}

document.querySelectorAll('#galleryTabs .nav-link').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('#galleryTabs .nav-link').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const filter = this.dataset.filter;
        document.querySelectorAll('.gallery-section').forEach(section => {
            section.style.display = (filter === 'all' || section.dataset.category === filter) ? 'block' : 'none';
        });
    });
});
</script>
@endpush
