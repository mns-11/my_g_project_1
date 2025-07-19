@extends('layouts.main')

@section('title', ucwords(__('main.majors_chiefs_management')))



@section('content')


    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #F5F6FA 0%, #E0E6F0 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            color: #333;
        }
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            right: 0;
            height: 100%;
            width: 250px;
            background: linear-gradient(45deg, #FFA500, #228B22);
            padding-top: 20px;
            color: white;
            transition: all 0.3s;
            box-shadow: 0 4px 15px #e0a800;
            z-index: 100;
        }
        .sidebar h3 {
            margin-bottom: 20px;
        }
        .sidebar a {
            color: white;
            padding: 15px 20px;
            text-decoration: none;
            display: block;
            font-size: 16px;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background-color: #228B22;
        }
        /* Main Content */
        .content {
            margin-right: 250px;
            padding: 40px;
            transition: margin 0.3s;
        }

        @media (max-width: 992px) {
            .sidebar {
                width: 200px;
            }
            .content {
                margin-right: 200px;
                padding: 30px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .content {
                margin-right: 0;
                padding: 20px;
            }
        }

        /* Header Container */
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

        /* Table Container */
        .table-container {
            width: 100%;
            overflow-x: auto;
            margin-top: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        /* Table */
        .table {
            background-color: #FFA500;
            border-radius: 10px;
            overflow: hidden;
            min-width: 700px;
        }
        .table th, .table td {
            padding: 12px;
            text-align: center;
            white-space: nowrap;
        }

        /* Responsive table cells */
        @media (max-width: 768px) {
            .table th, .table td {
                padding: 10px 8px;
                font-size: 14px;
            }
        }

        /* Buttons */
        .btn {
            border-radius: 25px;
            margin: 0 3px;
            padding: 8px 12px;
            font-size: 14px;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 13px;
        }
        .btn-primary {
            background-color: #228B22;
            border: none;
            transition: background 0.3s;
        }
        .btn-primary:hover {
            background-color: #FFA500;
        }
        .btn-success {
            background-color: #28a745;
            border: none;
            transition: background 0.3s;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
            transition: background 0.3s;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }

        /* Modal styles */
        .modal-content {
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: linear-gradient(45deg, #228B22, #FFA500);
            color: white;
            border-radius: 20px 20px 0 0 !important;
        }

        .btn-close {
            filter: invert(1);
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

        /* Highlight current page */
        .sidebar a[href="لوحة التحكم - الموظفين.html"] {
            background-color: #228B22;
            font-weight: bold;
        }

        /* Employee role badge */
        .role-badge {
            background-color: #218838;
            color: white;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 14px;
        }
    </style>

    <div class="content p-4">
        <div class="header-container">
            <h2>{{ ucwords(__('main.majors_chiefs_management'))}}</h2>
            <div class="d-flex flex-wrap gap-2">
                <form class="position-relative" method="GET" action="{{route('chiefs.index') }}" id="search-form">
                    <input type="text" class="form-control" id="search-staff" placeholder="{{ucwords(__('main.search_here'))}}"
                           style="max-width: 250px;" onkeyup="searchTable('staff')" value="{{ request()->query('search') }}"
                           oninput="searchFormSubmit()" name="search"/>

                    @error('search', 'searchErrors')
                    <span class="validation-text text-danger">{{ $message }}</span>
                    @enderror
                </form>
                <a href="{{route('chiefs.create')}}" class="btn btn-primary" >
                    <i class="fas fa-plus me-1"></i>{{ucwords(__('main.add_chief'))}}
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

        <div class="table-container">
            <table class="table table-striped" id="staff-table">
                <thead>
            <tr>
                <th style="background-color:#218838 ;color: white;">#</th>
                <th style="background-color:#218838 ;color: white;">{{ucfirst(__('main.name'))}}</th>
                <th style="background-color:#218838 ;color: white;">{{ucfirst(__('main.major'))}}</th>
                <th style="background-color:#218838 ;color: white;">{{ucfirst(__('main.birth_date'))}}</th>
                <th style="background-color:#218838 ;color: white;">{{ucfirst(__('main.gender'))}}</th>
                <th style="background-color:#218838 ;color: white;">{{ucfirst(__('main.email'))}}</th>
                <th style="background-color:#218838 ;color: white;">{{ucfirst(__('main.address'))}}</th>
                <th style="background-color:#218838 ;color: white;">{{ucfirst(__('main.mobile_number'))}}</th>
                <th style="background-color:#218838 ;color: white;">{{ucfirst(__('main.actions'))}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->major->name}}</td>
                    <td>{{$user->birthdate}}</td>
                    <td><span class="gender-badge gender-{{lcfirst($user->gender)}}">{{__('main.' . lcfirst($user->gender))}}</span></td>                    <td>{{$user->email}}</td>
                    <td>{{$user->address}}</td>
                    <td>{{$user->phone}}</td>
                    <td>
                        <a href="{{route('chiefs.edit', $user->id)}}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        @if(auth()->id() != $user->id)
                            <a type="button" class="btn btn-sm btn-danger " data-bs-title="{{ucfirst(__('main.delete'))}}" data-user-id="{{ $user->id }}" data-fullname="{{ $user->name}}" data-bs-toggle="modal" data-bs-target="#deleteStaffModal-{{$user->id}}"><i class="fas fa-trash"></i></a>

                            <div class="modal fade" id="deleteStaffModal-{{$user->id}}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ucwords(__('main.confirm_deletion'))}}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center mb-4">
                                                <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                                                <h4>{{ucwords(__('main.are_you_sure_you_want_to_delete_this_chief'))}}</h4>
                                            </div>
                                            <div class="mb-3">
                                                <label for="deleteReason" class="form-label">{{ucwords(__('main.deletion_reason'))}}</label>
                                                <textarea id="deleteReason" required class="form-control" rows="3" placeholder="{{ucwords(__('main.enter_deletion_reason_here'))}}" ></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ucfirst(__('main.cancel'))}}</button>

                                            <form method="POST" action="{{route('chiefs.destroy', $user->id)}}">
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


@endsection
