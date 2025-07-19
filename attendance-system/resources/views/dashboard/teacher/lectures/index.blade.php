@extends('layouts.main')

@section('title',ucwords(__('main.lectures')))

@section('content')

    <style>
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

    <div class="row mt-5 animate_animated animate_fadeIn">
        <div class="col-11" style=" margin-left: 100px; margin-right: 100px;  border: none;
      border-radius: 30px;
      box-shadow: 0 6px 20px rgba(237, 171, 72, 0.72);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      margin-bottom: 20px;
      background: linear-gradient(45deg, #228B22, #FFA500);
      color: #fff;
      padding: 20px;" >
            <div class="p-4" >
                <div class="col-md-8 col-xl-9">
                    <h4 class="mb-4">{{ucwords(__('main.lectures'))}}</h4>

                    <form method="GET" action="{{ \LaravelLocalization::localizeURL(route('teacher.lectures.index')) }}"
                          id="search-form">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <select
                                    name="course_id"
                                    class="select2-with-menu-bg form-control @error('course_id') is-invalid @enderror"
                                    id="menu-bg"
                                    data-bgcolor="light"
                                    data-bgcolor-variation="accent-3"
                                    data-text-color="white">
                                    <option value="">{{ ucwords(__('main.select_course')) }}</option>
                                    @foreach($courses as $key => $course)
                                            <option
                                                value="{{ $course->id }}" {{ (old('course_id', request()->query('course_id')) == $course->id) ? 'selected' : '' }}>{{ $course->name }}</option>
                                        @endforeach
                                </select>
                                @error('course_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-5">
                                <select
                                    name="status"
                                    class="select2-with-menu-bg form-control @error('status') is-invalid @enderror"
                                    id="menu-bg"
                                    data-bgcolor="light"
                                    data-bgcolor-variation="accent-3"
                                    data-text-color="white">
                                    <option value="">{{ ucwords(__('main.select_status')) }}</option>
                                    <option value="1" {{ (old('status', request()->query('status')) == 1) ? 'selected' : '' }}>{{ __('main.ongoing') }}</option>
                                    <option value="2" {{ (old('status', request()->query('status')) == 2) ? 'selected' : '' }}>{{ __('main.upcoming') }}</option>
                                    <option value="3" {{ (old('status', request()->query('status')) == 3) ? 'selected' : '' }}>{{ __('main.finished') }}</option>
                                </select>

                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    {{ ucfirst(__('main.submit')) }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <br>

                <div class="table-responsive">
                    <table class="table table-hover ">
                        <thead>
                        <tr>
                            <th style="background-color: #228B22; color: white;">{{ucwords(__('main.course_name'))}}</th>
                            <th style="background-color: #228B22; color: white;">{{ucwords(__('main.date'))}}</th>
                            <th style="background-color: #228B22; color: white;">{{ucwords(__('main.time'))}}</th>
                            <th style="background-color: #228B22; color: white;">{{ucwords(__('main.duration')) . ' ' . '(' . __('main.hour') . ')'}}</th>
                            <th style="background-color: #228B22; color: white;">{{ucwords(__('main.hall'))}}</th>
                            <th style="background-color: #228B22; color: white;">{{ucwords(__('main.status'))}}</th>
                            <th style="background-color: #228B22; color: white;">{{ucwords(__('main.action'))}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lectures as $lecture)
                            <tr>
                                <td>{{$lecture->course->name}}</td>
                                <td>{{$lecture->datetime->format('Y-m-d')}}</td>
                                <td>{{$lecture->datetime->format('H:i')}}</td>
                                <td>{{$lecture->duration}}</td>
                                <td>{{$lecture->hall}}</td>
                                <td>
                                    @php
                                        $timezone = 'Asia/Riyadh';
                                        $now = \Carbon\Carbon::now($timezone);
                                        $start = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $lecture->datetime, $timezone);
                                        $end = $start->copy()->addHours($lecture->duration);

                                    @endphp

{{--                                    {{'Now: ' . $now . ' start: '. $start . ' end: ' . $end }}<br>--}}

                                    @if($now >= $start && $now <= $end)
                                        {{ __('main.ongoing') }}
                                    @elseif($now < $start)
                                        {{ __('main.upcoming') }}
                                    @else
                                        {{ __('main.finished') }}
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        <a href="{{route('lectures.edit', $lecture->id)}}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{route('lectures.students.view', $lecture->id)}}" class="btn btn-info btn-sm">
                                            {{ucwords(__('main.view_students'))}}
                                        </a>

                                        @if(empty($lecture->qrCode->image_path))
                                            <form action="{{route('lectures.generate.qr.code', $lecture->id)}}" method="post" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-secondary">
                                                    {{ucwords(__('main.generate_qr_code'))}}
                                                </button>
                                            </form>
                                        @else
                                        <a type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#qrModal">{{ucwords(__('main.view_qr_code'))}}</a>
                                        <div class="modal show==" id="qrModal" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <div id="qrContainer">
                                                            <img src="{{Storage::url($lecture->qrCode->image_path)}}" alt="qr code">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" data-bs-dismiss="modal">{{ucfirst(__('main.close'))}}</button>
                                                        <button class="btn btn-primary" id="downloadQrBtn">{{ucfirst(__('main.download'))}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <script>
                                        document.getElementById('downloadQrBtn').addEventListener('click', function() {
                                            const link = document.createElement('a');
                                            link.href = "{{ asset('storage/qr_codes/68376dfc630dd.svg') }}";
                                            link.download = 'qr_code_lecture.svg';
                                            document.body.appendChild(link);
                                            link.click();
                                            document.body.removeChild(link);
                                        });
                                    </script>

                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if ($lectures instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        {{ $lectures->appends(['search' => request()->query('search'), 'course_id' => request()->query('course_id'), 'status' => request()->query('status')])->links('pagination::bootstrap-4') }}
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
