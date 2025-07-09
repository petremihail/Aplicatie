<x-layout>
    <x-slot name="head">
        <title>{{ $course->name }}</title>
    </x-slot>
    
    <x-hero>
        <div class="container mt-5">
            <div class="card p-4 bg-dark text-white shadow rounded">
                <h1 class="text-orange">{{ $course->name }}</h1>
                <p class="mt-3">{{ $course->description }}</p>

                <hr>
                <div class="card p-4 bg-dark text-white shadow rounded">
                    <h1 class="text-orange">{{ $course->name }}</h1>
                    <span class="badge bg-orange mb-2">{{ ucfirst($course->category) }}</span>
                    <p class="mt-3">{{ $course->description }}</p>
                    <hr>
                    <a href="{{ url('/courses') }}" class="btn btn-secondary mt-4">← Back to Courses</a>
                </div>
                <a href="{{ url('/courses') }}" class="btn btn-secondary mt-4">← Back to Courses</a>
            </div>
        </div>
    </x-hero>
</x-layout>
