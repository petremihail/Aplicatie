
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
            @unless ($contracts->isEmpty())
                @foreach ($contracts->chunk(2) as $contractsChunk)
                    <div class="row justify-content-md-center" style="padding-top: 20px">
                        @foreach ($contractsChunk as $contract)
                            <div class="col-md-auto" data-aos="fade-up" data-aos-delay="100">
                                <div class="service-item d-flex position-relative h-100">
                                    <div id="card">
                                        <h3 class="title">
                                            {{-- <a href="#" class="stretched-link"> --}}
                                            {{ $contract->name }}
                                            {{-- </a> --}}
                                        </h3>
                                        <h5 class="title">
                                            <span class="info"> Start date: </span>{{ $contract->start_date }}
                                        </h5>
                                        <h5 class="title">
                                            <span class="info">End date: </span>{{ $contract->end_date }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @else
                <div class="row justify-content-md-center" style="padding-top: 20px">
                    <div class="col-md-auto" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item d-flex position-relative h-100">
                            <div id="card">
                                <h3 class="title">
                                    No contracts found
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endunless
            {{-- <div class="mt-6 p-4">
                {{ $users->links('vendor.pagination.bootstrap-5') }}
            </div> --}}
            <div class="row justify-content-md-center" style="padding-top: 20px">
                <div class="col-md-auto" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item d-flex position-relative h-100">
                        <div id="card">
                            <h3 class="title">
                                {{-- <a href="#" class="stretched-link"> --}}
                                {{-- </a> --}}
                            </h3>
                            <h5 class="title">
                                <span class="info"> First name: </span>{{ $details->first_name }}
                            </h5>
                            <h5 class="title">
                                <span class="info">Last name: </span>{{ $details->last_name }}
                            </h5>
                            <h5 class="title">
                                <span class="info"> Phone Number: </span>{{ $details->phone }}
                            </h5>
                            <h5 class="title">
                                <span class="info">Username: </span>{{ $details->username }}
                            </h5>
                            <h5 class="title">
                                <span class="info"> Salary: </span>{{ $details->salary }}
                            </h5>
                            <h5 class="title">
                                <span class="info">Address: </span>{{ $details->username }}
                            </h5>
                            <h5 class="title">
                                <span class="info"> Previous jobs: </span>{{ $details->previous_jobs }}
                            </h5>
                            <h5 class="title">
                                <span class="info">Skills: </span>{{ $details->skills }}
                            </h5>
                            <h5 class="title">
                                <span class="info">Education: </span>{{ $details->education }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="mt-6 p-4">
                {{ $users->links('vendor.pagination.bootstrap-5') }}
            </div> --}}
    </x-hero>
</x-layout>
