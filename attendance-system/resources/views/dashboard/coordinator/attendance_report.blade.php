@extends('layouts.main')

@section('title',ucwords(__('main.student_affairs_reports')))



@section('content')

    <style>
        /* تنسيق عام */
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #F5F6FA 0%, #E0E6F0 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .navbar {
            background-color: #4A90E2;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand, .nav-link {
            color: #FFFFFF !important;
        }
        .nav-link:hover {
            background-color: #228B22;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(237,171,72,0.721);
            transition: transform 0.3s ease;
            background: linear-gradient(45deg, #228B22, #ffa600);
            color: #fff;
            padding: 20px;
            margin-bottom: 20px;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .btn {
            border-radius: 25px;
            margin: 0 5px;
        }
        .btn-primary {
            background-color: #228B22;
            border: none;
            padding: 10px 20px;
            transition: background 0.3s;
        }
        .btn-primary:hover {
            background-color: #FFA500;
        }
        /* فئة الإخفاء */
        .hidden {
            display: none;
        }
        /* تنسيق القائمة الأفقية للدروب داون */
        .dropdown-horizontal {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 10px;
        }
        .dropdown-horizontal > div {
            flex: 1;
        }
        /* تنسيق خيارات التقرير */
        .report-options {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        .report-options label {
            margin-bottom: 0;
        }
        /* تنسيق زر تحويل التقرير */
        .transform-btn {
            margin-top: 20px;
        }
        .btn-success {
            background-color: #228B22;
            border: none;
            border-radius: 25px;
            transition: background 0.3s;
        }
        .btn-success:hover {
            background-color: #FFA500;
        }
        /* تنسيق جدول التقرير المخصص */
        .custom-report-table {
            margin-top: 20px;
        }
        /* المحتوى الرئيسي */
        .content {
            margin-right: 250px;
            padding: 40px;
            transition: margin 0.3s;
        }
        /* تنسيق الشاشات المصغرة */
        @media (max-width: 768px) {
            .content {
                margin-right: 0;
                padding: 20px;
            }
            .card {
                margin: 0 0 20px 0;
            }
            .dropdown-horizontal {
                flex-direction: column;
                gap: 10px;
            }
            .dropdown-horizontal > div {
                width: 100%;
            }
            .navbar-brand img {
                height: 40px;
                margin-right: 5px;
            }
            .nav-link {
                padding: 8px 12px;
            }
        }

    </style>


    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="margin-left: 5%;">
                    <div class="card-body">
                        <h5 class="card-title"><strong>{{ucwords(__('main.generate_attendance_report'))}}</strong></h5>
                        <form id="reportForm">
                            @csrf
                            <div class="report-options">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="generalReportCheck">
                                    <label class="form-check-label" for="generalReportCheck">{{ucwords(__('main.general_report'))}}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="customReportCheck">
                                    <label class="form-check-label" for="customReportCheck">{{ucwords(__('main.custom_report'))}}</label>
                                </div>
                            </div>

                            <!-- General Report Section -->
                            <div id="generalReportDiv" class="hidden">
                                <div class="dropdown-horizontal">
                                    <!-- College Filter -->
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="filterCollege">
                                            <label class="form-check-label" for="filterCollege">{{ucwords(__('main.by_college'))}}</label>
                                        </div>
                                        <select class="form-select hidden" id="collegeSelect">
                                            <option value="">{{ucwords(__('main.select_college'))}}</option>
                                            @foreach($colleges as $college)
                                                <option value="{{ $college->id }}">{{ $college->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Major Filter -->
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="filterSpecialization">
                                            <label class="form-check-label" for="filterSpecialization">{{ucwords(__('main.by_major'))}}</label>
                                        </div>
                                        <select class="form-select hidden @error('major_id') is-invalid @enderror" id="majorSelect" name="major_id">
                                            <option selected disabled value="">{{ ucwords(__('main.select_major')) }}</option>
                                        </select>

                                        <select class="form-select hidden @error('level_id') is-invalid @enderror" id="levelSelect" name="level_id">
                                            <option selected disabled value="">{{ ucwords(__('main.select_level')) }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="generalReportTable" class="hidden custom-report-table mt-3">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead style="background-color:#228B22; color:white;">
                                            <tr>
                                                <th>#</th>
                                                <th>{{ucfirst(__('main.name'))}}</th>
                                                <th>{{ucwords(__('main.enrollment_number'))}}</th>
                                                <th>{{ucfirst(__('main.college'))}}</th>
                                                <th>{{ucfirst(__('main.major'))}}</th>
                                                <th>{{ucfirst(__('main.level'))}}</th>
                                                <th>{{ ucfirst(__('main.course')) }}</th>
                                                <th>{{ ucfirst(__('main.course_type')) }}</th>
                                                <th>{{ucwords(__('main.number_of_present'))}}</th>
                                                <th>{{ucwords(__('main.number_of_absences'))}}</th>
                                                <th>{{ucfirst(__('main.percentage'))}}</th>
                                            </tr>
                                            </thead>
                                            <tbody id="generalReportBody">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="generalReportAction" class="hidden transform-btn">
                                        <button type="button" class="btn btn-success" id="sendGeneralReportBtn">{{ucwords(__('main.forward_to_department_head'))}}</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Custom Report Section -->
                            <div id="customReportDiv" class="hidden">
                                <div class="mb-3">
                                    <label for="studentInput" class="form-label">{{ucwords(__('main.enter_student_number_or_name'))}}</label>
                                    <input type="text" class="form-control" id="studentInput" placeholder="{{ucwords(__('main.enter_student_number_or_name'))}}">
                                    <div id="studentResults" class="list-group mt-2 hidden"></div>
                                </div>
                                <div id="customReportTable" class="hidden custom-report-table">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead style="background-color: #228B22; color: white;">
                                            <tr>
                                                <th>#</th>
                                                <th>{{ucfirst(__('main.name'))}}</th>
                                                <th>{{ucwords(__('main.enrollment_number'))}}</th>
                                                <th>{{ucfirst(__('main.college'))}}</th>
                                                <th>{{ucfirst(__('main.major'))}}</th>
                                                <th>{{ucfirst(__('main.level'))}}</th>
                                                <th>{{ ucfirst(__('main.course')) }}</th>
                                                <th>{{ ucfirst(__('main.course_type')) }}</th>
                                                <th>{{ucwords(__('main.number_of_present'))}}</th>
                                                <th>{{ucwords(__('main.number_of_absences'))}}</th>
                                                <th>{{ucfirst(__('main.percentage'))}}</th>
                                            </tr>
                                            </thead>
                                            <tbody id="customReportBody">
                                            <!-- Data come by AJAX -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-success mt-2" id="sendCustomReportBtn">{{ucwords(__('main.forward_to_department_head'))}}</button>
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary mt-3" id="createReportBtn">{{ucwords(__('main.create_report'))}}</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sent Reports Card -->
            {{--            <div class="col-md-12">--}}
            {{--                <div class="card" style="margin-left: 5%;">--}}
            {{--                    <div class="card-body">--}}
            {{--                        <h5 class="card-title"><strong>التقارير المرسلة</strong></h5>--}}
            {{--                        <ul class="list-group" id="sentReportsList">--}}
            {{--                            <!-- Sent reports populated by AJAX -->--}}
            {{--                        </ul>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}

            <div class="col-md-12">
                <div class="card" style="margin-left: 5%;">
                    <div class="card-body">
                        <h5 class="card-title"><strong>{{ucwords(__('main.sent_reports'))}}</strong></h5>

                        <ul class="list-group">
                            @forelse($sentReports as $index => $report)
                                {{--                                <li class="list-group-item d-flex justify-content-between align-items-center">--}}
                                {{--                                    تقرير حضور تم تحويله - {{ $report->user->name }}--}}
                                {{--                                    {{$report->created_at->format('Y-m-d')}}--}}
                                {{--                                    <button class="btn btn-warning btn-sm"--}}
                                {{--                                            onclick="toggleSentReport({{ $report->id }}, this)">--}}
                                {{--                                        {{ucwords(__('main.view_report'))}}--}}
                                {{--                                    </button>--}}
                                {{--                                    <button class="btn btn-primary btn-sm"--}}
                                {{--                                            onclick="downloadReportAsPdf({{ $report->id }})">--}}
                                {{--                                        <i class="fas fa-download"></i> {{ucwords(__('main.download_pdf'))}}--}}
                                {{--                                    </button>--}}
                                {{--                                </li>--}}

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{$report->created_at->format('Y-m-d')}}
                                    <div>
                                        <button class="btn btn-warning btn-sm mr-2"
                                                onclick="toggleSentReport({{ $report->id }}, this)">
                                            {{ucwords(__('main.view_report'))}}
                                        </button>
                                        <a href="{{route('download.pdf', $report->id)}}" class="btn btn-primary btn-sm"
                                           target="_blank">
                                            <i class="fas fa-download"></i> {{ucwords(__('main.download_pdf'))}}
                                        </a>
                                    </div>
                                </li>

                                <div id="sentReportContainer-{{ $report->id }}" class="mt-2 d-none">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-center">
                                            <thead style="background-color: #228B22; color: white;">
                                            <tr>
                                                <th style="background-color:#228B22; color:white;">#</th>
                                                <th style="background-color:#228B22; color:white;">{{ucfirst(__('main.name'))}}</th>
                                                <th style="background-color:#228B22; color:white;"> {{ucwords(__('main.enrollment_number'))}}</th>
                                                <th style="background-color:#228B22; color:white;">{{ucfirst(__('main.college'))}}</th>
                                                <th style="background-color:#228B22; color:white;">{{ucfirst(__('main.major'))}}</th>
                                                <th style="background-color:#228B22; color:white;">{{ucfirst(__('main.level'))}}</th>
                                                <th style="background-color:#228B22; color:white;">{{ ucfirst(__('main.course')) }}</th>
                                                <th style="background-color:#228B22; color:white;">{{ ucfirst(__('main.course_type')) }}</th>
                                                <th style="background-color:#228B22; color:white;">{{ucfirst(__('main.number_of_present'))}}</th>
                                                <th style="background-color:#228B22; color:white;">{{ucfirst(__('main.number_of_absences'))}}</th>
                                                <th style="background-color:#228B22; color:white;">{{ucfirst(__('main.percentage'))}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($report->report_data as $reda)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{ $reda['student_name'] ?? ''}}</td>
                                                    <td>{{ $reda['enrollment_number'] ?? ''}}</td>
                                                    <td>{{ $reda['college'] ?? ''}}</td>
                                                    <td>{{ $reda['major'] ?? ''}}</td>
                                                    <td>{{ $reda['level'] ?? ''}}</td>
                                                    <td>{{ $reda['course'] ?? ''}}</td>
                                                    <td>{{ $reda['course_type'] ?? ''}}</td>
                                                    <td>{{ $reda['present_count'] ?? ''}}</td>
                                                    <td>{{ $reda['absent_count'] ?? ''}}</td>
                                                    <td>{{ $reda['percentage'] ?? ''}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @empty
                                <li class="list-group-item text-center">{{ucwords(__('main.no_sent_reports'))}}</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            let currentReportId = null;
            let currentLocale = '{{ LaravelLocalization::getCurrentLocale()}}';
            const majorSelect = document.getElementById('majorSelect');
            const levelSelect = document.getElementById('levelSelect');

            majorSelect.innerHTML = '<option selected disabled value="">{{ ucwords(__("main.select_major")) }}</option>';
            levelSelect.innerHTML = '<option selected disabled value="">{{ ucwords(__("main.select_level")) }}</option>';
            const allMajors = @json($majors);
            const allLevels = @json($levels);

            allMajors.forEach(major => {
                const option = document.createElement('option');
                option.value = major.id;
                option.textContent = major.name;
                option.setAttribute('data-num-levels', major.num_levels);
                majorSelect.appendChild(option);
            });

            function updateLevels() {
                const selectedOption = majorSelect.options[majorSelect.selectedIndex];
                const numLevels = parseInt(selectedOption.getAttribute('data-num-levels'));

                levelSelect.innerHTML = '<option selected disabled value="">{{ ucwords(__("main.select_level")) }}</option>';

                if (!isNaN(numLevels) && numLevels > 0) {
                    const validLevels = allLevels.slice(0, numLevels);

                    validLevels.forEach(level => {
                        const option = document.createElement('option');
                        option.value = level.id;
                        option.textContent = level.name;
                        levelSelect.appendChild(option);
                    });

                    // Restore old level selection
                    const oldLevelId = "{{ old('level_id') }}";
                    if (oldLevelId) {
                        levelSelect.value = oldLevelId;
                    }
                }
            }

            majorSelect.addEventListener('change', updateLevels);


            $('#generalReportCheck, #customReportCheck').change(function() {
                if ($(this).is(':checked')) {
                    if (this.id === 'generalReportCheck') {
                        $('#customReportCheck').prop('checked', false);
                        $('#generalReportDiv').removeClass('hidden');
                        $('#customReportDiv').addClass('hidden');
                    } else {
                        $('#generalReportCheck').prop('checked', false);
                        $('#customReportDiv').removeClass('hidden');
                        $('#generalReportDiv').addClass('hidden');
                    }
                }
            });

            $('#filterCollege').change(function() {
                $('#collegeSelect').toggleClass('hidden', !this.checked);
            });

            $('#filterSpecialization').change(function() {
                $('#majorSelect').toggleClass('hidden', !this.checked);
                $('#levelSelect').toggleClass('hidden', !this.checked);
            });



            $('#studentInput').keyup(function() {
                const query = $(this).val().trim();
                if (query.length > 2) {
                    $.ajax({
                        url:  '/' + currentLocale + '/coordinator/search-students',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            query: query
                        },
                        success: function(response) {
                            let html = '';
                            response.forEach(student => {
                                html += `<a href="#" class="list-group-item list-group-item-action"
                                     data-id="${student.id}">
                                     ${student.name} (${student.enrollment_number})
                                 </a>`;
                            });
                            $('#studentResults').html(html).removeClass('hidden');
                        }
                    });
                } else {
                    $('#studentResults').addClass('hidden');
                }
            });

            $(document).on('click', '#studentResults a', function(e) {
                e.preventDefault();
                const studentId = $(this).data('id');
                const studentName = $(this).text();
                $('#studentInput').val(studentName);
                $('#studentInput').data('studentId', studentId);
                $('#studentResults').addClass('hidden');
            });

            $('#createReportBtn').click(function() {
                const type = $('#generalReportCheck').is(':checked') ? 'general' : 'custom';

                if (type === 'general') {
                    const filters = {
                        college_id: $('#filterCollege').is(':checked') ? $('#collegeSelect').val() : null,
                        major_id: $('#filterSpecialization').is(':checked') ? $('#majorSelect').val() : null,
                        level_id: $('#filterSpecialization').is(':checked') ? $('#levelSelect').val() : null,
                    };

                    if (!filters.college_id && !filters.major_id && !filters.level_id) {
                        Swal.fire('{{ucwords(__('main.please_select_at_least_one_option'))}}', '', 'warning');
                        return;
                    }

                    generateReport(type, filters);
                } else {
                    const studentId = $('#studentInput').data('studentId');
                    if (!studentId) {
                        Swal.fire('{{ucwords(__('main.please_select_a_student_from_the_list'))}}', '', 'warning');
                        return;
                    }

                    generateReport(type, {user_id: studentId});
                }
            });

            $('#sendGeneralReportBtn, #sendCustomReportBtn').click(function() {
                if (!currentReportId) {
                    Swal.fire('{{ucwords(__('main.no_report_to_send'))}}', '', 'error');
                    return;
                }

                $.ajax({
                    url: '/' + currentLocale + '/coordinator/send-report',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        report_id: currentReportId
                    },
                    success: function() {
                        Swal.fire('{{ucwords(__('main.sent_successfully'))}}', '{{ucwords(__('main.report_sent_successfully'))}}', 'success');
                        $('.report-table').addClass('hidden');
                        loadSentReports();
                    }
                });
            });

            function generateReport(type, filters) {
                $.ajax({
                    url: '/' + currentLocale + '/coordinator/generate-report',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        type: type,
                        ...filters
                    },
                    success: function(response) {
                        if (response.success) {
                            currentReportId = response.report_id;

                            if (type === 'general') {
                                populateTable('#generalReportBody', response.report);
                                $('#generalReportTable, #generalReportAction').removeClass('hidden');
                            } else {
                                populateTable('#customReportBody', response.report);
                                $('#customReportTable').removeClass('hidden');
                            }

                            Swal.fire('{{ucwords(__('main.created_successfully'))}}', '{{ucwords(__('main.report_created_successfully'))}}', 'success');

                        }
                    }
                });
            }

            function populateTable(selector, data) {
                let html = '';
                data.forEach(row => {
                    html += `<tr>
                    <td>${row.counter}</td>
                    <td>${row.student_name}</td>
                    <td>${row.enrollment_number}</td>
                    <td>${row.college}</td>
                    <td>${row.major}</td>
                    <td>${row.level}</td>
                     <td>${row.course}</td>
                    <td>${row.course_type}</td>
                    <td>${row.present_count}</td>
                    <td>${row.absent_count}</td>
                    <td>${row.percentage}</td>
                </tr>`;
                });
                $(selector).html(html);
            }

            function loadSentReports() {
                $.ajax({
                    url: '/coordinator/sent-reports',
                    method: 'GET',
                    success: function(response) {
                        let html = '';
                        response.reports.forEach(report => {
                            const date = new Date(report.sent_at).toLocaleDateString();
                            html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                             {{ucfirst(__('main.report'))}} ${report.type === 'general' ? '{{ucfirst(__('main.general_option'))}}' : '{{ucfirst(__('main.custom'))}}'} - ${date}
                            <button class="btn btn-warning btn-sm view-report-btn"
                                data-report='${JSON.stringify(report.report_data)}'>
                                {{ucwords(__('main.view_report'))}}
                            </button>
                        </li>`;
                        });
                        $('#sentReportsList').html(html);
                    }
                });
            }

            // View sent report
            $(document).on('click', '.view-report-btn', function() {
                const reportData = $(this).data('report');
                const modalHtml = `
                <div class="modal fade" id="reportModal" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ucwords(__("main.sent_report"))}}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead style="background-color:#228B22; color:white;">
                                            <tr>
                                                <th>{{ucfirst(__('main.name'))}}</th>
                                                <th>{{ucwords(__('main.enrollment_number'))}}</th>
                                                <th>{{ucfirst(__('main.major'))}}</th>
                                                <th>{{ucfirst(__('main.level'))}}</th>
{{--                                                <th>المقرر</th>--}}
                {{--                                                <th>نوع المادة</th>--}}
                <th>{{ucwords(__('main.number_of_present'))}}</th>
                                                <th>{{ucwords(__('main.number_of_absences'))}}</th>
                                                <th>{{ucfirst(__('main.percentage'))}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${reportData.map(row => `
                                                <tr>
                                                    <td>${row.counter}</td>
                                                    <td>${row.student_name}</td>
                                                    <td>${row.enrollment_number}</td>
                                                    <td>${row.major}</td>
                                                    <td>${row.level}</td>
<!--                                                    <td>${row.course}</td>-->
<!--                                                    <td>${row.course_type}</td>-->
                                                    <td>${row.present_count}</td>
                                                    <td>${row.absent_count}</td>
                                                    <td>${row.percentage}</td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

                $('body').append(modalHtml);
                $('#reportModal').modal('show');

                $('#reportModal').on('hidden.bs.modal', function() {
                    $(this).remove();
                });
            });

            // loadSentReports();
        });

        function toggleSentReport(id, btn) {
            const container = document.getElementById(`sentReportContainer-${id}`);
            if (container.classList.contains('d-none')) {
                container.classList.remove('d-none');
                btn.textContent = '{{ucwords(__('main.hide_report'))}}';
            } else {
                container.classList.add('d-none');
                btn.textContent = '{{ucwords(__('main.view_report'))}}';
            }
        }


    </script>
@endsection

