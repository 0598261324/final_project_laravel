@extends('layouts.main')

@section('content')
<div class="hero-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeIn">Welcome to Our Blog</h1>
                <p class="lead mb-5 animate__animated animate__fadeIn animate__delay-1s">
                    Discover stories, thinking, and expertise from writers on any topic.
                </p>
                <div class="search-bar animate__animated animate__fadeIn animate__delay-2s">
                    <form action="{{ route('posts.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-lg" name="search"
                                placeholder="Search for stories...">
                            <button class="btn btn-primary btn-lg px-4" type="submit">
                                <i class="fas fa-search me-2"></i> Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-waves">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#ffffff" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</div>

<!-- Featured Posts Section -->
<section class="featured-posts py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">
            <span class="border-bottom border-primary border-3 pb-2">Featured Posts</span>
        </h2>
        <div class="row g-4">
            @foreach($featuredPosts as $post)
            <div class="col-md-4">
                <div class="card post-card h-100">
                    <div class="card-img-wrapper">
                        @if($post->featured_image)
                        <img src="{{ Storage::url($post->featured_image) }}"
                            class="card-img-top" alt="{{ $post->title }}">
                        @else
                        <img src="https://source.unsplash.com/800x400/?blog,writing"
                            class="card-img-top" alt="{{ $post->title }}">
                        @endif
                        <div class="card-img-overlay d-flex align-items-start">
                            <span class="badge bg-primary category-badge">
                                <i class="fas fa-folder me-1"></i>
                                {{ $post->category->name }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title mb-3">{{ $post->title }}</h5>
                        <p class="card-text text-muted">
                            {{ Str::limit(strip_tags($post->content), 100) }}
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}"
                                    class="rounded-circle me-2" width="30" height="30"
                                    alt="{{ $post->user->name }}">
                                <small class="text-muted">{{ $post->user->name }}</small>
                            </div>
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">
            <span class="border-bottom border-primary border-3 pb-2">Explore Categories</span>
        </h2>
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-md-3">
                <div class="category-card h-100 text-center">
                    <div class="category-icon mb-3">
                        <i class="fas fa-folder fa-2x text-primary"></i>
                    </div>
                    <h5 class="mb-2">{{ $category->name }}</h5>
                    <p class="text-muted mb-3">{{ $category->posts_count ?? 0 }} Posts</p>
                    <a href="{{ route('posts.index', ['category' => $category->id]) }}"
                        class="stretched-link"></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-section text-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h2 class="mb-4">Stay Updated</h2>
                <p class="mb-4">Subscribe to our newsletter for the latest posts and updates.</p>
                <form class="row g-2 justify-content-center">
                    <div class="col-auto">
                        <input type="email" class="form-control form-control-lg" placeholder="Enter your email">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-light btn-lg">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection