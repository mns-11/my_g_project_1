@extends('layouts.main')

@section('title',ucwords(__('main.add_doctor')))



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

        .content {
            margin: 3% 3%;
            padding: 20px;
            flex: 1;
        }
        @media (max-width: 768px) {
            .container {
                margin-right: 0 !important;
            }
        }
    </style>

    <div class="content">
        <div class="card card-body">
            <div class="container">
                <h2 class="mt-4">{{ucwords(__('main.edit_doctor'))}}</h2>
                <form action="{{ route('chief.teachers.update', $user->id) }}" method="POST">
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
                            <input type="email" name="email" id="Email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email',$user->email) }}" />
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

                        <div class="col-md-12 mb-3">
                            <label for="address" class="col-form-label">{{ucfirst(__('main.address'))}}</label>
                            <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address',$user->address) }}" />

                            @error('address')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-md-12 mb-3">
                            <label for="address" class="col-form-label">{{ucwords(__('main.mobile_number'))}}</label>
                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone',$user->phone) }}" />

                            @error('phone')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="birthdate" class="col-form-label">{{ucwords(__('main.birth_date'))}}</label>
                            <input type="date" name="birthdate" id="birthdate" class="form-control @error('birthdate') is-invalid @enderror" value="{{ old('birthdate',$user->birthdate) }}" />

                            @error('birthdate')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>

                    <div class="col-12">
                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-success">{{ucfirst(__('main.save'))}}</button>
                            <a  href="{{route('chief.teachers.index')}}" type="button" class="btn bg-danger-subtle text-danger">{{ucfirst(__('main.cancel'))}}</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
