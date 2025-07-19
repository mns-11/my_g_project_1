@extends('layouts.main')

@section('title',ucwords(__('main.manual_attendance')))

@section('content')

    <style>
        /* إعدادات عامة */
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #F5F6FA 0%, #E0E6F0 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
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
            background-color: #228B22;
        }
        .btn-primary{
            background-color:#FFA500 ;
            margin-left: 30%;
            margin-right: 30%;

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
        .btn-outline-light:hover{
            background-color: #228B22;
        }
        .form-control, .form-select {
            border-radius: 10px;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        .form-label{
            margin-right: 2%;
        }
        .modal-content {
            border-radius: 15px;
            overflow: hidden;
        }
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
        /* المحتوى الرئيسي مع ضبط الهوامش */
        .main-content {
            margin-right: 50px; /* مساحة الشريط الجانبي + هامش إضافي */
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

    </style>
    <div class="row mt-5 animate_animated animate_fadeIn">
        <div class="container">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <div class="card" style="background: linear-gradient(45deg, #228b22, #ffa600);">
                        <h3 class="text-center mb-4" style="margin-top: 2%;"><strong>{{ucwords(__('main.manual_attendance_recording'))}}</strong></h3>
                        <form id="studentSearchForm" action="{{route('manual.attendance')}}" method="GET">
                            @csrf
                            <div class="mb-3" style="padding-left: 2%; padding-right: 2%;">
                                <label for="search" class="form-label"><strong>{{ucwords(__('main.search_for_student'))}}</strong></label>
                                <input type="text" class="form-control" id="search" name="search" placeholder="{{ucwords(__('main.search_for_student'))}}" value="{{request()->query('search')}}">
                            </div>
                            <div class="col-12">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary mb-3">{{ucfirst(__('main.search'))}}</button>

                                </div>
                            </div>
                        </form>

                        @if(!empty($user))
                            <div id="studentInfo">
                                <h4 class="text-center mb-3">{{ ucwords(__('main.student_data')) }}</h4>
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">{{ ucwords(__('main.student_number')) }}</label>
                                                    <p class="form-control-static" id="studentId">{{ $user->enrollment_number }}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">{{ ucwords(__('main.student_name')) }}</label>
                                                    <p class="form-control-static" id="studentName">{{ $user->name }}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">{{ ucwords(__('main.college')) }}</label>
                                                    <p class="form-control-static" id="college">{{ $user->college_name }}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">{{ ucwords(__('main.major')) }}</label>
                                                    <p class="form-control-static" id="department">{{ $user->major_name }}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">{{ ucwords(__('main.level')) }}</label>
                                                    <p class="form-control-static" id="level">{{ $user->level_name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form id="attendanceForm" action="{{ route('manual.attendance.post') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">

                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="lectureSelect" class="form-label fw-bold">{{ ucwords(__('main.lecture')) }}</label>
                                                    <h6 class="text-danger">{{ucwords(__('main.only_today_lectures'))}}</h6>
                                                <select class="form-select @error('lecture_id') is-invalid @enderror"
                                                        id="lectureSelect" required name="lecture_id">
                                                    <option value="" disabled selected>{{ ucwords(__('main.select_lecture')) }}</option>
                                                    @foreach($lectures as $lecture)
                                                        <option value="{{ $lecture->id }}"
                                                            {{ old('lecture_id') == $lecture->id ? 'selected' : '' }}>
                                                            {{ $lecture->datetime?->format('H:i') }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('lecture_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                               id="attendanceSwitch" name="attendance" value="1" checked>
                                                        <label class="form-check-label fw-bold" for="attendanceSwitch">
                                                            {{ ucwords(__('main.present')) }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-success btn-lg">
                                                        <i class="fas fa-save me-2"></i>
                                                        {{ __('main.save') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <script>
                                document.getElementById('attendanceForm').addEventListener('submit', async function(e) {
                                    e.preventDefault();

                                    const form = e.target;
                                    const formData = new FormData(form);
                                    const submitBtn = form.querySelector('button[type="submit"]');
                                    const originalBtnText = submitBtn.innerHTML;

                                    submitBtn.disabled = true;
                                    submitBtn.innerHTML = `
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            {{ __('main.saving') }}
                                    `;

                                    try {
                                        const response = await fetch(form.action, {
                                            method: 'POST',
                                            body: formData,
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Accept': 'application/json'
                                            }
                                        });

                                        const data = await response.json();

                                        if (response.ok) {
                                            Toastify({
                                                text: "{{ __('main.successfully_saved') }}",
                                                duration: 3000,
                                                close: true,
                                                gravity: "top",
                                                position: "right",
                                                backgroundColor: "#28a745",
                                            }).showToast();

                                            form.reset();
                                        } else {
                                            if (data.errors) {
                                                Object.keys(data.errors).forEach(field => {
                                                    const errorElement = document.querySelector(`#${field} + .invalid-feedback`);
                                                    if (errorElement) {
                                                        errorElement.textContent = data.errors[field][0];
                                                    }
                                                });
                                            } else {
                                                Toastify({
                                                    text: data.message || "{{ __('main.save_failed') }}",
                                                    duration: 3000,
                                                    close: true,
                                                    gravity: "top",
                                                    position: "right",
                                                    backgroundColor: "#dc3545",
                                                }).showToast();
                                            }
                                        }
                                    } catch (error) {
                                        console.error('Error:', error);
                                        Toastify({
                                            text: "{{ __('main.network_error') }}",
                                            duration: 3000,
                                            close: true,
                                            gravity: "top",
                                            position: "right",
                                            backgroundColor: "#dc3545",
                                        }).showToast();
                                    } finally {
                                        // Restore button
                                        submitBtn.disabled = false;
                                        submitBtn.innerHTML = originalBtnText;
                                    }
                                });
                            </script>

                        @elseif(empty($user) and !empty(request()->query('search')))
                           <script>
                               Toastify({
                                   text: data.message || "{{ __('main.not_found') }}",
                                   duration: 3000,
                                   close: true,
                                   gravity: "top",
                                   position: "right",
                                   backgroundColor: "#dc3545",
                               }).showToast();
                           </script>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
