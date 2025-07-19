@extends('layouts.main')

@section('title',ucwords(__('main.students')))

@section('content')
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #F5F6FA 0%, #E0E6F0 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar {
            background-color: #4A90E2;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand, .nav-link {
            color: #FFFFFF !important;
        }

        .navbar-brand img {
            height: 50px;
            margin-left: 10px;
        }

        .btn-outline-light:hover {
            background-color: #228B22;
        }

        /* Cards */
        .card {
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(237, 171, 72, 0.721);
            padding: 20px;
            border: none;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        /* Buttons */
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

        /* Form elements */
        .form-control,
        .form-select {
            border-radius: 10px;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .modal-content {
            border-radius: 15px;
            overflow: hidden;
        }

        /* Table styles */
        .table thead th {
            background-color: #228B22;
            color: white;
            text-align: center;
        }

        .table tbody td {
            text-align: center;
        }

        /* Badges */
        .badge {
            font-size: 1em;
            padding: 5px 10px;
            border-radius: 10px;
        }

        .badge-success {
            background-color: #2ECC71;
        }

        .badge-danger {
            background-color: #E74C3C;
        }

        .badge-warning {
            background-color: #F39C12;
        }

        .badge-info {
            background-color: #298aea;
        }

        /* Info boxes */
        .info-box {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            padding: 20px;
            text-align: center;
        }

        .info-box h5 {
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }

        .info-box .count {
            font-size: 1.5rem;
            font-weight: bold;
        }

        /* Sidebar (if needed later) */
        .sidebar {
            background-color: #FFFFFF;
            height: 100vh;
            position: fixed;
            top: 0;
            right: 0;
            width: 250px;
            padding: 20px;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .main-content {
            margin-right: 50px;
            padding-top: 10px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-right: 0;
            }
        }
        .info-box {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer; /* يجعل المستخدم يشعر أنها قابلة للنقر */
        }

        .info-box:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
    </style>

    <div class="container mt-5">
        <div class="row justify-content-center text-center mb-4">
            <div class="col-md-3 mb-3">
                <div class="info-box">
                    <h5>{{ucwords(__('main.number_of_attendees'))}}</h5>
                    <div class="count text-success">{{$numberOfAttendees}}</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="info-box">
                    <h5>{{ucwords(__('main.number_of_absentees'))}}</h5>
                    <div class="count text-danger">{{$numberOfAbsentees}}</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="info-box">
                    <h5>{{ucwords(__('main.number_of_latecomers'))}}</h5>
                    <div class="count text-warning">{{$numberOfLatecomers}}</div>
                </div>
            </div>
        </div>

        <div class="card">
            <h4 class="mb-4 text-center">قائمة الطلاب</h4>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ucwords(__('main.enrollment_number'))}}</th>
                        <th>{{ucwords(__('main.name'))}}</th>
                        <th>{{ucwords(__('main.time'))}}</th>
                        <th>{{ucwords(__('main.status'))}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($attendances as $attendance)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$attendance->user->enrollment_number}}</td>
                            <td>{{$attendance->user->name}}</td>
                            <td>{{$attendance->created_at?->format('H:i')}}</td>
                            <td>
                                <span class="badge
                                    @if($attendance->status == \App\Enums\AttendanceStatus::PRESENT)
                                        badge-success
                                    @elseif($attendance->status == \App\Enums\AttendanceStatus::LATE)
                                        badge-warning
                                    @elseif($attendance->status == \App\Enums\AttendanceStatus::ABSENT)
                                         badge-danger
                                    @else
                                        badge-info
                                    @endif">{{(__('main.' . $attendance->status->getName()))}}</span>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.info-box').forEach(function(box) {
            box.addEventListener('click', function () {
                let title = this.querySelector('h5').textContent;
                let count = this.querySelector('.count').textContent;
                alert(` ${title}: ${count}`);
            });
        });
    </script>

@endsection
