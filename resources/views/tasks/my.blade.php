<x-layout>
    <x-slot name="head">
        <title>My Tasks</title>
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
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
                min-height: 300px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }

            .info {
                color: #ff4500;
            }

            .priority-high {
                color: #dc3545;
                font-weight: bold;
            }

            .priority-medium {
                color: #ffc107;
                font-weight: bold;
            }

            .priority-low {
                color: #28a745;
                font-weight: bold;
            }

            .priority-none {
                color: #adb5bd;
                font-weight: bold;
            }
        </style>
    </x-slot>
    <x-header />
    <x-hero>
        <div class="container mt-5">
            <h2 data-aos="fade-up" data-aos-delay="100"
                style="text-align: center; margin-bottom: 30px; padding-top: 1.2em;">📝 My Tasks</h2>
            <!-- Button to trigger modal -->
<!-- Filter Tasks by Status -->
<form method="GET" action="{{ route('tasks.my') }}" class="mb-3" id="filterForm">
    <div class="d-flex justify-content-between">
        <div>
            <label for="status" class="form-label">Filter by Status</label>
            <select name="status" id="status" class="form-select" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            </select>
        </div>
        <div>
            <label for="priority" class="form-label">Filter by Priority</label>
            <select name="priority" id="priority" class="form-select" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="3" {{ request('priority') == '3' ? 'selected' : '' }}>High</option>
                <option value="2" {{ request('priority') == '2' ? 'selected' : '' }}>Medium</option>
                <option value="1" {{ request('priority') == '1' ? 'selected' : '' }}>Low</option>
            </select>
        </div>
    </div>
</form>




            @foreach ($tasks as $task)
                @php
                    $isPastDue = \Carbon\Carbon::parse($task->due_date)->isPast();
                    $isCompleted = $task->pivot->completed_at !== null;
                    $priorityName = strtolower($task->priority->name ?? 'none');
                @endphp

                <div class="row justify-content-md-center" style="padding-top: 20px">
                    <div class="col-md-auto" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item d-flex position-relative h-100">
                            <div id="card">
                                <h3 class="title">
                                    {{ $task->title }}
                                    <small class="priority-{{ $priorityName }}">
                                        ({{ $task->priority->name ?? 'No Priority' }})
                                    </small>
                                </h3>
                                <h5 class="title">{{ $task->description }}</h5>
                                <h5 class="title">
                                    <strong>Due:</strong> {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                </h5>
                                <h5 class="title">
                                    <strong>Points:</strong> {{ $task->points }}
                                </h5>
                                @if ($isCompleted)
                                    <p class="text-success">✅ Completed</p>
                                @elseif ($isPastDue)
                                    <p class="text-warning">⏳ Past Deadline</p>
                                    <button class="btn btn-sm btn-outline-light" disabled>Unavailable</button>
                                @else
                                    <form method="POST" action="{{ route('tasks.complete', $task->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">✅ Mark as Done</button>
                                    </form>
                                @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="mb-5">
                <h5>Performance Tracking</h5>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {{ $completedTasksPercentage }}%" aria-valuenow="{{ $completedTasksPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small>{{ $completedTasksCount }} of {{ $totalTasksCount }} tasks completed</small>
            </div>

            <div class="mt-6 p-4">
                {{ $tasks->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
        
        
    </x-hero>
    <!-- Modal for Adding/Editing Tasks -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            @if (auth()->user()->roles->isNotEmpty() &&
                    (auth()->user()->roles->first()->name == 'admin' || auth()->user()->roles->first()->name == 'hr'))
                    <button type="button" class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        ➕ Add Course Content
                    </button>
            {{-- <div class="modal-header">
                
                <h5 class="modal-title" id="taskModalLabel">Add New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> --}}
            @endif
            <form method="POST" action="{{ route('tasks.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="taskTitle" class="form-label">Task Title</label>
                        <input type="text" class="form-control" id="taskTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="taskDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="taskDescription" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="taskDueDate" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="taskDueDate" name="due_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="taskPriority" class="form-label">Priority</label>
                        <select class="form-select" id="taskPriority" name="priority_id" required>
                            <option value="1">High</option>
                            <option value="2">Medium</option>
                            <option value="3">Low</option>
                            <option value="4">None</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Task</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.querySelectorAll('select').forEach(function(selectElement) {
        selectElement.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });
</script>
</x-layout>
