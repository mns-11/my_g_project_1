@extends('layouts.main')

@section('title', ucwords(__('main.add_college')))



@section('content')


    <div class="content p-4">
        <div class="card card-body">
            <div class="container">
                <h2 class="mt-4">{{ucwords(__('main.add_college'))}}</h2>
                <form action="{{ route('colleges.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="col-form-label">{{ucwords(__('main.name'))}}</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" />

                            @error('name')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="location" class="col-form-label">{{ucwords(__('main.college_location'))}}</label>
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
                            <a  href="{{route('colleges.index')}}" type="button" class="btn bg-danger-subtle text-danger">{{ucwords(__('main.cancel'))}}</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
