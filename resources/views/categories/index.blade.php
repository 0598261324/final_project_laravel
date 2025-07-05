@extends('layouts.dashboard')

@section('title', 'Manage Categories')

@section('content')
    <div class="dashboard-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="card-title mb-0">Categories</h4>
                <small class="text-muted">Manage blog categories</small>
            </div>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>New Category
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Posts</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>
                                    <h6 class="mb-0">{{ $category->name }}</h6>
                                </td>
                                <td><code>{{ $category->slug }}</code></td>
                                <td>{{ Str::limit($category->description, 50) }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $category->posts_count }} posts</span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure? This will also remove the category from all associated posts.')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="empty-state">
                                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                        <h6>No Categories Found</h6>
                                        <p class="text-muted">Start by creating your first category.</p>
                                        <a href="{{ route('categories.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus-circle me-2"></i>Create Category
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection
