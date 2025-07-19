@extends('layouts.main')

@section('title', ucwords(__('main.edit_course')))



@section('content')


    <div class="content p-4">
        <div class="card card-body">
            <div class="container">
                <h2 class="mt-4">{{ucwords(__('main.edit_course'))}}</h2>
                <form action="{{ route('acchmus.update', $record->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <div class="col-md-6">
                            <label for="academicYearSelect" class="form-label">{{ ucwords(__('main.academic_year')) }}</label>
                            <select class="form-select @error('academic_year_id') is-invalid @enderror" id="academicYearSelect" name="academic_year_id">
                                <option selected disabled value="">{{ ucwords(__('main.select_academic_year')) }}</option>
                                @foreach($academicYears as $academicYear)
                                    <option value="{{ $academicYear->id }}" {{ old('academic_year_id', $record->academic_year_id) == $academicYear->id ? 'selected' : '' }}>
                                        {{ $academicYear->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('academic_year_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="collegeSelect" class="form-label">{{ ucwords(__('main.college')) }}</label>
                            <select class="form-select @error('college_id') is-invalid @enderror" id="collegeSelect" name="college_id">
                                <option selected disabled value="">{{ ucwords(__('main.select_college')) }}</option>
                                @foreach($colleges as $college)
                                    <option value="{{ $college->id }}" {{ old('college_id', $record->college_id) == $college->id ? 'selected' : '' }}>
                                        {{ $college->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('college_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="majorSelect" class="form-label">{{ ucwords(__('main.major')) }}</label>
                            <select class="form-select @error('major_id') is-invalid @enderror" id="majorSelect" name="major_id">
                                <option selected disabled value="">{{ ucwords(__('main.select_major')) }}</option>
                            </select>
                            @error('major_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

{{--                        <div class="col-md-6">--}}
{{--                            <label for="levelSelect" class="form-label">{{ ucwords(__('main.level')) }}</label>--}}
{{--                            <select class="form-select @error('level_id') is-invalid @enderror" id="levelSelect" name="level_id">--}}
{{--                                <option selected disabled value="">{{ ucwords(__('main.select_level')) }}</option>--}}
{{--                            </select>--}}
{{--                            @error('level_id')--}}
{{--                            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}

{{--                        <div class="col-md-6">--}}
{{--                            <label for="course" class="form-label">{{ucwords(__('main.course_name'))}}</label>--}}
{{--                            <select class="form-select @error('course_id') is-invalid @enderror" id="course"  name="course_id">--}}
{{--                                <option value="">{{ucwords(__('main.select_course'))}}</option>--}}
{{--                                @foreach($courses as $course)--}}
{{--                                    <option--}}
{{--                                        value="{{ $course->id }}" {{ (old('course_id',$record->course_id) == $course->id) ? 'selected' : '' }}>{{ $course->name }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            @error('course_id')--}}
{{--                            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}

                        <div class="col-md-6">
                            <label for="courseSelect" class="form-label">{{ ucwords(__('main.course')) }}</label>
                            <select class="form-select @error('course_id') is-invalid @enderror" id="courseSelect" name="course_id">
                                <option selected disabled value="">{{ ucwords(__('main.select_course')) }}</option>
                            </select>
                            @error('course_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="Type" class="col-form-label">{{ucwords(__('main.type'))}}</label>
                            <select name="type" class="form-control @error('type') is-invalid @enderror" id="Type">
                                <option selected disabled value="">{{ucwords(__('main.select_type'))}}</option>
                                <option
                                    value="{{ App\Enums\CourseType::PRACTICAL }}" {{old('type',$record->type->value) === App\Enums\CourseType::PRACTICAL->value ? 'selected' : '' }}> {{ __('main.' . App\Enums\CourseType::PRACTICAL->getName())}} </option>
                                <option
                                    value="{{ App\Enums\CourseType::THEORETICAL }}" {{old('type', $record->type->value) === App\Enums\CourseType::THEORETICAL->value ? 'selected' : '' }}> {{ __('main.' . App\Enums\CourseType::THEORETICAL->getName())}} </option>
                            </select>
                            @error('type')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-md-6">
                            <label for="userSelect" class="form-label">{{ ucwords(__('main.responsible_doctor')) }}</label>
                            <select class="form-select @error('user_id') is-invalid @enderror" id="userSelect" name="user_id">
                                <option selected disabled value="">{{ ucwords(__('main.select_doctor')) }}</option>
                            </select>
                            @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="hallSelect" class="form-label">{{ ucwords(__('main.hall')) }}</label>
                            <select class="form-select @error('hall_id') is-invalid @enderror" id="hallSelect" name="hall_id">
                                <option selected disabled value="">{{ ucwords(__('main.select_hall')) }}</option>
                                @foreach($halls as $hall)
                                    <option
                                        value="{{ $hall->id }}" {{ (old('hall_id', $record->hall_id) == $hall->id) ? 'selected' : '' }}>{{ $hall->name }}</option>
                                @endforeach
                            </select>
                            @error('hall_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <br>
                    <div class="col-12">
                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-success">{{ucwords(__('main.save'))}}</button>
                            <a  href="{{route('acchmus.index')}}" type="button" class="btn bg-danger-subtle text-danger">{{ucwords(__('main.cancel'))}}</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const collegeSelect = document.getElementById('collegeSelect');
            const majorSelect = document.getElementById('majorSelect');
            const userSelect = document.getElementById('userSelect');
            // const levelSelect = document.getElementById('levelSelect');
            const courseSelect = document.getElementById('courseSelect');

            // All majors and levels from backend
            const allMajors = @json($majors);
            const allUsers = @json($users);
            const allLevels = @json($levels);
            const allCourses = @json($courses);


            // --- Filter users by selected college ---
            function updateUsers() {
                const selectedCollegeId = collegeSelect.value;

                // Clear current options
                userSelect.innerHTML = '<option selected disabled value="">{{ ucwords(__("main.select_doctor")) }}</option>';

                if (!selectedCollegeId) return;

                const filteredUsers = allUsers.filter(user => user.college_id == selectedCollegeId);

                filteredUsers.forEach(user => {
                    const option = document.createElement('option');
                    option.value = user.id;
                    option.textContent = user.name;
                    userSelect.appendChild(option);
                });

                // Restore old major selection
                const oldUserId = "{{ old('user_id', $record->user_id) }}";
                if (oldUserId) {
                    userSelect.value = oldUserId;
                    userSelect.dispatchEvent(new Event('change'));

                }
            }


            // --- Filter majors by selected college ---
            function updateMajors() {
                const selectedCollegeId = collegeSelect.value;

                // Clear current options
                majorSelect.innerHTML = '<option selected disabled value="">{{ ucwords(__("main.select_major")) }}</option>';
                {{--levelSelect.innerHTML = '<option selected disabled value="">{{ ucwords(__("main.select_level")) }}</option>';--}}

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
                const oldMajorId = "{{ old('major_id', $record->major_id) }}";
                if (oldMajorId) {
                    majorSelect.value = oldMajorId;
                    majorSelect.dispatchEvent(new Event('change'));

                    // updateLevels(); // Trigger level update after major set
                }
            }

            // --- Show only N levels based on major's num_levels ---
            {{--function updateLevels() {--}}
            {{--    const selectedOption = majorSelect.options[majorSelect.selectedIndex];--}}
            {{--    const numLevels = parseInt(selectedOption.getAttribute('data-num-levels'));--}}

            {{--    levelSelect.innerHTML = '<option selected disabled value="">{{ ucwords(__("main.select_level")) }}</option>';--}}

            {{--    if (!isNaN(numLevels) && numLevels > 0) {--}}
            {{--        const validLevels = allLevels.slice(0, numLevels);--}}

            {{--        validLevels.forEach(level => {--}}
            {{--            const option = document.createElement('option');--}}
            {{--            option.value = level.id;--}}
            {{--            option.textContent = level.name;--}}
            {{--            levelSelect.appendChild(option);--}}
            {{--        });--}}

            {{--        // Restore old level selection--}}
            {{--        const oldLevelId = "{{ old('level_id', $record->level_id) }}";--}}
            {{--        if (oldLevelId) {--}}
            {{--            levelSelect.value = oldLevelId;--}}
            {{--        }--}}
            {{--    }--}}
            {{--}--}}

            // --- Filter courses by selected college and major and course ---
            {{--function updateCourses() {--}}
            {{--    const selectedCollegeId = collegeSelect.value;--}}
            {{--    const selectedMajorId = majorSelect.value;--}}
            {{--    const selectedLevelId = levelSelect.value;--}}

            {{--    // Clear current options--}}
            {{--    courseSelect.innerHTML = '<option selected disabled value="">{{ ucwords(__("main.select_course")) }}</option>';--}}

            {{--    if (!selectedCollegeId && !selectedMajorId && !selectedLevelId) return;--}}

            {{--    const filteredCourses = allCourses.filter(course => course.college_id == selectedCollegeId && course.major_id == selectedMajorId && course.level_id == selectedLevelId);--}}

            {{--    filteredCourses.forEach(course => {--}}
            {{--        const option = document.createElement('option');--}}
            {{--        option.value = course.id;--}}
            {{--        option.textContent = course.name;--}}
            {{--        courseSelect.appendChild(option);--}}
            {{--    });--}}

            {{--    // Restore old course selection--}}
            {{--    const oldCourseId = "{{ old('course_id', $record->course_id) }}";--}}
            {{--    if (oldCourseId) {--}}
            {{--        courseSelect.value = oldCourseId;--}}
            {{--    }--}}
            {{--}--}}

            function updateCourses() {
                courseSelect.innerHTML = '<option selected disabled value="">{{ ucwords(__("main.select_course")) }}</option>';
                const selectedCollegeId = collegeSelect.value;
                const selectedMajorId = majorSelect.value;

                if (!selectedCollegeId || !selectedMajorId) return;

                const filteredCourses = allCourses.filter(course =>
                    course.college_id == selectedCollegeId &&
                    course.major_id == selectedMajorId
                );

                if (filteredCourses.length > 0) {
                    filteredCourses.forEach(course => {
                        const option = document.createElement('option');
                        option.value = course.id;
                        option.textContent = course.name;
                        courseSelect.appendChild(option);
                    });

                    const oldCourseId = "{{ old('course_id', $record->course_id) }}";
                    if (oldCourseId) {
                        const courseExists = courseSelect.querySelector(`option[value="${oldCourseId}"]`);
                        if (courseExists) {
                            courseSelect.value = oldCourseId;
                        }
                    }
                }
            }

            // Attach events
            collegeSelect.addEventListener('change', function () {
                updateUsers();
                updateMajors();
                updateCourses();
            });

            // majorSelect.addEventListener('change', updateLevels);

            majorSelect.addEventListener('change', updateCourses);

            // Initial load
            window.addEventListener('load', function () {
                updateUsers(); // Load users for pre-selected college
                updateMajors(); // Load majors for pre-selected college
                updateCourses();
            });
        });
    </script>
@endsection
