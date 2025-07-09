<x-admin-layout>
    <div class="container-fluid py-4">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Employee Profile</h1>
            <div>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit fa-sm"></i> Edit
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left fa-sm"></i> Back to Employees
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-4">
                <!-- Profile Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Employee Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img class="img-profile rounded-circle mb-3" src="https://ui-avatars.com/api/?name={{ $user->first_name }}+{{ $user->last_name }}&size=200&background=4e73df&color=ffffff">
                            <h4>{{ $user->first_name }} {{ $user->last_name }}</h4>
                            @if($user->roles->isNotEmpty())
                                <span class="badge bg-primary">{{ $user->roles->first()->name }}</span>
                            @else
                                <span class="badge bg-secondary">No Role</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <h6 class="font-weight-bold">Contact Information</h6>
                            <hr>
                            <p><i class="fas fa-envelope fa-fw me-2"></i> {{ $user->email }}</p>
                            <p><i class="fas fa-phone fa-fw me-2"></i> {{ $user->phone }}</p>
                            <p><i class="fas fa-map-marker-alt fa-fw me-2"></i> {{ $user->address ?? 'No address provided' }}</p>
                        </div>
                        <div>
                            <h6 class="font-weight-bold">Account Information</h6>
                            <hr>
                            <p><i class="fas fa-user fa-fw me-2"></i> {{ $user->username }}</p>
                            <p><i class="fas fa-calendar fa-fw me-2"></i> Joined: {{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <!-- Professional Details -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Professional Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h6 class="font-weight-bold">Salary</h6>
                            <p>{{ $user->salary ? '$'.number_format($user->salary, 2) : 'Not specified' }}</p>
                        </div>
                        <div class="mb-4">
                            <h6 class="font-weight-bold">Skills</h6>
                            <p>{{ $user->skills ?? 'No skills listed' }}</p>
                        </div>
                        <div class="mb-4">
                            <h6 class="font-weight-bold">Education</h6>
                            <p>{{ $user->education ?? 'No education listed' }}</p>
                        </div>
                        <div>
                            <h6 class="font-weight-bold">Previous Jobs</h6>
                            <p>{{ $user->previous_jobs ?? 'No previous jobs listed' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Contracts -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Contracts</h6>
                        <a href="{{ route('admin.contracts.create', ['user_id' => $user->id]) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus fa-sm"></i> Add Contract
                        </a>
                    </div>
                    <div class="card-body">
                        @if($user->contracts->isEmpty())
                            <p class="text-center">No contracts found for this employee.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Contract Name</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->contracts as $contract)
                                        <tr>
                                            <td>{{ $contract->name }}</td>
                                            <td>{{ $contract->start_date }}</td>
                                            <td>{{ $contract->end_date }}</td>
                                            <td>
                                                @php
                                                    $now = now();
                                                    $startDate = \Carbon\Carbon::parse($contract->start_date);
                                                    $endDate = \Carbon\Carbon::parse($contract->end_date);
                                                @endphp
                                                
                                                @if($now < $startDate)
                                                    <span class="badge bg-info">Upcoming</span>
                                                @elseif($now > $endDate)
                                                    <span class="badge bg-danger">Expired</span>
                                                @else
                                                    <span class="badge bg-success">Active</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.contracts.edit', $contract->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
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
        </div>

        <!-- Activity Tabs -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <ul class="nav nav-tabs card-header-tabs" id="activityTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="courses-tab" data-bs-toggle="tab" data-bs-target="#courses" type="button" role="tab" aria-controls="courses" aria-selected="true">Courses</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tasks-tab" data-bs-toggle="tab" data-bs-target="#tasks" type="button" role="tab" aria-controls="tasks" aria-selected="false">Tasks</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="surveys-tab" data-bs-toggle="tab" data-bs-target="#surveys" type="button" role="tab" aria-controls="surveys" aria-selected="false">Surveys</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab" aria-controls="attendance" aria-selected="false">Attendance</button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="activityTabsContent">
                    <div class="tab-pane fade show active" id="courses" role="tabpanel" aria-labelledby="courses-tab">
                        @if($user->courses->isEmpty())
                            <p class="text-center">No courses assigned to this employee.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Course Name</th>
                                            <th>Description</th>
                                            <th>Progress</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->courses as $course)
                                        <tr>
                                            <td>{{ $course->name }}</td>
                                            <td>{{ Str::limit($course->description, 50) }}</td>
                                            <td>
                                                @php
                                                    $progress = $user->progress->where('course_id', $course->id)->first();
                                                    $completed = $progress ? json_decode($progress->completed_content_ids, true) : [];
                                                    $totalContents = $course->contents->count();
                                                    $progressPercentage = $totalContents > 0 ? round((count($completed) / $totalContents) * 100) : 0;
                                                @endphp
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: {{ $progressPercentage }}%;" aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100">{{ $progressPercentage }}%</div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($progressPercentage == 100)
                                                    <span class="badge bg-success">Completed</span>
                                                @elseif($progressPercentage > 0)
                                                    <span class="badge bg-warning">In Progress</span>
                                                @else
                                                    <span class="badge bg-secondary">Not Started</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="tasks" role="tabpanel" aria-labelledby="tasks-tab">
                        @if($user->tasks->isEmpty())
                            <p class="text-center">No tasks assigned to this employee.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Task Title</th>
                                            <th>Description</th>
                                            <th>Due Date</th>
                                            <th>Priority</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->tasks as $task)
                                        <tr>
                                            <td>{{ $task->title }}</td>
                                            <td>{{ Str::limit($task->description, 50) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</td>
                                            <td>
                                                @if($task->priority)
                                                    @if($task->priority->name == 'High')
                                                        <span class="badge bg-danger">High</span>
                                                    @elseif($task->priority->name == 'Medium')
                                                        <span class="badge bg-warning">Medium</span>
                                                    @else
                                                        <span class="badge bg-info">Low</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary">None</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($task->pivot->completed_at)
                                                    <span class="badge bg-success">Completed</span>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="surveys" role="tabpanel" aria-labelledby="surveys-tab">
                        @if($user->assignedSurveys->isEmpty())
                            <p class="text-center">No surveys assigned to this employee.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Survey Title</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Submitted Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->assignedSurveys as $survey)
                                        <tr>
                                            <td>{{ $survey->title }}</td>
                                            <td>{{ Str::limit($survey->description, 50) }}</td>
                                            <td>
                                                @php
                                                    $submission = $user->submissions->where('survey_id', $survey->id)->first();
                                                @endphp
                                                @if($submission)
                                                    <span class="badge bg-success">Submitted</span>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $submission ? \Carbon\Carbon::parse($submission->submitted_at)->format('M d, Y') : 'N/A' }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
                        @if($user->attendances->isEmpty())
                            <p class="text-center">No attendance records found for this employee.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Clock In</th>
                                            <th>Clock Out</th>
                                            <th>Total Hours</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->attendances->sortByDesc('date') as $attendance)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}</td>
                                            <td>{{ $attendance->clock_in }}</td>
                                            <td>{{ $attendance->clock_out ?? 'Not clocked out' }}</td>
                                            <td>
                                                @if($attendance->clock_in && $attendance->clock_out)
                                                    @php
                                                        $clockIn = \Carbon\Carbon::parse($attendance->clock_in);
                                                        $clockOut = \Carbon\Carbon::parse($attendance->clock_out);
                                                        $totalHours = $clockOut->diffInHours($clockIn);
                                                        $totalMinutes = $clockOut->diffInMinutes($clockIn) % 60;
                                                    @endphp
                                                    {{ $totalHours }}h {{ $totalMinutes }}m
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if($attendance->clock_in && $attendance->clock_out)
                                                    <span class="badge bg-success">Complete</span>
                                                @elseif($attendance->clock_in)
                                                    <span class="badge bg-warning">In Progress</span>
                                                @else
                                                    <span class="badge bg-danger">Absent</span>
                                                @endif
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
        </div>
    </div>
</x-admin-layout>
