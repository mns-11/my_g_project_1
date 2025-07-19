<!doctype html>
@php
    $dir = \LaravelLocalization::getCurrentLocaleDirection();
    $currentLocale = LaravelLocalization::getCurrentLocale();
@endphp
<html lang="{{$currentLocale}}" dir="{{$dir}}">
<head>
    <meta charset="UTF-8">
    <title>{{__('main.report')}}</title>

    <style>
        body {
            font-family: 'dejavusans', sans-serif;
            background-color: #F5F6FA;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 100%;
            margin: auto;
        }

        .card {
            background-color: #FFA500;
            border-radius: 15px;
            padding: 20px;
            color: #fff;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            text-align: center;
        }

        th, td {
            border: 1px solid #aaa;
            padding: 10px;
            font-size: 14px;
        }

        th {
            background-color: #228B22;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer-card {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            margin-top: 30px;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><strong>{{__('main.report')}} - {{ $date }}</strong></h5>

            <table class="table table-bordered text-center">
                <thead>
                <tr>
                    <th style="background-color:#228B22; color:white;">#</th>
                    <th style="background-color:#228B22; color:white;">{{__('main.name')}}</th>
                    <th style="background-color:#228B22; color:white;">{{ucwords(__('main.enrollment_number'))}}</th>
                    <th style="background-color:#228B22; color:white;">{{ucwords(__('main.college'))}}</th>
                    <th style="background-color:#228B22; color:white;">{{ucwords(__('main.major'))}}</th>
                    <th style="background-color:#228B22; color:white;">{{ucwords(__('main.level'))}}</th>
                    <th style="background-color:#228B22; color:white;">{{ucwords(__('main.course'))}}</th>
                    <th style="background-color:#228B22; color:white;">{{ucwords(__('main.course_type'))}}</th>
                    <th style="background-color:#228B22; color:white;">{{ucwords(__('main.number_of_present'))}} </th>
                    <th style="background-color:#228B22; color:white;"> {{ucwords(__('main.number_of_absences'))}}</th>
                    <th style="background-color:#228B22; color:white;"> {{ucwords(__('main.percentage'))}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['report_data'] as $reda)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $reda['student_name'] ?? '' }}</td>
                        <td>{{ $reda['enrollment_number'] ?? '' }}</td>
                        <td>{{ $reda['college'] ?? '' }}</td>
                        <td>{{ $reda['major'] ?? '' }}</td>
                        <td>{{ $reda['level'] ?? '' }}</td>
                        <td>{{ $reda['course'] ?? '' }}</td>
                        <td>{{ $reda['course_type'] ?? '' }}</td>
                        <td>{{ $reda['present_count'] ?? '' }}</td>
                        <td>{{ $reda['absent_count'] ?? '' }}</td>
                        <td>{{ $reda['percentage'] ?? '' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
