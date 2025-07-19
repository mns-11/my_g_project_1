@extends('layouts.main')

@section('title',ucfirst(__('main.reports')))



@section('content')

    <div class="content p-4">
        <h2>{{ucfirst(__('main.reports'))}}</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ucwords(__('main.attendance_and_absence_rates'))}}</h5>
                        <div class="chart-container">
                            <canvas id="attendanceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ucwords(__('main.distribution_of_students_by_colleges'))}}</h5>
                        <div class="chart-container">
                            <canvas id="studentsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const attendanceCtx = document.getElementById('attendanceChart')?.getContext('2d');
        const labelPresent = @json(ucfirst(__('main.present')));
        const labelAbsent = @json(ucfirst(__('main.absent')));
        if (attendanceCtx) {


            new Chart(attendanceCtx, {
                type: 'pie',
                data: {
                    labels: [labelPresent, labelAbsent],
                    datasets: [{
                        data: [{{ $presentCount }}, {{ $absentCount }}],
                        backgroundColor: ['#28a745', '#dc3545']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const value = context.parsed || 0;
                                    const percentage = total > 0
                                        ? `${((value / total) * 100).toFixed(1)}%`
                                        : '0%';
                                    return `${context.label}: ${value} (${percentage})`;
                                }
                            }
                        }
                    }
                }
            });
        }

        const studentsCtx = document.getElementById('studentsChart')?.getContext('2d');
        if (studentsCtx) {
            const label = @json(ucwords(__('main.number_of_students')));
            new Chart(studentsCtx, {
                type: 'bar',
                data: {
                    labels: @json(array_keys($collegesCountsInfo->toArray())),
                    datasets: [{
                        label: label,
                        data: @json(array_values($collegesCountsInfo->toArray())),
                        backgroundColor: '#007bff'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }
    </script>









@endsection
