<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>
    @extends('layouts.main')

    @section('content')
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center">
                        <h1 class="display-4 fw-bold mb-4 animate__animated animate__fadeIn">
                            Welcome to {{ config('app.name') }}
                        </h1>
                        <p class="lead mb-4 animate__animated animate__fadeIn animate__delay-1s">
                            Discover amazing stories and share your thoughts
                        </p>
                        <div class="search-bar animate__animated animate__fadeIn animate__delay-2s">
                            <form action="{{ route('posts.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg" name="search"
                                        placeholder="Search posts...">
                                    <button class="btn btn-primary btn-lg" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Posts Section -->
        @if ($featuredPosts->count() > 0)
            <section class="featured-posts py-5">
                <div class="container">
                    <h2 class="section-title text-center mb-5">Featured Posts</h2>
                    <div class="row g-4">
                        @foreach ($featuredPosts as $post)
                            <div class="col-md-4">
                                <div class="card post-card h-100">
                                    <div class="card-img-wrapper">
                                        @if ($post->featured_image)
                                            <img src="{{ Storage::url($post->featured_image) }}" class="card-img-top"
                                                alt="{{ $post->title }}">
                                        @else
                                            <img src="https://source.unsplash.com/800x400/?blog,writing"
                                                class="card-img-top" alt="{{ $post->title }}">
                                        @endif
                                        <div class="card-img-overlay">
                                            <span class="badge bg-primary">{{ $post->category->name }}</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $post->title }}</h5>
                                        <p class="card-text">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                                    </div>
                                    <div class="card-footer bg-transparent border-0">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">By {{ $post->user->name }}</small>
                                            <a href="{{ route('posts.show', $post) }}"
                                                class="btn btn-sm btn-outline-primary">Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Categories Section -->
        @if ($categories->count() > 0)
            <section class="categories-section py-5 bg-light">
                <div class="container">
                    <h2 class="section-title text-center mb-5">Explore Categories</h2>
                    <div class="row g-4">
                        @foreach ($categories as $category)
                            <div class="col-md-3">
                                <div class="category-card">
                                    <div class="category-icon">
                                        <i class="fas fa-folder"></i>
                                    </div>
                                    <h5>{{ $category->name }}</h5>
                                    <p class="text-muted">{{ $category->posts_count }} Posts</p>
                                    <a href="{{ route('posts.index', ['category' => $category->id]) }}"
                                        class="stretched-link"></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Latest Posts Section -->
        @if ($latestPosts->count() > 0)
            <section class="latest-posts py-5">
                <div class="container">
                    <h2 class="section-title text-center mb-5">Latest Posts</h2>
                    <div class="row g-4">
                        @foreach ($latestPosts as $post)
                            <div class="col-md-4">
                                <div class="card post-card h-100">
                                    <!-- Similar to featured posts card structure -->
                                    <div class="card-img-wrapper">
                                        @if ($post->featured_image)
                                            <img src="{{ Storage::url($post->featured_image) }}" class="card-img-top"
                                                alt="{{ $post->title }}">
                                        @else
                                            <img src="https://source.unsplash.com/800x400/?blog,writing"
                                                class="card-img-top" alt="{{ $post->title }}">
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $post->title }}</h5>
                                        <p class="card-text">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                                    </div>
                                    <div class="card-footer bg-transparent border-0">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                            <a href="{{ route('posts.show', $post) }}"
                                                class="btn btn-sm btn-outline-primary">Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endsection
</body>

</html>
