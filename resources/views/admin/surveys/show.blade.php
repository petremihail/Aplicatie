<x-admin-layout>
    <div class="container-fluid py-4">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Survey Details</h1>
            <div>
                <a href="{{ route('admin.surveys.edit', $survey->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit fa-sm"></i> Edit
                </a>
                <a href="{{ route('admin.surveys.assign', $survey->id) }}" class="btn btn-primary">
                    <i class="fas fa-user-plus fa-sm"></i> Assign Users
                </a>
                <a href="{{ route('admin.surveys.results', $survey->id) }}" class="btn btn-success">
                    <i class="fas fa-chart-bar fa-sm"></i> View Results
                </a>
                <a href="{{ route('admin.surveys.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left fa-sm"></i> Back to Surveys
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
                        <h6 class="m-0 font-weight-bold text-primary">Survey Information</h6>
                    </div>
                    <div class="card-body">
                        <h4>{{ $survey->title }}</h4>
                        <p class="text-muted">Created on {{ $survey->created_at->format('M d, Y') }}</p>
                        <hr>
                        <h5>Description</h5>
                        <p>{{ $survey->description }}</p>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Survey Questions</h6>
                    </div>
                    <div class="card-body">
                        @if($survey->questions->isEmpty())
                            <p class="text-center">No questions have been added to this survey yet.</p>
                        @else
                            @if($survey->questions && !$survey->questions->isEmpty())
                                <div class="list-group">
                                    @foreach($survey->questions as $index => $question)
                                        <div class="list-group-item">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1">{{ $index + 1 }}. {{ $question->question }}</h5>
                                                <small>{{ ucfirst($question->type) }}</small>
                                            </div>
                                            <!-- @if($question->type == 'multiple_choice' || $question->type == 'scala')
                                                <p class="mb-1">Options:</p>
                                                <ul>
                                                @if($question->options)
                                                    @foreach(json_decode($question->options) as $option)
                                                        <li>{{ $option }}</li>
                                                    @endforeach
                                                    @endif
                                                </ul>
                                            @endif -->
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Assigned Users</h6>
                    </div>
                    <div class="card-body">
                        @if($survey->assignedUsers->isEmpty())
                            <p class="text-center">No users are assigned to this survey.</p>
                        @else
                            <div class="list-group">
                                @foreach($survey->assignedUsers as $user)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $user->first_name }} {{ $user->last_name }}</h6>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                        @php
                                            $hasSubmitted = $survey->submissions->where('user_id', $user->id)->count() > 0;
                                        @endphp
                                        @if($hasSubmitted)
                                            <span class="badge bg-success rounded-pill">Completed</span>
                                        @else
                                            <span class="badge bg-warning rounded-pill">Pending</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Survey Statistics</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6>Total Questions</h6>
                            <h2>{{ $survey->questions->count() }}</h2>
                        </div>
                        <div class="mb-3">
                            <h6>Assigned Users</h6>
                            <h2>{{ $survey->assignedUsers->count() }}</h2>
                        </div>
                        <div>
                            <h6>Completion Rate</h6>
                            @php
                                $totalAssigned = $survey->assignedUsers->count();
                                $totalSubmitted = $survey->submissions->count();
                                $completionRate = $totalAssigned > 0 ? round(($totalSubmitted / $totalAssigned) * 100) : 0;
                            @endphp
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ $completionRate }}%;" 
                                     aria-valuenow="{{ $completionRate }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ $completionRate }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
