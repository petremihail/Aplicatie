<x-layout>
    <x-slot name="head">
        <title>{{ $course->name }}</title>
        {{-- Bootstrap CSS for modal --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    </x-slot>

    <x-header />
    <x-hero>
        <div class="container mt-5">
            @php
                $progress = auth()->user()->progress->where('course_id', $course->id)->first();
                $completedIds = $progress ? json_decode($progress->completed_content_ids, true) : [];
                
                // Get all valid content IDs for this course
                $validContentIds = $course->contents->pluck('id')->toArray();
                
                // Filter out any completed IDs that no longer exist in the course
                $validCompletedIds = array_intersect($completedIds, $validContentIds);
            @endphp

            <p>Progress: {{ count($validCompletedIds) }}/{{ $course->contents->count() }} items completed</p>


            <div class="card p-4 bg-dark text-white shadow rounded">
                <h1 class="text-orange">{{ $course->name }}</h1>
                <span class="badge bg-orange mb-2">{{ ucfirst($course->category) }}</span>
                <p class="mt-3">{{ $course->description }}</p>
                <hr>
                <a href="{{ url('/courses') }}" class="btn btn-secondary mt-4">← Back to Courses</a>
            </div>

            @foreach ($course->contents as $content)
                <div class="content-block my-4">
                    <h4>{{ $content->title }} ({{ strtoupper($content->type) }})</h4>

                    @if ($content->type === 'pdf')
                        <a href="{{ Storage::url($content->file_path) }}" target="_blank">Open PDF</a>
                    @elseif($content->type === 'video')
                        <video controls width="400">
                            <source src="{{ Storage::url($content->file_path) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @endif

                    @if (in_array($content->id, $validCompletedIds))
                        <p class="text-success">✅ Completed</p>
                    @else
                        <form method="POST"
                            action="{{ route('courses.markCompleted', [$course->id, $content->id]) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">✅ Mark as Completed</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    </x-hero>

    {{-- Modal Form for Upload --}}
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white">
                <form method="POST" action="{{ route('course_contents.store', $course->id) }}"
                    enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadModalLabel">Upload Course Content</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select name="type" class="form-control" required>
                                <option value="pdf">PDF</option>
                                <option value="video">Video</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label">File</label>
                            <input type="file" name="file" class="form-control" id="fileInput" required>
                            <p class="text-danger mt-2" id="fileError"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- JS for file size validation and Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('fileInput');
            const file = fileInput.files[0];
            const maxSize = 100 * 1024 * 1024; // 100MB
            const errorText = document.getElementById('fileError');

            if (file && file.size > maxSize) {
                e.preventDefault();
                errorText.textContent = "File size must be less than 100 MB.";
            } else {
                errorText.textContent = "";
            }
        });
    </script>
</x-layout>