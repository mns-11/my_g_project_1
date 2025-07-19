@extends('layouts.main')

@section('title', ucwords(__('main.edit_student')))



@section('content')


    <div class="content p-4">
        <div class="card card-body">
            <div class="container">
                <h2 class="mt-4">{{ucwords(__('main.edit_student'))}}</h2>
                <form action="{{ route('students.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="col-form-label">{{ucfirst(__('main.name'))}}</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" />

                            @error('name')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="Gender" class="col-form-label">{{ucfirst(__('main.gender'))}}</label>
                            <select name="gender" class="form-control @error('gender') is-invalid @enderror" id="Gender">
                                <option selected disabled value="">{{ucwords(__('main.select_gender'))}}</option>
                                <option
                                    value="{{ App\Enums\UserGender::Male }}" {{old('gender', $user->gender) === App\Enums\UserGender::Male->value ? 'selected' : '' }}>  {{__('main.' . lcfirst(App\Enums\UserGender::Male->value))}}  </option>
                                <option
                                    value="{{ App\Enums\UserGender::Female }}" {{old('gender', $user->gender) === App\Enums\UserGender::Female->value ? 'selected' : '' }}>  {{__('main.' . lcfirst(App\Enums\UserGender::Female->value))}}  </option>
                            </select>
                            @error('gender')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="Email" class="col-form-label">{{ucfirst(__('main.email'))}}</label>
                            <input type="email" name="email" id="Email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" />
                            @error('email')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mb-3">
                            <label for="password" class="col-form-label">{{ucfirst(__('main.password'))}}</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" />
                            @error('password')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mb-3">
                            <label for="passwordConfirmation" class="col-form-label">{{ucwords(__('main.confirm_password'))}}</label>
                            <input type="password" name="password_confirmation" id="passwordConfirmation" class="form-control" />
                        </div>

                        <div class="col-md-6">
                            <label for="collegeSelect" class="form-label">{{ ucwords(__('main.college')) }}</label>
                            <select class="form-select @error('college_id') is-invalid @enderror" id="collegeSelect" name="college_id">
                                <option selected disabled value="">{{ ucwords(__('main.select_college')) }}</option>
                                @foreach($colleges as $college)
                                    <option value="{{ $college->id }}" {{ old('college_id',$user->college_id) == $college->id ? 'selected' : '' }}>
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

                        <div class="col-md-6">
                            <label for="enrollment_number" class="col-form-label">{{ucwords(__('main.enrollment_number'))}}</label>
                            <input type="number" name="enrollment_number" id="enrollment_number" class="form-control @error('enrollment_number') is-invalid @enderror" value="{{ old('enrollment_number', $user->enrollment_number) }}" />

                            @error('enrollment_number')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="address" class="col-form-label">{{ucfirst(__('main.address'))}}</label>
                            <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $user->address) }}" />

                            @error('address')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-md-6">
                            <label for="address" class="col-form-label">{{ucwords(__('main.mobile_number'))}}</label>
                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" />

                            @error('phone')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="birthdate" class="col-form-label">{{ucwords(__('main.birth_date'))}}</label>
                            <input type="date" name="birthdate" id="birthdate" class="form-control @error('birthdate') is-invalid @enderror" value="{{ old('birthdate', $user->birthdate) }}" />

                            @error('birthdate')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>
<br>
                    <div class="col-12">
                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-success">{{ucfirst(__('main.save'))}}</button>
                            <a  href="{{route('students.index')}}" type="button" class="btn bg-danger-subtle text-danger">{{ucfirst(__('main.cancel'))}}</a>
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
                const oldMajorId = "{{ old('major_id',$user->major_id) }}";
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
                    const oldLevelId = "{{ old('level_id',$user->level_id) }}";
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
