@extends('layouts.dashboard')

@section('title', 'Manage Posts')

@section('content')
    <div class="dashboard-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="card-title mb-0">All Posts</h4>
                <small class="text-muted">Manage your blog posts</small>
            </div>
            @can('create posts')
                <a href="{{ route('posts.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>New Post
                </a>
            @endcan
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th style="width: 60px;">Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                            <tr>
                                <td>
                                    <img src="{{ $post->featured_image ? Storage::url($post->featured_image) : 'https://via.placeholder.com/50' }}"
                                        class="rounded" width="50" height="50" alt="{{ $post->title }}"
                                        style="object-fit: cover;">
                                </td>
                                <td>
                                    <h6 class="mb-1">{{ $post->title }}</h6>
                                    <small class="text-muted">By {{ $post->user->name }}</small>
                                </td>
                                <td><span class="badge bg-primary">{{ $post->category->name }}</span></td>
                                <td>{!! $post->status === 'published'
                                    ? '<span class="badge bg-success">Published</span>'
                                    : '<span class="badge bg-warning">Draft</span>' !!}</td>
                                <td>{{ $post->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @can('edit posts')
                                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        @can('delete posts')
                                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="empty-state">
                                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                        <h6>No Posts Found</h6>
                                        <p class="text-muted">Start creating your first blog post.</p>
                                        @can('create posts')
                                            <a href="{{ route('posts.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus-circle me-2"></i>Create Post
                                            </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection
