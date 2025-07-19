@extends('layouts.main')

@section('title',ucwords(__('main.student_management')))

@section('content')
    <style>
        /* تنسيق عام */
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #F5F6FA 0%, #E0E6F0 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: #4A90E2;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand, .nav-link {
            color: #FFFFFF !important;
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
            transition: background 0.3s;
        }
        .btn-danger {
            background-color: #E74C3C;
            border: none;
            border-radius: 25px;
            transition: background 0.3s;
        }
        .btn-warning {
            background-color: #F1C40F;
            border: none;
            border-radius: 25px;
            transition: background 0.3s;
        }
        .btn-outline-light:hover {
            background-color: #228B22;
        }
        .table {
            background-color: #FFA500;
            border-radius: 10px;
            overflow: hidden;
        }
        .table th, .table td {
            padding: 15px;
            text-align: center;
        }
        /* المحتوى الرئيسي مع ضبط الهوامش */
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

        #reasonError {
            display: none;
            font-size: 0.875rem;
        }

        .header-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 20px;
        }

        @media (min-width: 576px) {
            .header-container {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
        }

        .btn-primary {
            background-color: #228B22;
            border: none;
            transition: background 0.3s;
        }
        .btn-primary:hover {
            background-color: #FFA500;

        }

        /* Gender badges */
        .gender-badge {
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 14px;
        }

        .gender-m {
            background-color: #4d79ff;
            color: white;
        }

        .gender-f {
            background-color: #ff66b3;
            color: white;
        }
    </style>


    <div class="content">
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="errorToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger text-white">
                    <strong class="me-auto"><i class="fas fa-exclamation-triangle me-2"></i>{{ucfirst(__('main.error'))}}</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <i class="fas fa-times-circle me-2"></i> <span id="toastMessage">{{ucwords(__('main.please_enter_rejection_reason'))}}</span>
                </div>
            </div>
        </div>
        <div class="row mt-5 animate__animated">

            <div class="col-12">
                <div style="
    background: linear-gradient(135deg, #FFA500, #228B22);
    border: none;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(237, 171, 72, 0.6);
    color: #fff;
    margin-bottom: 24px;
    padding: 20px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
">


                <div class="header-container">
                        <h2></h2>
                        <div class="d-flex flex-wrap gap-2">
                            <form class="position-relative" method="GET" action="{{route('coordinator.students.index') }}" id="search-form">
                                <input type="text" class="form-control" id="search-staff" placeholder="{{ucwords(__('main.search_here'))}}"
                                       style="max-width: 250px;" onkeyup="searchTable('staff')" value="{{ request()->query('search') }}"
                                       oninput="searchFormSubmit()" name="search"/>

                                @error('search', 'searchErrors')
                                <span class="validation-text text-danger">{{ $message }}</span>
                                @enderror
                            </form>
                            <a href="{{route('coordinator.students.create')}}" class="btn btn-primary" >
                                <i class="fas fa-plus me-1"></i>{{ucwords(__('main.add_student'))}}
                            </a>
                        </div>
                    </div>

                    <script>
                        let timeout;

                        function searchFormSubmit() {
                            clearTimeout(timeout);
                            timeout = setTimeout(function() {
                                document.getElementById('search-form').submit();
                            }, 750);
                        }
                    </script>
                    <h3 class="text-center mb-4"><strong>{{ucwords(__('main.student_management'))}}</strong></h3>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead style="background-color: #006400; color: white;">
                            <tr>
                                <th style="background-color: #228B22; color: white;">#</th>
                                <th style="background-color: #228B22; color: white;">{{ucwords(__('main.student_name'))}}</th>
                                <th style="background-color: #228B22; color: white;">{{ucwords(__('main.enrollment_number'))}}</th>
                                <th style="background-color: #228B22; color: white;">{{ucfirst(__('main.birth_date'))}}</th>
                                <th style="background-color: #228B22; color: white;">{{ucfirst(__('main.gender'))}}</th>
                                <th style="background-color: #228B22; color: white;">{{ucfirst(__('main.email'))}}</th>
                                <th style="background-color: #228B22; color: white;">{{ucfirst(__('main.college'))}}</th>
                                <th style="background-color: #228B22; color: white;">{{ucfirst(__('main.major'))}}</th>
                                <th style="background-color: #228B22; color: white;">{{ucfirst(__('main.level'))}}</th>
                                <th style="background-color: #228B22; color: white;">{{ucfirst(__('main.address'))}}</th>
                                <th style="background-color: #228B22; color: white;">{{ucfirst(__('main.mobile_number'))}}</th>
                                <th style="background-color: #228B22; color: white;">{{ucfirst(__('main.actions'))}}</th>
                            </tr>
                            </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->enrollment_number}}</td>
                        <td>{{$user->birthdate}}</td>
                        <td><span class="gender-badge gender-{{lcfirst($user->gender)}}">{{__('main.' . lcfirst($user->gender))}}</span></td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->college?->name}}</td>
                        <td>{{$user->major?->name}}</td>
                        <td>{{$user->level->name}}</td>
                        <td>{{$user->address}}</td>
                        <td>{{$user->phone}}</td>
                        <td>
                            <a href="{{route('coordinator.students.edit', $user->id)}}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailsStudentModal-{{$user->id}}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <!-- Student Details Modal -->
                            <div class="modal fade" id="detailsStudentModal-{{$user->id}}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ucwords(__('main.student_details'))}}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center mb-4">
                                                <div class="avatar-placeholder bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px; font-size: 30px;">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <h4 class="mt-3">{{$user->name}}</h4>
                                            </div>

                                            <div class="student-details">
                                                <div class="row mb-2">
                                                    <div class="col-5 fw-bold"> {{ucwords(__('main.enrollment_number'))}}:</div>
                                                    <div class="col-7">{{$user->enrollment_number}}</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-5 fw-bold"> {{ucwords(__('main.email'))}}:</div>
                                                    <div class="col-7">{{$user->email}}</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-5 fw-bold"> {{ucwords(__('main.birth_date'))}}:</div>
                                                    <div class="col-7">{{$user->birthdate}}</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-5 fw-bold">{{ucwords(__('main.gender'))}}:</div>
                                                    <div class="col-7">{{__('main.' . lcfirst($user->gender))}}</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-5 fw-bold">{{ucwords(__('main.college'))}}:</div>
                                                    <div class="col-7">{{$user->college->name}}</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-5 fw-bold">{{ucwords(__('main.major'))}}:</div>
                                                    <div class="col-7">{{$user->major->name}}</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-5 fw-bold">{{ucwords(__('main.level'))}}:</div>
                                                    <div class="col-7">{{$user->level->name}}</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-5 fw-bold">{{ucwords(__('main.address'))}}:</div>
                                                    <div class="col-7">{{$user->address}}</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-5 fw-bold">{{ucwords(__('main.phone'))}}:</div>
                                                    <div class="col-7">{{$user->phone}}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ucfirst(__('main.close'))}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(auth()->id() != $user->id)
                                <a type="button" class="btn btn-sm btn-danger " data-bs-title="{{ucfirst(__('main.delete'))}}" data-user-id="{{ $user->id }}" data-fullname="{{ $user->name}}" data-bs-toggle="modal" data-bs-target="#deleteStaffModal-{{$user->id}}"><i class="fas fa-trash"></i></a>

                                <div class="modal fade" id="deleteStaffModal-{{$user->id}}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ucwords(__('main.confirm_student_deletion'))}}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="text-center mb-4">
                                                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                                                    <h4>{{ucwords(__('main.are_you_sure_you_want_to_delete_student_data'))}}</h4>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="deleteReason" class="form-label">{{ucwords(__('main.deletion_reason'))}}</label>
                                                    <textarea id="deleteReason" required class="form-control" rows="3" placeholder="{{ucwords(__('main.enter_deletion_reason_here'))}}" ></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ucfirst(__('main.cancel'))}}</button>

                                                <form method="POST" action="{{route('coordinator.students.destroy', $user->id)}}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" >{{ucfirst(__('main.delete'))}}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if ($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                {{ $users->appends(['search' => request()->query('search')])->links('pagination::bootstrap-4') }}
            @endif
        </div>
    </div>
            </div>
        </div>
    </div>
@endsection


