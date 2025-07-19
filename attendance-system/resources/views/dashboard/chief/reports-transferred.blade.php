@extends('layouts.main')

@section('title',ucwords(__('main.head_of_department_reports')))



@section('content')

    <style>
        /* تنسيق عام */
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #F5F6FA 0%, #E0E6F0 100%);
            min-height: 100vh;
        }
        .navbar {
            background-color: #4A90E2;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand, .nav-link {
            color: #FFFFFF !important;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(237, 171, 72, 0.721);
            transition: transform 0.3s ease;
            margin-bottom: 20px;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .btn-primary {
            background-color: #4A90E2;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #357ABD;
        }
        .btn-success {
            background-color: #2ECC71;
            border: none;
            border-radius: 25px;
        }
        .btn-danger {
            background-color: #E74C3C;
            border: none;
            border-radius: 25px;
        }
        .btn-warning {
            background-color: #F1C40F;
            border: none;
            border-radius: 25px;
        }
        .btn-outline-light:hover{
            background-color: #228B22;
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .modal-content {
            border-radius: 15px;
            overflow: hidden;
        }
        /* المحتوى الرئيسي */
        .content {
            padding: 20px;
        }
        @media (max-width: 768px) {
            .container {
                margin-right: 0 !important;
            }
        }

        .btn {
            border-radius: 25px;
            margin: 0 5px;
        }
        .btn-primary {
            background-color: #228B22;
            border: none;
            padding: 10px 20px;
            transition: background 0.3s;
        }
        .btn-primary:hover {
            background-color: #FFA500;
        }
    </style>


    <div class="container mt-5 content">
        <!-- قسم التقارير المستلمة -->
        <div class="row mt-5 animate__animated animate__fadeIn">
            <div class="col-12">
                <div class="card p-4" style="background: linear-gradient(45deg, #228b22, #ffa600);">
                    <h4 class="mb-4"><strong>{{ucwords(__('main.reports'))}}</strong></h4>
                        <ul class="list-group">
                            @forelse($reports as $index => $report)

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{$report->created_at->format('Y-m-d')}}
                                    <div>
                                        <button class="btn btn-warning btn-sm mr-2"
                                                onclick="toggleSentReport({{ $report->id }}, this)">
                                            {{ucwords(__('main.view_report'))}}
                                        </button>
                                        <a href="{{route('download.pdf', $report->id)}}" class="btn btn-primary btn-sm"
                                           target="_blank">
                                            <i class="fas fa-download"></i> {{ucwords(__('main.download_pdf'))}}
                                        </a>
                                    </div>
                                </li>

                                <div id="sentReportContainer-{{ $report->id }}" class="mt-2 d-none">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center">
                                            <thead style="background-color: #228B22; color: white;">
                                            <tr>
                                                <th style="background-color:#228B22; color:white;">#</th>
                                                <th style="background-color:#228B22; color:white;">{{ucfirst(__('main.name'))}}</th>
                                                <th style="background-color:#228B22; color:white;"> {{ucwords(__('main.enrollment_number'))}}</th>
                                                <th style="background-color:#228B22; color:white;">{{ucfirst(__('main.college'))}}</th>
                                                <th style="background-color:#228B22; color:white;">{{ucfirst(__('main.major'))}}</th>
                                                <th style="background-color:#228B22; color:white;">{{ucfirst(__('main.level'))}}</th>
                                                <th style="background-color:#228B22; color:white;">{{ ucfirst(__('main.course')) }}</th>
                                                <th style="background-color:#228B22; color:white;">{{ ucfirst(__('main.course_type')) }}</th>
                                                <th style="background-color:#228B22; color:white;">{{ucfirst(__('main.number_of_present'))}}</th>
                                                <th style="background-color:#228B22; color:white;">{{ucfirst(__('main.number_of_absences'))}}</th>
                                                <th style="background-color:#228B22; color:white;">{{ucfirst(__('main.percentage'))}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($report->report_data as $reda)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{ $reda['student_name'] ?? ''}}</td>
                                                    <td>{{ $reda['enrollment_number'] ?? ''}}</td>
                                                    <td>{{ $reda['college'] ?? ''}}</td>
                                                    <td>{{ $reda['major'] ?? ''}}</td>
                                                    <td>{{ $reda['level'] ?? ''}}</td>
                                                    <td>{{ $reda['course'] ?? ''}}</td>
                                                    <td>{{ $reda['course_type'] ?? ''}}</td>
                                                    <td>{{ $reda['present_count'] ?? ''}}</td>
                                                    <td>{{ $reda['absent_count'] ?? ''}}</td>
                                                    <td>{{ $reda['percentage'] ?? ''}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @empty
                                <li class="list-group-item text-center">{{ucwords(__('main.no_sent_reports'))}}</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            @if ($reports instanceof \Illuminate\Pagination\LengthAwarePaginator)
                {{ $reports->appends(['search' => request()->query('search')])->links('pagination::bootstrap-4') }}
            @endif
            </div>

        </div>

    <script>
        function toggleSentReport(id, btn) {
            const container = document.getElementById(`sentReportContainer-${id}`);
            if (container.classList.contains('d-none')) {
                container.classList.remove('d-none');
                btn.textContent = '{{ucwords(__('main.hide_report'))}}';
            } else {
                container.classList.add('d-none');
                btn.textContent = '{{ucwords(__('main.view_report'))}}';
            }
        }
    </script>
@endsection
