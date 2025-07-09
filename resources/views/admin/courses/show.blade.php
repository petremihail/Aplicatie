<x-admin-layout>
    <div class="container-fluid py-4">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Course Details</h1>
            <div>
                <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit fa-sm"></i> Edit
                </a>
                <!-- <a href="{{ route('course_contents.create', $course->id) }}" class="btn btn-success">
                    <i class="fas fa-plus fa-sm"></i> Add Content
                </a> -->
                <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left fa-sm"></i> Back to Courses
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
            <div class="col-xl-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Course Information</h6>
                    </div>
                    <div class="card-body">
                        <h4>{{ $course->name }}</h4>
                        <p class="text-muted">Created on {{ $course->created_at->format('M d, Y') }}</p>
                        <hr>
                        <h5>Description</h5>
                        <p>{{ $course->description }}</p>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Course Content</h6>
                        <!-- <a href="{{ route('course_contents.create', $course->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus fa-sm"></i> Add Content
                        </a> -->
                    </div>
                    <div class="card-body">
                        @if($course->contents->isEmpty())
                            <p class="text-center">No content has been added to this course yet.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Added On</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($course->contents as $content)
                                        <tr>
                                            <td>{{ $content->title }}</td>
                                            <td>{{ ucfirst($content->type) }}</td>
                                            <td>{{ $content->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <!-- <a href="{{ asset('storage/course_contents/' . $content->file_path) }}" target="_blank" class="btn btn-info btn-sm"> -->
                                                    <a href="{{ Storage::url($content->file_path) }}" target="_blank" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <form action="{{ route('admin.course_contents.destroy', $content->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this content?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Enrolled Users</h6>
                        <a href="{{ route('admin.courses.assign', $course->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-user-plus fa-sm"></i> Assign Users
                        </a>
                    </div>
                    <div class="card-body">
                        @if($course->users->isEmpty())
                            <p class="text-center">No users are enrolled in this course.</p>
                        @else
                            <div class="list-group">
                                @foreach($course->users as $user)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $user->first_name }} {{ $user->last_name }}</h6>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                        @php
                                            $progress = $user->progress->where('course_id', $course->id)->first();
                                            $completed = $progress ? json_decode($progress->completed_content_ids, true) : [];
                                            $totalContents = $course->contents->count();
                                            $progressPercentage = $totalContents > 0 ? round((count($completed) / $totalContents) * 100) : 0;
                                        @endphp
                                        <span class="badge bg-primary rounded-pill">{{ $progressPercentage }}%</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Course Statistics</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6>Total Content</h6>
                            <h2>{{ $course->contents->count() }}</h2>
                        </div>
                        <div class="mb-3">
                            <h6>Enrolled Users</h6>
                            <h2>{{ $course->users->count() }}</h2>
                        </div>
                        <div>
                            <h6>Completion Rate</h6>
                            @php
                                $completedCount = 0;
                                foreach($course->users as $user) {
                                    $progress = $user->progress->where('course_id', $course->id)->first();
                                    $completed = $progress ? json_decode($progress->completed_content_ids, true) : [];
                                    if ($course->contents->count() > 0 && count($completed) == $course->contents->count()) {
                                        $completedCount++;
                                    }
                                }
                                $completionRate = $course->users->count() > 0 ? round(($completedCount / $course->users->count()) * 100) : 0;
                            @endphp
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ $completionRate }}%;" aria-valuenow="{{ $completionRate }}" aria-valuemin="0" aria-valuemax="100">{{ $completionRate }}%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
