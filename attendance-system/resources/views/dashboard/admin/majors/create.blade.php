@extends('layouts.main')

@section('title', ucwords(__('main.add_major')))



@section('content')


    <div class="content p-4">
        <div class="card card-body">
            <div class="container">
                <h2 class="mt-4">{{ucwords(__('main.add_major'))}}</h2>
                <form action="{{ route('majors.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="col-form-label">{{ucwords(__('main.name'))}}</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" />

                            @error('name')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="validationCustom04" class="form-label"> {{ucwords(__('main.college'))}}</label>
                            <select class="form-select @error('college_id') is-invalid @enderror"
                                    id="validationCustom04" required name="college_id">
                                <option selected disabled value="">{{ucwords(__('main.select_college'))}}</option>
                                @foreach($colleges as $college)
                                    <option
                                        value="{{ $college->id }}" {{ (old('college_id') == $college->id) ? 'selected' : '' }}>{{ $college->name }}</option>
                                @endforeach
                            </select>
                            @error('college_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="num_levels" class="col-form-label">{{ucwords(__('main.num_levels'))}}</label>
                            <input type="number" name="num_levels" id="num_levels" class="form-control @error('num_levels') is-invalid @enderror" value="{{ old('num_levels') }}" />

                            @error('num_levels')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="location" class="col-form-label">{{ucwords(__('main.major_location'))}}</label>
                            <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}" />

                            @error('location')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="phone" class="col-form-label">{{ucwords(__('main.phone'))}}</label>
                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" />

                            @error('phone')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="email" class="col-form-label">{{ucwords(__('main.email'))}}</label>
                            <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" />

                            @error('email')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>
                    <br>
                    <div class="col-12">
                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-success">{{ucwords(__('main.save'))}}</button>
                            <a  href="{{route('majors.index')}}" type="button" class="btn bg-danger-subtle text-danger">{{ucwords(__('main.cancel'))}}</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
