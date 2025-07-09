<x-layout>
    <x-slot name="head">
        <style>
            .pagination-container {
                background-color: transparent;
            }

            .pagination .page-link {
                background-color: transparent;
                border: none;
                color: #ff4500;
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
            }
        </style>
    <x-header />
    <x-hero>
        <div class="container">
            <h2 data-aos="fade-up" data-aos-delay="100" style="text-align: center; margin-bottom: 30px;">Available Surveys</h2>

        
            @foreach ($surveys as $survey)
            <div class="row justify-content-md-center" style="padding-top: 20px">
                    <div class="col-md-auto" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item d-flex position-relative h-100">
                            <div id="card">
                                <h3 class="title">
                                    {{ $survey->title }}
                                </h3>
                                <h5 class="title">{{ $survey->description }}</h5>
                                <h5 class="title">
                                    @if ($survey->user_submitted > 0)
                                        <span class="btn btn-secondary disabled">Already Submitted</span>
                                    @else
                                        <a href="{{ route('surveys.show', $survey) }}" class="btn btn-primary">Take Survey</a>
                                    @endif
                                </h5>
                                
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="mt-6 p-4" >
                {{ $surveys->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </x-hero>
</x-layout>