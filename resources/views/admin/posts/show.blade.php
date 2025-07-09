<x-admin-layout>
    <div class="container-fluid py-4">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Announcement Details</h1>
            <div>
                <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit fa-sm"></i> Edit
                </a>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left fa-sm"></i> Back to Announcements
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Announcement Content</h6>
                    </div>
                    <div class="card-body">
                        <h2 class="mb-3">{{ $post->title }}</h2>
                        <p class="text-muted mb-4">
                            <i class="fas fa-calendar-alt me-1"></i> Posted on {{ $post->created_at->format('M d, Y') }}
                            @if($post->created_at != $post->updated_at)
                                <span class="ms-3"><i class="fas fa-edit me-1"></i> Updated on {{ $post->updated_at->format('M d, Y') }}</span>
                            @endif
                        </p>
                        
                        @if($post->featured_image)
                            <div class="mb-4 text-center">
                                <img src="{{ Storage::url($post->featured_image) }}" alt="Featured Image" class="img-fluid rounded">
                            </div>
                        @endif
                        
                        <div class="announcement-content">
                            {{ $post->content }}
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Comments ({{ $post->comments->count() }})</h6>
                    </div>
                    <div class="card-body">
                        @if($post->comments->isEmpty())
                            <p class="text-center">No comments yet.</p>
                        @else
                            <div class="comments-list">
                                @foreach($post->comments as $comment)
                                    <div class="comment-item mb-3 pb-3 border-bottom">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div>
                                                <strong>{{ $comment->user->first_name }} {{ $comment->user->last_name }}</strong>
                                                <small class="text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>
                                            <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <p class="mb-0">{{ $comment->content }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('posts.show', $post->id) }}" target="_blank" class="btn btn-info">
                                <i class="fas fa-external-link-alt me-1"></i> View Public Page
                            </a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash me-1"></i> Delete Announcement
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the announcement "{{ $post->title }}"?
                    @if($post->comments->count() > 0)
                        <div class="alert alert-warning mt-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            This announcement has {{ $post->comments->count() }} comments that will also be deleted.
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
