<!-- performance_index.blade.php -->
<x-admin-layout>
    <div class="container-fluid py-4">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Employee Performance Dashboard</h1>
            <div>
                <button class="btn btn-primary" id="printReport">
                    <i class="fas fa-print fa-sm"></i> Print Report
                </button>
                <button class="btn btn-success" id="exportExcel">
                    <i class="fas fa-file-excel fa-sm"></i> Export to Excel
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Employees</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEmployees }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Average Task Completion</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($avgTaskCompletion, 1) }}%</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-tasks fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Average Course Progress</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($avgCourseProgress, 1) }}%</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Survey Participation Rate</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($surveyParticipationRate, 1) }}%</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-poll fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Employee Performance Overview</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">View Options:</div>
                                <a class="dropdown-item" href="#" data-view="tasks">Task Completion</a>
                                <a class="dropdown-item" href="#" data-view="courses">Course Progress</a>
                                <a class="dropdown-item" href="#" data-view="surveys">Survey Participation</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-view="overall">Overall Performance</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="performanceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Top Performers</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie mb-4">
                            <canvas id="topPerformersChart"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                            @foreach($topPerformers as $index => $performer)
                                <span class="me-2">
                                    <i class="fas fa-circle" style="color: {{ $chartColors[$index % count($chartColors)] }};"></i> {{ $performer->first_name }} {{ $performer->last_name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Employee Performance Table</h6>
                <div class="input-group w-50">
                    <input type="text" class="form-control search-input" placeholder="Search employees..." id="searchInput">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered searchable-table" id="performanceTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Role</th>
                                <th>Task Completion</th>
                                <th>Course Progress</th>
                                <th>Survey Participation</th>
                                <th>Overall Score</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                            <tr>
                                <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                <td>
                                    @if($employee->roles->isNotEmpty())
                                        <span class="badge bg-primary">{{ $employee->roles->first()->name }}</span>
                                    @else
                                        <span class="badge bg-secondary">No Role</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 10px;">
                                            <div class="progress-bar {{ $employee->taskCompletion >= 75 ? 'bg-success' : ($employee->taskCompletion >= 50 ? 'bg-info' : ($employee->taskCompletion >= 25 ? 'bg-warning' : 'bg-danger')) }}" 
                                                role="progressbar" style="width: {{ $employee->taskCompletion }}%;" 
                                                aria-valuenow="{{ $employee->taskCompletion }}" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                        <span>{{ number_format($employee->taskCompletion, 1) }}%</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 10px;">
                                            <div class="progress-bar {{ $employee->courseProgress >= 75 ? 'bg-success' : ($employee->courseProgress >= 50 ? 'bg-info' : ($employee->courseProgress >= 25 ? 'bg-warning' : 'bg-danger')) }}" 
                                                role="progressbar" style="width: {{ $employee->courseProgress }}%;" 
                                                aria-valuenow="{{ $employee->courseProgress }}" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                        <span>{{ number_format($employee->courseProgress, 1) }}%</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 10px;">
                                            <div class="progress-bar {{ $employee->surveyParticipation >= 75 ? 'bg-success' : ($employee->surveyParticipation >= 50 ? 'bg-info' : ($employee->surveyParticipation >= 25 ? 'bg-warning' : 'bg-danger')) }}" 
                                                role="progressbar" style="width: {{ $employee->surveyParticipation }}%;" 
                                                aria-valuenow="{{ $employee->surveyParticipation }}" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                        <span>{{ number_format($employee->surveyParticipation, 1) }}%</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 10px;">
                                            <div class="progress-bar {{ $employee->overallScore >= 75 ? 'bg-success' : ($employee->overallScore >= 50 ? 'bg-info' : ($employee->overallScore >= 25 ? 'bg-warning' : 'bg-danger')) }}" 
                                                role="progressbar" style="width: {{ $employee->overallScore }}%;" 
                                                aria-valuenow="{{ $employee->overallScore }}" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                        <span>{{ number_format($employee->overallScore, 1) }}%</span>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.show', $employee->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $employees->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Performance Chart
                const ctx = document.getElementById('performanceChart').getContext('2d');
                const performanceChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($employeeNames) !!},
                        datasets: [
                            {
                                label: 'Task Completion',
                                data: {!! json_encode($taskCompletionData) !!},
                                backgroundColor: 'rgba(78, 115, 223, 0.8)',
                                borderColor: 'rgba(78, 115, 223, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Course Progress',
                                data: {!! json_encode($courseProgressData) !!},
                                backgroundColor: 'rgba(28, 200, 138, 0.8)',
                                borderColor: 'rgba(28, 200, 138, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Survey Participation',
                                data: {!! json_encode($surveyParticipationData) !!},
                                backgroundColor: 'rgba(246, 194, 62, 0.8)',
                                borderColor: 'rgba(246, 194, 62, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    callback: function(value) {
                                        return value + '%';
                                    }
                                }
                            }
                        }
                    }
                });

                // Top Performers Chart
                const pieCtx = document.getElementById('topPerformersChart').getContext('2d');
                const topPerformersChart = new Chart(pieCtx, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($topPerformerNames) !!},
                        datasets: [{
                            data: {!! json_encode($topPerformerScores) !!},
                            backgroundColor: {!! json_encode($chartColors) !!},
                            hoverBackgroundColor: {!! json_encode($chartColors) !!},
                            hoverBorderColor: "rgba(234, 236, 244, 1)",
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.label + ': ' + context.raw + '%';
                                    }
                                }
                            }
                        }
                    },
                });

                // View options for the performance chart
                document.querySelectorAll('[data-view]').forEach(item => {
                    item.addEventListener('click', function(e) {
                        e.preventDefault();
                        const view = this.getAttribute('data-view');
                        
                        if (view === 'tasks') {
                            performanceChart.data.datasets = [performanceChart.data.datasets[0]];
                        } else if (view === 'courses') {
                            performanceChart.data.datasets = [performanceChart.data.datasets[1]];
                        } else if (view === 'surveys') {
                            performanceChart.data.datasets = [performanceChart.data.datasets[2]];
                        } else if (view === 'overall') {
                            performanceChart.data.datasets = [
                                {
                                    label: 'Overall Performance',
                                    data: {!! json_encode($overallScoreData) !!},
                                    backgroundColor: 'rgba(231, 74, 59, 0.8)',
                                    borderColor: 'rgba(231, 74, 59, 1)',
                                    borderWidth: 1
                                }
                            ];
                        }
                        
                        performanceChart.update();
                    });
                });

                // Print report
                document.getElementById('printReport').addEventListener('click', function() {
                    window.print();
                });

                // Export to Excel (mock functionality)
                document.getElementById('exportExcel').addEventListener('click', function() {
                    alert('Export to Excel functionality would be implemented here.');
                });
            });
        </script>
    </x-slot>
</x-admin-layout>
