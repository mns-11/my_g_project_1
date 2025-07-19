@extends('layouts.main')

@section('title',ucwords(__('main.add_doctor')))



@section('content')



    <div class="content p-4">
        <div class="card card-body">
            <div class="container">
                <h2 class="mt-4">{{ucwords(__('main.add_doctor'))}}</h2>
                <form action="{{ route('teachers.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="col-form-label">{{ucfirst(__('main.name'))}}</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" />

                            @error('name')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="Gender" class="col-form-label">{{ucfirst(__('main.gender'))}}</label>
                            <select name="gender" class="form-control @error('gender') is-invalid @enderror" id="Gender">
                                <option selected disabled value="">{{ucwords(__('main.select_gender'))}}</option>
                                <option
                                    value="{{ App\Enums\UserGender::Male }}" {{old('gender') === App\Enums\UserGender::Male->value ? 'selected' : '' }}> {{__('main.' . lcfirst(App\Enums\UserGender::Male->value))}} </option>
                                <option
                                    value="{{ App\Enums\UserGender::Female }}" {{old('gender') === App\Enums\UserGender::Female->value ? 'selected' : '' }}> {{__('main.' . lcfirst(App\Enums\UserGender::Female->value))}} </option>
                            </select>
                            @error('gender')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="Email" class="col-form-label">{{ucfirst(__('main.email'))}}</label>
                            <input type="email" name="email" id="Email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" />
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
                                    <option value="{{ $college->id }}" {{ old('college_id') == $college->id ? 'selected' : '' }}>
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

                        <div class="col-md-12 mb-3">
                            <label for="address" class="col-form-label">{{ucfirst(__('main.address'))}}</label>
                            <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" />

                            @error('address')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-md-12 mb-3">
                            <label for="address" class="col-form-label">{{ucwords(__('main.mobile_number'))}}</label>
                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" />

                            @error('phone')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="birthdate" class="col-form-label">{{ucwords(__('main.birth_date'))}}</label>
                            <input type="date" name="birthdate" id="birthdate" class="form-control @error('birthdate') is-invalid @enderror" value="{{ old('birthdate') }}" />

                            @error('birthdate')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>

                    <div class="col-12">
                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-success">{{ucfirst(__('main.save'))}}</button>
                            <a  href="{{route('teachers.index')}}" type="button" class="btn bg-danger-subtle text-danger">{{ucfirst(__('main.cancel'))}}</a>
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

            const allMajors = @json($majors);

            function updateMajors() {
                const selectedCollegeId = collegeSelect.value;

                majorSelect.innerHTML = '<option selected disabled value="">{{ ucwords(__("main.select_major")) }}</option>';

                if (!selectedCollegeId) return;

                const filteredMajors = allMajors.filter(major => major.college_id == selectedCollegeId);

                filteredMajors.forEach(major => {
                    const option = document.createElement('option');
                    option.value = major.id;
                    option.textContent = major.name;
                    option.setAttribute('data-num-levels', major.num_levels);
                    majorSelect.appendChild(option);
                });

                const oldMajorId = "{{ old('major_id') }}";
                if (oldMajorId) {
                    majorSelect.value = oldMajorId;
                }
            }

            collegeSelect.addEventListener('change', function () {
                updateMajors();
            });

            window.addEventListener('load', function () {
                updateMajors();
            });
        });
    </script>
@endsection
