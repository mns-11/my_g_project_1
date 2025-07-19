@extends('layouts.main')

@section('title',ucwords(__('main.creating_lectures')))



@section('content')

    <style>
        /* تنسيق عام */
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(45deg, #ffa600cc, #228b22cb);
            /* background: linear-gradient(135deg, #F5F6FA 0%, #E0E6F0 100%); */
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
        .btn-outline-light:hover{
            background-color: #228B22;
        }
        .form-control, .form-select {
            border-radius: 10px;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
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

    <div class="container main-content mt-5">
        {{--        @php--}}
        {{--            if($errors->all())--}}
        {{--                dd($errors->all());--}}
        {{--        @endphp--}}
        <div class="row animate__animated animate__fadeIn">
            <div class="col-md-8 mx-auto">
                <div class="card p-4" style="background: linear-gradient(135deg, #f5f6fa9f 0%, #e0e6f0a6 100%);">
                    <h3 class="text-center mb-4"><strong style="color: #228B22;">{{ucwords(__('main.create_a_new_lecture'))}}</strong></h3>
                    <form id="lectureForm" action="{{route('lectures.store')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="course" class="form-label" style="color: #228B22;">{{ucwords(__('main.course_name'))}}</label>
                            <select class="form-select @error('course_id') is-invalid @enderror" id="course"  style="color: #FFA500;" name="course_id">
                                <option value="">{{ucwords(__('main.select_course'))}}</option>
                                @foreach($courses as $course)
                                    <option
                                        value="{{ $course->id }}" {{ (old('course_id') == $course->id) ? 'selected' : '' }}>{{ $course->name }}</option>
                                @endforeach
                            </select>
                            @error('course_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="Type" class="col-form-label">{{ucwords(__('main.type'))}}</label>
                            <select name="type" class="form-control @error('type') is-invalid @enderror" id="Type">
                                <option selected disabled value="">{{ucwords(__('main.select_type'))}}</option>
                                <option
                                    value="{{ App\Enums\CourseType::PRACTICAL }}" {{old('type') === App\Enums\CourseType::PRACTICAL->value ? 'selected' : '' }}> {{ __('main.' . App\Enums\CourseType::PRACTICAL->getName())}} </option>
                                <option
                                    value="{{ App\Enums\CourseType::THEORETICAL }}" {{old('type') === App\Enums\CourseType::THEORETICAL->value ? 'selected' : '' }}> {{ __('main.' . App\Enums\CourseType::THEORETICAL->getName())}} </option>
                            </select>
                            @error('type')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- صف جديد لتحديد القسم، الكلية والمستوى -->
                        <div class="row">
                            {{--                            <div class="col-md-4 mb-3">--}}
                            {{--                                <label for="validationCustom04" class="form-label"> {{ucwords(__('main.college'))}}</label>--}}
                            {{--                                <select class="form-select @error('college_id') is-invalid @enderror"--}}
                            {{--                                        id="validationCustom04" name="college_id">--}}
                            {{--                                    <option selected disabled value="">{{ucwords(__('main.select_college'))}}</option>--}}
                            {{--                                    @foreach($colleges as $college)--}}
                            {{--                                        <option--}}
                            {{--                                            value="{{ $college->id }}" {{ (old('college_id') == $college->id) ? 'selected' : '' }}>{{ $college->name }}</option>--}}
                            {{--                                    @endforeach--}}
                            {{--                                </select>--}}
                            {{--                                @error('college_id')--}}
                            {{--                                <div class="invalid-feedback">{{ $message }}</div>--}}
                            {{--                                @enderror--}}
                            {{--                            </div>--}}
                            {{--                            <div class="col-md-4 mb-3">--}}
                            {{--                                <label for="validationCustom04" class="form-label"> {{ucwords(__('main.major'))}}</label>--}}
                            {{--                                <select class="form-select @error('major_id') is-invalid @enderror"--}}
                            {{--                                        id="validationCustom04"  name="major_id">--}}
                            {{--                                    <option selected disabled value="">{{ucwords(__('main.select_major'))}}</option>--}}
                            {{--                                    @foreach($majors as $major)--}}
                            {{--                                        <option--}}
                            {{--                                            value="{{ $major->id }}" {{ (old('major_id') == $major->id) ? 'selected' : '' }}>{{ $major->name }}</option>--}}
                            {{--                                    @endforeach--}}
                            {{--                                </select>--}}
                            {{--                                @error('major_id')--}}
                            {{--                                <div class="invalid-feedback">{{ $message }}</div>--}}
                            {{--                                @enderror--}}
                            {{--                            </div>--}}

                            {{--                            <div class="col-md-4 mb-3">--}}
                            {{--                                <label for="validationCustom04" class="form-label">{{ucwords(__('main.level'))}}</label>--}}
                            {{--                                <select class="form-select @error('level_id') is-invalid @enderror"--}}
                            {{--                                        id="validationCustom04"  name="level_id">--}}
                            {{--                                    <option selected disabled value="">{{ucwords(__('main.select_level'))}}</option>--}}
                            {{--                                    @foreach($levels as $level)--}}
                            {{--                                        <option--}}
                            {{--                                            value="{{ $level->id }}" {{ (old('level_id') == $level->id) ? 'selected' : '' }}>{{ $level->name }}</option>--}}
                            {{--                                    @endforeach--}}
                            {{--                                </select>--}}
                            {{--                                @error('level_id')--}}
                            {{--                                <div class="invalid-feedback">{{ $message }}</div>--}}
                            {{--                                @enderror--}}
                            {{--                            </div>--}}

                            <div class="col-md-4 mb-3">
                                <label for="collegeSelect" class="form-label">{{ ucwords(__('main.college')) }}</label>
                                <select class="form-select @error('college_id') is-invalid @enderror" id="collegeSelect" name="college_id">
                                    <option selected disabled value="">{{ ucwords(__('main.select_college')) }}</option>
                                    @foreach($colleges as $college)
                                        <option value="{{ $college->id }}" {{ old('college_id') == $college->id ? 'selected' : '' }}>
                                            {{ $college->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('college_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="majorSelect" class="form-label">{{ ucwords(__('main.major')) }}</label>
                                <select class="form-select @error('major_id') is-invalid @enderror" id="majorSelect" name="major_id">
                                    <option selected disabled value="">{{ ucwords(__('main.select_major')) }}</option>
                                </select>
                                @error('major_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="levelSelect" class="form-label">{{ ucwords(__('main.level')) }}</label>
                                <select class="form-select @error('level_id') is-invalid @enderror" id="levelSelect" name="level_id">
                                    <option selected disabled value="">{{ ucwords(__('main.select_level')) }}</option>
                                </select>
                                @error('level_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="datetime" class="form-label">{{ ucwords(__('main.date_and_time_of_the_lecture')) }}</label>
                            <input type="datetime-local" class="form-control @error('datetime') is-invalid @enderror" id="datetime" name="datetime" value="{{ old('datetime') }}">
                            @error('datetime')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="duration" class="form-label">{{ucwords(__('main.duration'))}}</label> ({{__('main.hour')}})
                            <input type="number" class="form-control @error('duration') is-invalid @enderror" id="duration" placeholder=""  name="duration" value="{{old('duration')}}">
                            @error('duration')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
{{--                        <div class="mb-3">--}}
{{--                            <label for="location" class="form-label">{{ucwords(__('main.location_gps_coordinates'))}}</label>--}}
{{--                            <input type="text" class="form-control @error('hall') is-invalid @enderror" id="location" placeholder=""  name="hall" value="{{old('hall')}}">--}}
{{--                            @error('hall')--}}
{{--                            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
                        {{--                        <div class="mb-3">--}}
                        {{--                            <label for="radius" class="form-label">نطاق الحضور (متر)</label>--}}
                        {{--                            <input type="range" class="form-range" id="radius" min="1" max="10" value="50" oninput="document.getElementById('radius-value').innerText = this.value" style="accent-color: #006400;">--}}
                        {{--                            <small>النطاق الحالي: <span id="radius-value">50</span> متر</small>--}}
                        {{--                        </div>--}}
{{--                        <button type="submit" class="btn w-100" style="background-color: #FFA500; color: white;">{{ucwords(__('main.generate_qr_code'))}}</button>--}}
                        <button type="submit" class="btn w-100" style="background-color: #FFA500; color: white;">{{ucwords(__('main.save'))}}</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const collegeSelect = document.getElementById('collegeSelect');
            const majorSelect = document.getElementById('majorSelect');
            const levelSelect = document.getElementById('levelSelect');

            // All majors and levels from backend
            const allMajors = @json($majors);
            const allLevels = @json($levels);


            // --- Filter majors by selected college ---
            function updateMajors() {
                const selectedCollegeId = collegeSelect.value;

                // Clear current options
                majorSelect.innerHTML = '<option selected disabled value="">{{ ucwords(__("main.select_major")) }}</option>';
                levelSelect.innerHTML = '<option selected disabled value="">{{ ucwords(__("main.select_level")) }}</option>';

                if (!selectedCollegeId) return;

                const filteredMajors = allMajors.filter(major => major.college_id == selectedCollegeId);

                filteredMajors.forEach(major => {
                    const option = document.createElement('option');
                    option.value = major.id;
                    option.textContent = major.name;
                    option.setAttribute('data-num-levels', major.num_levels);
                    majorSelect.appendChild(option);
                });

                // Restore old major selection
                const oldMajorId = "{{ old('major_id') }}";
                if (oldMajorId) {
                    majorSelect.value = oldMajorId;
                    majorSelect.dispatchEvent(new Event('change'));
                    updateLevels(); // Trigger level update after major set
                }
            }

            // --- Show only N levels based on major's num_levels ---
            function updateLevels() {
                const selectedOption = majorSelect.options[majorSelect.selectedIndex];
                const numLevels = parseInt(selectedOption.getAttribute('data-num-levels'));

                levelSelect.innerHTML = '<option selected disabled value="">{{ ucwords(__("main.select_level")) }}</option>';

                if (!isNaN(numLevels) && numLevels > 0) {
                    const validLevels = allLevels.slice(0, numLevels);

                    validLevels.forEach(level => {
                        const option = document.createElement('option');
                        option.value = level.id;
                        option.textContent = level.name;
                        levelSelect.appendChild(option);
                    });

                    // Restore old level selection
                    const oldLevelId = "{{ old('level_id') }}";
                    if (oldLevelId) {
                        levelSelect.value = oldLevelId;
                    }
                }
            }


            // Attach events
            collegeSelect.addEventListener('change', function () {
                updateMajors();
            });

            majorSelect.addEventListener('change', updateLevels);

            // Initial load
            window.addEventListener('load', function () {
                updateMajors(); // Load majors for pre-selected college
            });
        });
    </script>
@endsection
