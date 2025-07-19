@extends('layouts.main')

@section('title',ucwords(__('main.student_affairs_excuses')))



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
        .modal-content {
            border-radius: 15px;
            overflow: hidden;
            max-width: 95%;
            margin: 0 auto;
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
    <div class="row mt-5 animate__animated animate__fadeIn">
        <div class="col-12">
            <div class="card p-4">
                <h3 class="text-center mb-4"><strong>{{ucwords(__('main.review_submitted_excuses'))}}</strong></h3>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead style="background-color: #006400; color: white;">
                        <tr>
                            <th style="background-color: #228B22; color: white;">{{ucwords(__('main.student_name'))}}</th>
                            <th style="background-color: #228B22; color: white;">{{ucwords(__('main.enrollment_number'))}}</th>
                            <th style="background-color: #228B22; color: white;">{{ucfirst(__('main.college'))}}</th>
                            <th style="background-color: #228B22; color: white;">{{ucfirst(__('main.major'))}}</th>
{{--                            <th style="background-color: #228B22; color: white;">{{ucwords(__('main.missed_lecture'))}}</th>--}}
                            <th style="background-color: #228B22; color: white;">{{ucwords(__('main.course'))}}</th>
                            <th style="background-color: #228B22; color: white;">{{ucfirst(__('main.level'))}}</th>
                            <th style="background-color: #228B22; color: white;">{{ucwords(__('main.lecture_date'))}}</th>
                            <th style="background-color: #228B22; color: white;">{{ucwords(__('main.excuse_type'))}}</th>
                            <th style="background-color: #228B22; color: white;">{{ucwords(__('main.documents'))}}</th>
                            <th style="background-color: #228B22; color: white;">{{ucwords(__('main.action'))}}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($attendances as $attendance)
                            <tr>
                                <td>{{$attendance->user->name}}</td>
                                <td>{{$attendance->user->enrollment_number}}</td>
                                <td>{{$attendance->user->college->name}}</td>
                                <td>{{$attendance->user->major->name}}</td>
                                <td>{{$attendance->course->name}}</td>
                                <td>{{$attendance->user->level->name}}</td>
                                <td>{{$attendance->date}}</td>
                                <td>{{$attendance->excuse_type}}</td>
                                <td>

                                    @php
                                        $docUrl = (\Illuminate\Support\Facades\Storage::url($attendance->document_path));
                                    @endphp

                                    <a class="btn btn-success btn-sm"
                                            style="background-color: #FFA500; color: white;"
                                            href="{{$docUrl}}" target="_blank">
                                        {{ucfirst(__('main.view'))}}
                                    </a>
                                </td>
                                <td>
                                    <form action="{{ route('attendances.excuses.update', $attendance->id) }}" method="post" class="excuse-form">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="is_transformed" value="0">
                                        <input type="hidden" name="reject_reason" id="reject_reason_{{$attendance->id}}" value="">

                                        <button type="button" class="btn btn-success btn-sm transform-btn"
                                                style="background-color: #FFA500; color: white;">
                                            {{ucfirst(__('main.transform'))}}
                                        </button>

                                        <button type="button" class="btn btn-danger btn-sm reject-btn"
                                                data-attendance-id="{{ $attendance->id }}">
                                            {{ucfirst(__('main.reject'))}}
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if ($attendances instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        {{ $attendances->appends(['search' => request()->query('search')])->links('pagination::bootstrap-4') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ucwords(__('main.rejection_reason'))}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                    <textarea class="form-control" id="rejectReason" rows="3"
                              placeholder="{{ucwords(__('main.please_enter_rejection_reason'))}}"></textarea>
                        <div id="reasonError" class="text-danger mt-2" style="display: none;">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ucwords(__('main.please_enter_rejection_reason'))}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ucfirst(__('main.cancel'))}}</button>
                    <button type="button" class="btn btn-danger" id="confirmReject">{{ucwords(__('main.confirm_rejection'))}}</button>
                </div>
            </div>
        </div>
    </div>



    <script>
        const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
        const errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
        let currentAttendanceId = null;


        document.querySelectorAll('.transform-btn').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');
                form.querySelector('[name="is_transformed"]').value = '1';
                form.submit();
            });
        });

        document.querySelectorAll('.reject-btn').forEach(button => {
            button.addEventListener('click', function() {
                currentAttendanceId = this.getAttribute('data-attendance-id');

                document.getElementById('rejectReason').classList.remove('is-invalid');
                document.getElementById('reasonError').style.display = 'none';
                document.getElementById('rejectReason').value = '';

                rejectModal.show();
            });
        });

        document.getElementById('confirmReject').addEventListener('click', function() {
            const reason = document.getElementById('rejectReason').value;

            if (!reason.trim()) {
                document.getElementById('rejectReason').classList.add('is-invalid');
                document.getElementById('reasonError').style.display = 'block';

                document.getElementById('toastMessage').textContent = '{{ucwords(__('main.please_enter_rejection_reason'))}}';
                errorToast.show();
                return;
            }

            if (!currentAttendanceId) {
                document.getElementById('toastMessage').textContent = '{{ucwords(__('main.an_error_occurred'))}}';
                errorToast.show();
                return;
            }

            const form = document.querySelector(`.excuse-form input[name="reject_reason"][id="reject_reason_${currentAttendanceId}"]`)?.closest('form');

            if (!form) {
                document.getElementById('toastMessage').textContent = '{{ucwords(__('main.an_error_occurred'))}}';
                errorToast.show();
                return;
            }

            form.querySelector('[name="is_transformed"]').value = '0';
            form.querySelector('[name="reject_reason"]').value = reason;

            rejectModal.hide();

            form.submit();
        });

        document.getElementById('rejectModal').addEventListener('hidden.bs.modal', function() {
            currentAttendanceId = null;
        });
    </script>

@endsection
