<x-admin-layout>
    <div class="container-fluid py-4">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Task Details</h1>
            <div>
                <a href="{{ route('admin.tasks.edit', $task->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit fa-sm"></i> Edit
                </a>
                <a href="{{ route('admin.tasks.assign', $task->id) }}" class="btn btn-primary">
                    <i class="fas fa-user-plus fa-sm"></i> Assign Users
                </a>
                <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left fa-sm"></i> Back to Tasks
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
                        <h6 class="m-0 font-weight-bold text-primary">Task Information</h6>
                    </div>
                    <div class="card-body">
                        <h4>{{ $task->title }}</h4>
                        <div class="d-flex align-items-center mb-3">
                            <span class="me-3">
                                @if($task->priority)
                                    @if($task->priority->name == 'High')
                                        <span class="badge bg-danger">High Priority</span>
                                    @elseif($task->priority->name == 'Medium')
                                        <span class="badge bg-warning">Medium Priority</span>
                                    @else
                                        <span class="badge bg-info">Low Priority</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">No Priority</span>
                                @endif
                            </span>
                            <span class="me-3">
                                <i class="fas fa-calendar-alt me-1"></i> Due: {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                            </span>
                            <span>
                                <i class="fas fa-trophy me-1"></i> Points: {{ $task->points ?? 'N/A' }}
                            </span>
                        </div>
                        <hr>
                        <h5>Description</h5>
                        <p>{{ $task->description }}</p>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Task Progress</h6>
                    </div>
                    <div class="card-body">
                        @php
                            $completedCount = $task->users->filter(function($user) {
                                return $user->pivot->completed_at !== null;
                            })->count();
                            $totalCount = $task->users->count();
                            $progressPercentage = $totalCount > 0 ? round(($completedCount / $totalCount) * 100) : 0;
                        @endphp
                        <h5>Overall Completion: {{ $progressPercentage }}%</h5>
                        <div class="progress mb-4">
                            <div class="progress-bar {{ $progressPercentage == 100 ? 'bg-success' : 'bg-warning' }}" role="progressbar" style="width: {{ $progressPercentage }}%;" aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>{{ $completedCount }} of {{ $totalCount }} users completed</span>
                            <span>
                                @if($progressPercentage == 100)
                                    <i class="fas fa-check-circle text-success"></i> Completed
                                @elseif($progressPercentage > 0)
                                    <i class="fas fa-clock text-warning"></i> In Progress
                                @else
                                    <i class="fas fa-times-circle text-danger"></i> Not Started
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Assigned Users</h6>
                        <a href="{{ route('admin.tasks.assign', $task->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-user-plus fa-sm"></i> Assign Users
                        </a>
                    </div>
                    <div class="card-body">
                        @if($task->users->isEmpty())
                            <p class="text-center">No users are assigned to this task.</p>
                        @else
                            <div class="list-group">
                                @foreach($task->users as $user)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $user->first_name }} {{ $user->last_name }}</h6>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                        @if($user->pivot->completed_at)
                                            <span class="badge bg-success">Completed</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Task Timeline</h6>
                    </div>
                    <div class="card-body">
                        <ul class="timeline">
                            <li class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h5 class="timeline-title">Task Created</h5>
                                    <p class="timeline-date">{{ $task->created_at->format('M d, Y') }}</p>
                                </div>
                            </li>
                            @foreach($task->users->sortBy(function($user) {
                                return $user->pivot->completed_at ?? PHP_INT_MAX;
                            }) as $user)
                                @if($user->pivot->completed_at)
                                    <li class="timeline-item">
                                        <div class="timeline-marker bg-success"></div>
                                        <div class="timeline-content">
                                            <h5 class="timeline-title">{{ $user->first_name }} {{ $user->last_name }} completed the task</h5>
                                            <p class="timeline-date">{{ \Carbon\Carbon::parse($user->pivot->completed_at)->format('M d, Y') }}</p>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                            @if($progressPercentage == 100)
                                <li class="timeline-item">
                                    <div class="timeline-marker bg-success"></div>
                                    <div class="timeline-content">
                                        <h5 class="timeline-title">Task Completed by All Users</h5>
                                        <p class="timeline-date">{{ $task->users->sortByDesc(function($user) {
                                            return $user->pivot->completed_at;
                                        })->first()->pivot->completed_at->format('M d, Y') }}</p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .timeline {
            position: relative;
            padding-left: 30px;
            list-style: none;
        }
        .timeline-item {
            position: relative;
            padding-bottom: 20px;
        }
        .timeline-marker {
            position: absolute;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background-color: #4e73df;
            left: -30px;
            top: 5px;
        }
        .timeline-content {
            padding-bottom: 10px;
            border-bottom: 1px solid #e3e6f0;
        }
        .timeline-title {
            margin-bottom: 5px;
            font-size: 1rem;
        }
        .timeline-date {
            color: #858796;
            font-size: 0.8rem;
            margin-bottom: 0;
        }
    </style>
</x-admin-layout>
