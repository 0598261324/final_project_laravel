@extends('layouts.dashboard')

@section('title', 'Edit Post')

@section('content')
    <div class="dashboard-card">
        <div class="card-header">
            <h4 class="card-title mb-0">Edit Post</h4>
            <small class="text-muted">Update post information</small>
        </div>

        <div class="card-body">
            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                value="{{ old('title', $post->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" name="content" rows="12" required>{{ old('content', $post->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" name="category_id"
                                required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Featured Image</label>
                            @if ($post->featured_image)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($post->featured_image) }}" class="img-thumbnail"
                                        alt="Current featured image">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                                name="featured_image">
                            @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="draft" {{ $post->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ $post->status === 'published' ? 'selected' : '' }}>Published
                                </option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Post
                            </button>
                            <a href="{{ route('posts.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
