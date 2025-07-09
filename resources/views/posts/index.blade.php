<x-layout>
    <x-slot name="head">
        <style>
            /* Pagination Styles */
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

            .text-orange {
                color: #ff4500 !important;
            }

            .bg-orange {
                background-color: #ff4500 !important;
            }

            .border-orange {
                border-color: #ff4500 !important;
            }

            #card {
                background-color: #363636;
                padding: 1rem;
                /* Adds padding around the content */
                border-radius: 8px;
                /* Rounds the corners */
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
                /* Adds a subtle shadow */
            }

            .info {
                color: #ff4500;
            }
        </style>
    </x-slot>
    <x-header />
    <x-hero>
        <div class="container" style="padding-top: 70px">
            <h2 data-aos="fade-up" data-aos-delay="100" style="text-align: center; margin-bottom: 30px;">All Posts</h2>
            <div class="container_posts">
                @foreach ($posts as $post)
                @php
                    $noComments = $post->comments->count();
                @endphp
                    <div style="margin-bottom: 20px" id="card">
                        <h3><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h3>
                        <p>{{ Str::limit($post->content, 150) }} - <small><u style="color: #ff6347"> {{ $noComments }} Comments </u></small></p>
                    </div>
                @endforeach
            </div>

            {{ $posts->links('vendor.pagination.bootstrap-5') }}
        </div>
    </x-hero>
</x-layout>
