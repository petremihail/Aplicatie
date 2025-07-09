<x-admin-layout>
    <div class="container-fluid py-4">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Survey Results: {{ $survey->title }}</h1>
            <a href="{{ route('admin.surveys.show', $survey->id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left fa-sm"></i> Back to Survey
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Overview</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Survey Information</h5>
                        <p><strong>Title:</strong> {{ $survey->title }}</p>
                        <p><strong>Description:</strong> {{ $survey->description }}</p>
                        <p><strong>Created:</strong> {{ $survey->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Participation Statistics</h5>
                        <p><strong>Total Assigned Users:</strong> {{ $survey->assignedUsers->count() }}</p>
                        <p><strong>Total Submissions:</strong> {{ $survey->submissions->count() }}</p>
                        
                        @php
                            $participationRate = $survey->assignedUsers->count() > 0 
                                ? round(($survey->submissions->count() / $survey->assignedUsers->count()) * 100) 
                                : 0;
                        @endphp
                        
                        <p><strong>Participation Rate:</strong> {{ $participationRate }}%</p>
                        <div class="progress mb-4">
                            <div class="progress-bar {{ $participationRate > 75 ? 'bg-success' : ($participationRate > 50 ? 'bg-info' : ($participationRate > 25 ? 'bg-warning' : 'bg-danger')) }}" 
                                role="progressbar" style="width: {{ $participationRate }}%;" 
                                aria-valuenow="{{ $participationRate }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $participationRate }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @foreach($questionStats as $questionId => $data)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Question: {{ $data['question']->question }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Question Details</h5>
                            <p><strong>Type:</strong> {{ ucfirst($data['question']->type) }}</p>
                            <p><strong>Responses:</strong> {{ count($data['answers']) }}</p>
                            
                            @if($data['question']->type === 'scala' && isset($data['stats']['average']))
                                <p><strong>Average Rating:</strong> {{ number_format($data['stats']['average'], 1) }} / 5</p>
                                
                                <h5 class="mt-4">Rating Distribution</h5>
                                @for($i = 1; $i <= 5; $i++)
                                    @php
                                        $count = $data['stats']['distribution'][$i] ?? 0;
                                        $percentage = count($data['answers']) > 0 ? round(($count / count($data['answers'])) * 100) : 0;
                                    @endphp
                                    <div class="mb-1">
                                        <div class="d-flex justify-content-between">
                                            <span>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</span>
                                            <span>{{ $count }} ({{ $percentage }}%)</span>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $percentage }}%;" 
                                                aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                @endfor
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h5>Individual Responses</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Response</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data['answers'] as $answer)
                                            <tr>
                                                <td>{{ $answer['user'] }}</td>
                                                <td>
                                                    @if($data['question']->type === 'scala')
                                                        <div class="d-flex align-items-center">
                                                            {{ $answer['answer'] }}
                                                            <div class="ms-2">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    @if($i <= $answer['answer'])
                                                                        <i class="fas fa-star text-warning"></i>
                                                                    @else
                                                                        <i class="far fa-star text-warning"></i>
                                                                    @endif
                                                                @endfor
                                                            </div>
                                                        </div>
                                                    @else
                                                        {{ $answer['answer'] }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Export Options</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p>Export the survey results in different formats:</p>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-primary" onclick="alert('Export functionality is not implemented yet.')">
                                <i class="fas fa-file-csv me-1"></i> Export as CSV
                            </a>
                            <a href="#" class="btn btn-success" onclick="alert('Export functionality is not implemented yet.')">
                                <i class="fas fa-file-excel me-1"></i> Export as Excel
                            </a>
                            <a href="#" class="btn btn-danger" onclick="alert('Export functionality is not implemented yet.')">
                                <i class="fas fa-file-pdf me-1"></i> Export as PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
