
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
        {{-- <div class="container">
            @unless (count($users) == 0)
                @foreach ($users as $user)
                    <div class="user">
                        <h2>{{ $user->first_name }}</h2>
                        <h2>{{ $user->last_name }}</h2>
                        <p>{{ $user->email }}</p>
                        <hr>
                    </div>
                @endforeach
            @else
                <p>No users found</p>
            @endunless
            </div>
            <div class="mt-6 p-4">
                {{ $users->links('vendor.pagination.custom') }}
            </div> --}}
        <div class="container" style="padding-top: 70px">
            @unless ($users->isEmpty())
                @foreach ($users->chunk(2) as $userChunk)
                    <div class="row" style="padding-top: 20px">
                        @foreach ($userChunk as $user)
                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                                <div class="service-item d-flex position-relative h-100">
                                    <div id="card">
                                        <h3 class="title">
                                            <a href="{{ url('/users/manage/' . $user->id) }}" class="stretched-link">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </a>
                                        </h3>
                                        <h5 class="title">
                                            @if ($user->email)
                                                <span class="info"> Email: </span>{{ $user->email }}
                                            @endif
                                        </h5>
                                        <h5 class="title">
                                            @if ($user->phone)
                                                <span class="info">Phone: </span>{{ $user->phone }}
                                            @endif
                                        </h5>
                                        <h5 class="title">
                                            @if ($user->salary)
                                                <span class="info">Salary: </span>{{ $user->salary }}
                                            @endif
                                        </h5>
                                        <h5 class="title">
                                            @if ($user->previous_jobs)
                                                <span class="info">Previous jobs: </span>{{ $user->previous_jobs }}
                                            @endif
                                        </h5>
                                        <h5 class="title">
                                            @if ($user->skills)
                                                <span class="info">Skills: </span>{{ $user->skills }}
                                            @endif
                                        </h5>
                                        <h5 class="title">
                                            @if ($user->education)
                                                <span class="info">Eduaction: </span>{{ $user->education }}
                                            @endif
                                        </h5>
                                        <h5 class="title">
                                            @if ($user->address)
                                                <span class="info">Adress: </span>{{ $user->address }}
                                            @endif
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @else
                <p class="description">No users found</p>
            @endunless
            <div class="mt-6 p-4">
                {{ $users->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>


    </x-hero>
</x-layout>
