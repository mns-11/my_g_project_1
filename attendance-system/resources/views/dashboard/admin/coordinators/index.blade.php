@extends('layouts.main')

@section('title', ucwords(__('main.student_coordinators_management')))



@section('content')


    <div class="content p-4">
        <h2>{{ ucwords(__('main.student_coordinators_management'))}}</h2>
        <form class="position-relative" method="GET" action="{{route('coordinators.index') }}" id="search-form">
            <input
                type="text"
                name="search"
                class="form-control mb-3 @error('search', 'searchErrors') is-invalid @enderror product-search ps-5"
                id="search-doctors"
                placeholder="{{ucwords(__('main.search_here'))}}"
                value="{{ request()->query('search') }}"
                oninput="searchFormSubmit()" />
            <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
            @error('search', 'searchErrors')
            <span class="validation-text text-danger">{{ $message }}</span>
            @enderror

        </form>

        <script>
            let timeout;

            function searchFormSubmit() {
                clearTimeout(timeout);
                timeout = setTimeout(function() {
                    document.getElementById('search-form').submit();
                }, 500);
            }
        </script>
        <a href="{{route('coordinators.create')}}" class="btn btn-primary mb-3">{{ucwords(__('main.add_coordinator'))}}</a>
        <table class="table table-striped" id="doctors-table">
            <thead>
            <tr>
                <th style="background-color:#218838 ;color: white;">#</th>
                <th style="background-color:#218838 ;color: white;">{{ucfirst(__('main.name'))}}</th>
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
                    <td>{{$user->birthdate}}</td>
                    <td>{{$user->gender}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->address}}</td>
                    <td>{{$user->phone}}</td>
                    <td>
                        <a href="{{route('coordinators.edit', $user->id)}}" class="btn btn-sm btn-warning">{{ucfirst(__('main.edit'))}}</a>
                        @if(auth()->id() != $user->id)
                            <a type="button" class="btn btn-sm btn-danger " data-bs-title="{{ucfirst(__('main.delete'))}}" data-user-id="{{ $user->id }}" data-fullname="{{ $user->name}}" data-bs-toggle="modal" data-bs-target="#RemoveModal">{{ucfirst(__('main.delete'))}}</a>
                            <div class="modal fade" id="RemoveModal" tabindex="-1" aria-labelledby="RemoveModal" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex align-items-center">
                                            <h5 class="modal-title">{{ucfirst(__('main.confirm'))}} {{ucfirst(__('main.deletion'))}}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>{{ucwords(__('main.confirm_deletion_message'))}} <span id="deleteStaffFullName" class="fw-bold text-danger"></span>{{__('main.question_mark')}}</p>
                                        </div>

                                        <div class="modal-footer">
                                            <div class="d-flex gap-6 m-0">
                                                <form class="row g-3 needs-validation" novalidate id="deleteStaffForm" method="POST" action="{{route('coordinators.destroy', $user->id)}}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" >{{ucfirst(__('main.delete'))}}</button>
                                                </form>
                                                {{--                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal"> {{ucfirst(__('main.cancel'))}}--}}
                                                {{--                        </button>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <script>
                                $(document).on('click', '.deleteStaff', function() {
                                    var fullname = $(this).data('fullname');
                                    var userId = $(this).data('user-id');
                                    $('#deleteStaffFullName').text(fullname);
                                });

                            </script>
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
