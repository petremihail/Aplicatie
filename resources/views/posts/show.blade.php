<x-layout>
    <x-slot name="head">
        <style>
            /* General styling for the comments section */
            .comment-section {
                background-color: #ff63473f;
                padding: 30px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                margin-top: 20px;
            }

            /* Styling for each comment */
            .comment {
                background-color: #ffffff;
                padding: 15px;
                border-radius: 8px;
                margin-bottom: 15px;
                border: 1px solid #ddd;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
                transition: box-shadow 0.3s ease;
            }

            .comment:hover {
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }

            .comment-header {
                font-size: 1.2rem;
                font-weight: bold;
                margin-bottom: 5px;
                color: #323232;
            }

            .comment-time {
                font-size: 0.85rem;
                color: #888;
            }

            .comment-content {
                font-size: 1rem;
                margin-top: 10px;
                color: #323232!important;
                line-height: 1.5;
            }

            /* Form styling */
            .comment-form {
                margin-top: 30px;
                background-color: #ffffff;
                padding: 20px;
                border-radius: 8px;
                border: 1px solid #ddd;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            }

            .comment-form textarea {
                width: 100%;
                border: 1px solid #ddd;
                border-radius: 5px;
                padding: 10px;
                font-size: 1rem;
                box-sizing: border-box;
            }

            .comment-form button {
                background-color: #007bff;
                color: #fff;
                border: none;
                padding: 10px 20px;
                margin-top: 10px;
                border-radius: 5px;
                font-size: 1rem;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            .comment-form button:hover {
                background-color: #0056b3;
            }

            .comment-form a {
                color: #007bff;
                text-decoration: none;
            }

            .comment-form a:hover {
                text-decoration: underline;
            }
            .pagination-container {
                background-color: transparent;
            }

            .pagination .page-link {
                background-color: transparent;
                border: none;
                color: #ff4500;
                /* Orange color to match the design */
            }

            .pagination .page-link.text-muted {
                color: rgba(255, 255, 255, 0.5) !important;
            }

            .pagination .page-item.active .page-link {
                background-color: #ff4500;
                border-color: #ff4500;
                color: white;
            }

            .pagination .page-link:hover {
                color: #ff6347;
                /* Lighter orange on hover */
            }
        </style>
    </x-slot>

    <x-header />
    <x-hero>
        <div class="container" style="padding-top: 10vh">
            <h2>{{ $post->title }}</h2>
            <p>{{ $post->content }}</p>

            <hr>

            <div class="comment-section">
                <h4>Comments</h4>

                @foreach ($comments as $comment)
                    <div class="comment">
                        <div class="comment-header">
                            {{ $comment->user->username }}
                            <span class="comment-time">• {{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="comment-content">{{ $comment->content }}</p>
                    </div>
                @endforeach
                <!-- Pagination Links -->
                <div class="pagination-container">
                    {{ $comments->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
                </div>

                @auth
                    <form action="{{ route('posts.comments.store', $post) }}" method="POST" class="comment-form">
                        @csrf
                        <textarea name="content" class="form-control" rows="3" required></textarea>
                        <button type="submit" class="btn btn-primary mt-2">Add Comment</button>
                    </form>
                @else
                    <p><a href="{{ route('login') }}">Log in</a> to comment.</p>
                @endauth
            </div>
        </div>
    </x-hero>
</x-layout>
