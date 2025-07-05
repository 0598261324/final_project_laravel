@extends('layouts.main')

@section('content')
<div class="hero-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="display-4 fw-bold mb-4 animate__animated animate__fadeIn">Blog Posts</h1>
                <div class="search-bar animate__animated animate__fadeIn animate__delay-1s">
                    <form action="{{ route('posts.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-lg" name="search"
                                placeholder="Search posts..." value="{{ request('search') }}">
                            <button class="btn btn-primary btn-lg" type="submit">
                                <i class="fas fa-search"></i>
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

<section class="blog-section py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                @if(request('category'))
                <h5 class="mb-0 me-3">Category: {{ request('category') }}</h5>
                <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-times me-1"></i> Clear filter
                </a>
                @endif
            </div>
            @can('create posts')
            <a href="{{ route('posts.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Create New Post
            </a>
            @endcan
        </div>

        <div class="row g-4">
            @forelse($posts as $post)
            <div class="col-md-6 col-lg-4">
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
                            {{ Str::limit(strip_tags($post->content), 150) }}
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
                            <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-book-reader me-1"></i> Read More
                            </a>
                            @can('edit posts')
                            <div class="btn-group">
                                <a href="{{ route('posts.edit', $post) }}"
                                    class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @can('delete posts')
                                <form action="{{ route('posts.destroy', $post) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this post?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <div class="empty-state py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h4>No Posts Found</h4>
                    <p class="text-muted">We couldn't find any posts matching your criteria.</p>
                    @can('create posts')
                    <a href="{{ route('posts.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus-circle me-1"></i> Create First Post
                    </a>
                    @endcan
                </div>
            </div>
            @endforelse
        </div>

        @if($posts->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</section>
@endsection