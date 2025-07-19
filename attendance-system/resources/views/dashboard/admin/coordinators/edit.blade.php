@extends('layouts.main')

@section('title', ucwords(__('main.edit_coordinator')))



@section('content')

    <div class="content p-4">
        <div class="card card-body">
            <div class="container">
                <h2 class="mt-4">{{ucwords(__('main.edit_coordinator'))}}</h2>
                <form action="{{ route('coordinators.update', $user->id) }}" method="POST">
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
                                    value="{{ App\Enums\UserGender::Male }}" {{old('gender', $user->gender) === App\Enums\UserGender::Male->value ? 'selected' : '' }}> {{ App\Enums\UserGender::Male->value}} </option>
                                <option
                                    value="{{ App\Enums\UserGender::Female }}" {{old('gender', $user->gender) === App\Enums\UserGender::Female->value ? 'selected' : '' }}> {{ App\Enums\UserGender::Female->value }} </option>
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

                        <div class="col-md-12 mb-3">
                            <label for="address" class="col-form-label">{{ucfirst(__('main.address'))}}</label>
                            <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $user->address) }}" />

                            @error('address')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-md-12 mb-3">
                            <label for="address" class="col-form-label">{{ucwords(__('main.mobile_number'))}}</label>
                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" />

                            @error('phone')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="address" class="col-form-label">{{ucwords(__('main.birth_date'))}}</label>
                            <input type="date" name="birthdate" id="birthdate" class="form-control @error('birthdate') is-invalid @enderror" value="{{ old('birthdate', $user->birthdate) }}" />

                            @error('birthdate')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>

                    <div class="col-12">
                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-success">{{ucfirst(__('main.save'))}}</button>
                            <a  href="{{route('coordinators.index')}}" type="button" class="btn bg-danger-subtle text-danger">{{ucfirst(__('main.cancel'))}}</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
