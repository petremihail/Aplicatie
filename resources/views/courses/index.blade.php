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

            .btn.bg-orange:hover {
                background-color: #ff6347 !important;
                /* Lighter orange on hover */
                color: #fff !important;
                transition: 0.3s ease-in-out;
            }
            
            .category-title {
                color: #ff4500;
                margin: 30px 0 15px 0;
                border-bottom: 2px solid #ff4500;
                padding-bottom: 10px;
            }
            
            .no-courses {
                color: rgba(255, 255, 255, 0.7);
                font-style: italic;
                padding: 15px 0;
            }
            
            .filter-buttons {
                margin-bottom: 20px;
            }
        </style>
    </x-slot>
    <x-header />
    <x-hero>
        <div class="container" style="padding-top: 70px">
            <!-- Category Filter Buttons -->
            <div class="filter-buttons text-center mb-4">
                <a href="{{ url('/courses') }}" class="btn {{ !request('category') ? 'bg-orange text-white' : 'btn-outline-secondary' }} mx-1">All</a>
                <a href="{{ url('/courses?category=junior') }}" class="btn {{ request('category') == 'junior' ? 'bg-orange text-white' : 'btn-outline-secondary' }} mx-1">Junior</a>
                <a href="{{ url('/courses?category=mid') }}" class="btn {{ request('category') == 'mid' ? 'bg-orange text-white' : 'btn-outline-secondary' }} mx-1">Mid-Level</a>
                <a href="{{ url('/courses?category=advanced') }}" class="btn {{ request('category') == 'advanced' ? 'bg-orange text-white' : 'btn-outline-secondary' }} mx-1">Advanced</a>
            </div>

            @unless ($courses->isEmpty())
                @if(request('category'))
                    <!-- Single Category View (with pagination) -->
                    <h2 class="category-title">{{ ucfirst(request('category')) }} Courses</h2>
                    @foreach ($courses->chunk(2) as $courseChunk)
                        <div class="row" style="padding-top: 20px">
                            @foreach ($courseChunk as $course)
                                <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                                    <div class="service-item d-flex position-relative h-100">
                                        <div id="card">
                                            <h3 class="title">
                                                {{ $course->name }}
                                            </h3>
                                            <h5 class="title">
                                                <span class="info"> Description: </span>{{ $course->description }}
                                            </h5>
                                            <span class="badge bg-orange">{{ ucfirst($course->category) }}</span>

                                            <div class="mt-3">
                                                @if ($user && $user->courses->contains($course->id))
                                                    <a href="{{ url('/courses/view/' . $course->id) }}"
                                                        class="btn bg-orange text-white px-4 py-2 rounded">
                                                        View Course
                                                    </a>
                                                @else
                                                    <form action="{{ url('/courses/take/' . $course->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn bg-orange text-white px-4 py-2 rounded">
                                                            Take It
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @else
                    <!-- All Categories View (with pagination) -->
                    @foreach ($courses->chunk(2) as $courseChunk)
                        <div class="row" style="padding-top: 20px">
                            @foreach ($courseChunk as $course)
                                <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                                    <div class="service-item d-flex position-relative h-100">
                                        <div id="card">
                                            <h3 class="title">
                                                {{ $course->name }}
                                            </h3>
                                            <h5 class="title">
                                                <span class="info"> Description: </span>{{ $course->description }}
                                            </h5>
                                            <span class="badge bg-orange">{{ ucfirst($course->category) }}</span>

                                            <div class="mt-3">
                                                @if ($user && $user->courses->contains($course->id))
                                                    <a href="{{ url('/courses/view/' . $course->id) }}"
                                                        class="btn bg-orange text-white px-4 py-2 rounded">
                                                        View Course
                                                    </a>
                                                @else
                                                    <form action="{{ url('/courses/take/' . $course->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn bg-orange text-white px-4 py-2 rounded">
                                                            Take It
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @endif
                
                <!-- Pagination -->
                <div class="mt-6 p-4">
                    {{ $courses->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                </div>
            @else
                <p class="description">No courses found</p>
            @endunless
        </div>
    </x-hero>
</x-layout>