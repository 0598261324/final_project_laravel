@extends('layouts.dashboard')

@section('title', 'View Post')

@section('content')
    <div class="dashboard-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="card-title mb-0">{{ $post->title }}</h4>
                <small class="text-muted">Posted by {{ $post->user->name }} ·
                    {{ $post->created_at->format('M d, Y') }}</small>
            </div>
            <div class="btn-group">
                @can('edit posts')
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                @endcan
                <a href="{{ route('posts.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>

        <div class="card-body">
            @if ($post->featured_image)
                <div class="post-featured-image mb-4">
                    <img src="{{ Storage::url($post->featured_image) }}" class="img-fluid rounded"
                        alt="{{ $post->title }}">
                </div>
            @endif

            <div class="post-meta mb-4">
                <span class="badge bg-primary me-2">{{ $post->category->name }}</span>
                <span class="badge bg-{{ $post->status === 'published' ? 'success' : 'warning' }}">
                    {{ ucfirst($post->status) }}
                </span>
            </div>

            <div class="post-content mb-4">
                {!! nl2br(e($post->content)) !!}
            </div>

            <!-- Comments Section -->
            <div class="comments-section mt-5">
                <h5 class="mb-4">Comments ({{ $post->comments->count() }})</h5>

                @foreach ($post->comments as $comment)
                    <div class="comment-card mb-3">
                        <div class="d-flex">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}"
                                class="rounded-circle me-3" width="40" height="40">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-1">{{ $comment->user->name }}</h6>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1">{{ $comment->content }}</p>
                                @can('delete', $comment)
                                    <div class="actions">
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-link text-danger p-0"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Comment Form -->
                <div class="comment-form mt-4">
                    <h6 class="mb-3">Add a Comment</h6>
                    <form action="{{ route('comments.store', $post) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea class="form-control @error('content') is-invalid @enderror" name="content" rows="3" required></textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i> Submit Comment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
