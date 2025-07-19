@extends('layouts.main')

@section('title',ucwords(__('main.attendance_and_absence_management')))



@section('content')
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #F5F6FA 0%, #E0E6F0 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .sidebar {
            position: fixed;
            top: 0;
            right: 0;
            height: 100%;
            width: 250px;
            background: linear-gradient(45deg, #FFA500, #228B22);
            padding-top: 20px;
            color: white;
            transition: all 0.3s;
            box-shadow: 0 4px 15px #e0a800;
            z-index: 100;
        }
        .sidebar h3 {
            margin-bottom: 20px;
        }
        .sidebar a {
            color: white;
            padding: 15px 20px;
            text-decoration: none;
            display: block;
            font-size: 16px;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background-color: #228B22;
        }
        .content {
            margin-right: 250px;
            padding: 40px;
            transition: margin 0.3s;
        }
        @media (max-width: 992px) {
            .sidebar {
                width: 200px;
            }
            .content {
                margin-right: 200px;
                padding: 30px;
            }
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .content {
                margin-right: 0;
                padding: 20px;
            }
        }
        .card {
            border: none;
            border-radius: 30px;
            box-shadow: 0 6px 20px rgba(237, 171, 72, 0.721);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 20px;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        .btn {
            border-radius: 25px;
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
        .btn-success {
            background-color: #28a745;
            border: none;
            border-radius: 25px;
            transition: background 0.3s;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
            border-radius: 25px;
            transition: background 0.3s;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }

        /* Table Container */
        .table-container {
            width: 100%;
            overflow-x: auto;
            margin-top: 20px;
        }

        .table {
            background-color: #FFA500;
            border-radius: 10px;
            overflow: hidden;
            min-width: 700px; /* Minimum width for table */
        }
        .table th, .table td {
            padding: 12px;
            text-align: center;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .table th, .table td {
                padding: 8px;
                font-size: 14px;
            }
            .btn {
                padding: 6px 12px;
                font-size: 14px;
            }
        }

        /* Header Styles */
        .header-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 20px;
        }

        @media (min-width: 576px) {
            .header-container {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
        }

        /* Modal styles */
        .modal-content {
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: linear-gradient(45deg, #228B22, #FFA500);
            color: white;
            border-radius: 20px 20px 0 0 !important;
        }

        .btn-close {
            filter: invert(1);
        }

        /* Badge for attendance status */
        .badge-present {
            background-color: #28a745;
            padding: 5px 10px;
            border-radius: 20px;
        }

        .badge-absent {
            background-color: #dc3545;
            padding: 5px 10px;
            border-radius: 20px;
        }
    </style>

    <div class="content p-4">
        <div class="header-container">
            <h2>{{ ucwords(__('main.attendance_and_absence_management'))}}</h2>
            <div class="d-flex flex-wrap gap-2">
                <form class="position-relative" method="GET" action="{{route('attendances.index') }}" id="search-form">
                    <input type="text" class="form-control" id="search-staff" placeholder="{{ucwords(__('main.search_here'))}}"
                           style="max-width: 250px;" onkeyup="searchTable('staff')" value="{{ request()->query('search') }}"
                           oninput="searchFormSubmit()" name="search"/>

                    @error('search', 'searchErrors')
                    <span class="validation-text text-danger">{{ $message }}</span>
                    @enderror
                </form>
                <a href="{{route('attendances.create')}}" class="btn btn-primary" >
                    <i class="fas fa-plus me-1"></i>{{ucwords(__('main.record_attendance'))}}
                </a>
            </div>
        </div>

        <script>
            let timeout;

            function searchFormSubmit() {
                clearTimeout(timeout);
                timeout = setTimeout(function() {
                    document.getElementById('search-form').submit();
                }, 750);
            }
        </script>

        <div class="table-container">
            <table class="table table-striped" id="staff-table">
                <thead>
            <tr>
                <th style="background-color:#218838 ;color: white;">#</th>
                <th style="background-color:#218838 ;color: white;">{{ucwords(__('main.student_name'))}}</th>
                <th style="background-color:#218838 ;color: white;">{{ucwords(__('main.enrollment_number'))}}</th>
                <th style="background-color:#218838 ;color: white;">{{ucwords(__('main.course'))}}</th>
                <th style="background-color:#218838 ;color: white;">{{ucwords(__('main.course_type'))}}</th>
                <th style="background-color:#218838 ;color: white;">{{ucwords(__('main.date'))}}</th>
                <th style="background-color:#218838 ;color: white;"> {{ucwords(__('main.status'))}}</th>
                <th style="background-color:#218838 ;color: white;">{{ucwords(__('main.actions'))}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($attendances as $attendance)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$attendance->user->name}}</td>
                    <td>{{$attendance->user->enrollment_number}}</td>
                    <td>{{$attendance->course->name}}</td>
                    <td>{{__('main.' . $attendance->course->type->getName())}}</td>
                    <td>{{$attendance->date}}</td>
                    <td><span class="badge-{{$attendance->status->name == 'PRESENT' ? 'present' : 'absent' }}">{{(__('main.' . $attendance->status->getName()))}}</span></td>
                    <td>
                        <a href="{{route('attendances.edit', $attendance->id)}}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> {{ucwords(__('main.edit'))}}</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @if ($attendances instanceof \Illuminate\Pagination\LengthAwarePaginator)
            {{ $attendances->appends(['search' => request()->query('search')])->links('pagination::bootstrap-4') }}
        @endif
    </div>


@endsection
