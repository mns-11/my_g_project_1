@extends('layouts.main')

@section('title', ucwords(__('main.edit_attendance_data')))



@section('content')


    <div class="content p-4">
        <div class="card card-body">
            <div class="container">
                <h2 class="mt-4">{{ucwords(__('main.edit_attendance_data'))}}</h2>
                <form action="{{ route('attendances.update', $attendance->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <label for="validationCustom04" class="form-label">{{ucwords(__('main.student'))}}</label>
                            <select class="form-select @error('user_id') is-invalid @enderror"
                                    id="validationCustom04" required name="user_id">
                                <option selected disabled value="">{{ucwords(__('main.select_student'))}}</option>
                                @foreach($users as $user)
                                    <option
                                        value="{{ $user->id }}" {{ (old('user_id', $attendance->user_id) == $user->id) ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="validationCustom04" class="form-label">{{ucwords(__('main.course'))}}</label>
                            <select class="form-select @error('course_id') is-invalid @enderror"
                                    id="validationCustom04" required name="course_id">
                                <option selected disabled value="">{{ucwords(__('main.select_course'))}}</option>
                                @foreach($courses as $course)
                                    <option
                                        value="{{ $course->id }}" {{ (old('course_id', $attendance->course_id) == $course->id) ? 'selected' : '' }}>{{ $course->name }}</option>
                                @endforeach
                            </select>
                            @error('course_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="col-form-label">{{ucwords(__('main.status'))}}</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror" id="status">
                                <option selected disabled value="">{{ucwords(__('main.select_status'))}}</option>
                                <option
                                    value="{{ App\Enums\AttendanceStatus::PRESENT }}" {{old('status',$attendance->status->value) === App\Enums\AttendanceStatus::PRESENT->value ? 'selected' : '' }}> {{__('main.' . App\Enums\AttendanceStatus::PRESENT->getName())}}  </option>
                                <option
                                    value="{{ App\Enums\AttendanceStatus::ABSENT }}" {{old('status',$attendance->status->value) === App\Enums\AttendanceStatus::ABSENT->value ? 'selected' : '' }}> {{__('main.' . App\Enums\AttendanceStatus::ABSENT->getName())}}  </option>
                            </select>
                            @error('status')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="date" class="col-form-label">{{ucfirst(__('main.date'))}}</label>
                            <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', $attendance->date) }}" />

                            @error('date')
                            <span class="validation-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <br>
                    <div class="col-12">
                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-success">{{ucfirst(__('main.save'))}}</button>
                            <a  href="{{route('attendances.index')}}" type="button" class="btn bg-danger-subtle text-danger">{{ucfirst(__('main.cancel'))}}</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
