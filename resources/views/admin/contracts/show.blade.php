<x-admin-layout>
    <div class="container-fluid py-4">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Contract Details</h1>
            <div>
                <a href="{{ route('admin.contracts.edit', $contract->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit fa-sm"></i> Edit
                </a>
                <a href="{{ route('admin.contracts.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left fa-sm"></i> Back to Contracts
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
                        <h6 class="m-0 font-weight-bold text-primary">Contract Information</h6>
                    </div>
                    <div class="card-body">
                        <h4>{{ $contract->name }}</h4>
                        <div class="d-flex align-items-center mb-3">
                            @php
                                $now = now();
                                $startDate = \Carbon\Carbon::parse($contract->start_date);
                                $endDate = \Carbon\Carbon::parse($contract->end_date);
                            @endphp
                            
                            @if($now < $startDate)
                                <span class="badge bg-info me-2">Upcoming</span>
                            @elseif($now > $endDate)
                                <span class="badge bg-danger me-2">Expired</span>
                            @else
                                <span class="badge bg-success me-2">Active</span>
                            @endif
                            
                            <span class="text-muted">Created on {{ $contract->created_at->format('M d, Y') }}</span>
                        </div>
                        <hr>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5>Start Date</h5>
                                <p>{{ \Carbon\Carbon::parse($contract->start_date)->format('M d, Y') }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5>End Date</h5>
                                <p>{{ \Carbon\Carbon::parse($contract->end_date)->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <h5>Description</h5>
                        <p>{{ $contract->description ?? 'No description provided.' }}</p>
                        
                        <h5 class="mt-4">Terms & Conditions</h5>
                        <div class="card bg-light p-3">
                            <p class="mb-0">{{ $contract->terms ?? 'No terms and conditions specified.' }}</p>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Contract Timeline</h6>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h5 class="timeline-title">Contract Created</h5>
                                    <p class="timeline-date">{{ $contract->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h5 class="timeline-title">Contract Start Date</h5>
                                    <p class="timeline-date">{{ \Carbon\Carbon::parse($contract->start_date)->format('M d, Y') }}</p>
                                </div>
                            </div>
                            @if($now > $startDate)
                                <div class="timeline-item">
                                    <div class="timeline-marker {{ $now > $endDate ? 'bg-danger' : 'bg-success' }}"></div>
                                    <div class="timeline-content">
                                        <h5 class="timeline-title">Contract {{ $now > $endDate ? 'Ended' : 'Currently Active' }}</h5>
                                        @if($now > $endDate)
                                            <p class="timeline-date">Ended on {{ \Carbon\Carbon::parse($contract->end_date)->format('M d, Y') }}</p>
                                        @else
                                            <p class="timeline-date">Will end on {{ \Carbon\Carbon::parse($contract->end_date)->format('M d, Y') }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Assigned Users</h6>
                        <a href="{{ route('admin.contracts.assign', $contract->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-user-plus fa-sm"></i> Assign Users
                        </a>
                    </div>
                    <div class="card-body">
                        @if($contract->users->isEmpty())
                            <p class="text-center">No users have been assigned to this contract.</p>
                        @else
                            <div class="list-group">
                                @foreach($contract->users as $user)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $user->first_name }} {{ $user->last_name }}</h6>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Contract Status</h6>
                    </div>
                    <div class="card-body">
                        @php
                            $totalDays = $startDate->diffInDays($endDate);
                            $daysElapsed = $startDate->diffInDays($now > $endDate ? $endDate : $now);
                            $progressPercentage = $now < $startDate ? 0 : ($now > $endDate ? 100 : round(($daysElapsed / $totalDays) * 100));
                        @endphp
                        
                        <h5>Contract Progress</h5>
                        <div class="progress mb-2">
                            <div class="progress-bar {{ $now > $endDate ? 'bg-danger' : ($now < $startDate ? 'bg-info' : 'bg-success') }}" role="progressbar" style="width: {{ $progressPercentage }}%;" aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100">{{ $progressPercentage }}%</div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <small>{{ \Carbon\Carbon::parse($contract->start_date)->format('M d, Y') }}</small>
                            <small>{{ \Carbon\Carbon::parse($contract->end_date)->format('M d, Y') }}</small>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0">Duration</h5>
                            <span>{{ $totalDays }} days</span>
                        </div>
                        
                        @if($now >= $startDate && $now <= $endDate)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0">Days Elapsed</h5>
                                <span>{{ $daysElapsed }} days</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Days Remaining</h5>
                                <span>{{ $totalDays - $daysElapsed }} days</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .timeline {
            position: relative;
            padding-left: 50px;
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
