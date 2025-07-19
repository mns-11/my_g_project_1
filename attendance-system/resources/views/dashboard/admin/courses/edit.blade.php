@extends('layouts.main')

@section('title',ucwords(__('main.edit_course')))



@section('content')


    <div class="content p-4">
        <div class="card card-body">
            <div class="container">
                <h2 class="mt-4">{{ucwords(__('main.edit_course'))}}</h2>
                <form action="{{ route('courses.update', $course->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="col-form-label">{{ucwords(__('main.name'))}}</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $course->name) }}" />

                            @error('name')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="code" class="col-form-label">{{ucwords(__('main.code'))}}</label>
                            <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $course->code) }}" />

                            @error('code')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="Type" class="col-form-label">{{ucwords(__('main.type'))}}</label>
                            <select name="type" class="form-control @error('type') is-invalid @enderror" id="Type">
                                <option selected disabled value="">{{ucwords(__('main.select_type'))}}</option>
                                <option
                                    value="{{ App\Enums\CourseType::PRACTICAL->value }}" {{old('type', $course->type->value) === App\Enums\CourseType::PRACTICAL->value ? 'selected' : '' }}> {{ __('main.' . App\Enums\CourseType::PRACTICAL->getName())}} </option>
                                <option
                                    value="{{ App\Enums\CourseType::THEORETICAL->value }}" {{old('type', $course->type->value) === App\Enums\CourseType::THEORETICAL->value ? 'selected' : '' }}> {{ __('main.' . App\Enums\CourseType::THEORETICAL->getName())}} </option>
                            </select>
                            @error('type')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="Term" class="col-form-label">{{ucwords(__('main.term'))}}</label>
                            <select name="term" class="form-control @error('term') is-invalid @enderror" id="Term">
                                <option selected disabled value="">{{ucwords(__('main.select_term'))}}</option>
                                <option
                                    value="{{ App\Enums\AcademicTerm::ONE->value }}" {{old('term', $course->term->value) === App\Enums\AcademicTerm::ONE->value ? 'selected' : '' }}> {{ __('main.' . strtolower(App\Enums\AcademicTerm::ONE->getName()))}} </option>
                                <option
                                    value="{{ App\Enums\AcademicTerm::TWO->value }}" {{old('term', $course->term->value) === App\Enums\AcademicTerm::TWO->value ? 'selected' : '' }}> {{ __('main.' . strtolower(App\Enums\AcademicTerm::TWO->getName()))}} </option>
                            </select>
                            @error('term')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="hours" class="col-form-label">{{ucwords(__('main.hours'))}}</label>
                            <input type="number" name="hours" id="hours" class="form-control @error('hours') is-invalid @enderror" value="{{ old('hours', $course->hours) }}" />

                            @error('hours')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

{{--                        <div class="col-md-6">--}}
{{--                            <label for="validationCustom04" class="form-label">{{ucwords(__('main.responsible_doctor'))}}</label>--}}
{{--                            <select class="form-select @error('user_id') is-invalid @enderror"--}}
{{--                                    id="validationCustom04" required name="user_id">--}}
{{--                                <option selected disabled value="">{{ucwords(__('main.select_doctor'))}}</option>--}}
{{--                                @foreach($users as $user)--}}
{{--                                    <option--}}
{{--                                        value="{{ $user->id }}" {{ (old('user_id', $course->user_id) == $user->id) ? 'selected' : '' }}>{{ $user->name }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            @error('user_id')--}}
{{--                            <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}

                        <div class="col-md-6">
                            <label for="collegeSelect" class="form-label">{{ ucwords(__('main.college')) }}</label>
                            <select class="form-select @error('college_id') is-invalid @enderror" id="collegeSelect" name="college_id">
                                <option selected disabled value="">{{ ucwords(__('main.select_college')) }}</option>
                                @foreach($colleges as $college)
                                    <option value="{{ $college->id }}" {{ old('college_id',$course->college_id) == $college->id ? 'selected' : '' }}>
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

                        <div class="col-md-6">
                            <label for="levelSelect" class="form-label">{{ ucwords(__('main.level')) }}</label>
                            <select class="form-select @error('level_id') is-invalid @enderror" id="levelSelect" name="level_id">
                                <option selected disabled value="">{{ ucwords(__('main.select_level')) }}</option>
                            </select>
                            @error('level_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label d-block">{{ ucwords(__('main.status')) }}</label>
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_blocked" value="0">
                                <input type="checkbox" class="form-check-input"
                                       name="is_blocked" value="1"
                                       id="is_blocked"
                                    {{ old('is_blocked', $course->is_blocked) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_blocked">
                                    {{ $course->is_blocked ? __('main.blocked') : __('main.enabled') }}
                                </label>
                            </div>
                            @error('is_blocked')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
  <br>

                    <div class="col-12">
                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-success">{{ucwords(__('main.save'))}}</button>
                            <a  href="{{route('courses.index')}}" type="button" class="btn bg-danger-subtle text-danger">{{ucwords(__('main.cancel'))}}</a>
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
                const oldMajorId = "{{ old('major_id',$course->major_id) }}";
                if (oldMajorId) {
                    majorSelect.value = oldMajorId;
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
                    const oldLevelId = "{{ old('level_id',$course->level_id) }}";
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
