@extends('layouts.main')

@section('title', ucwords(__('main.add_academic_year')))



@section('content')


    <div class="content p-4">
        <div class="card card-body">
            <div class="container">
                <h2 class="mt-4">{{ucwords(__('main.add_academic_year'))}}</h2>
                <form action="{{ route('academic-years.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="col-form-label">{{ucwords(__('main.name'))}}</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" />

                            @error('name')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="start_date" class="col-form-label">{{ucwords(__('main.start_date'))}}</label>
                            <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" />

                            @error('start_date')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="end_date" class="col-form-label">{{ucwords(__('main.end_date'))}}</label>
                            <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" />

                            @error('end_date')
                            <span class="validation-text text-danger">{{ $message }}</span>
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
@endsection
