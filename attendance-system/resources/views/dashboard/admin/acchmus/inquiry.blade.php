@extends('layouts.main')

@section('title', ucwords(__('main.academic_years_and_courses_management')))



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

        /* شريط جانبي جديد */
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
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: row;
            direction: ltr;
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

        /* بقية الأنماط */
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
        .title {
            font-weight: bold;
            color: #fff;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }
        .form-label {
            color: #fff;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .form-select {
            background-color: rgba(255, 255, 255, 0.9);
            border: 2px solid #fff;
            border-radius: 10px;
            padding: 10px 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .form-select:focus {
            border-color: #FFA500;
            box-shadow: 0 0 0 0.25rem rgba(34, 139, 34, 0.25);
        }
        .list-group-item {
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 8px;
            margin-top: 5px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
        }
        .list-group-item i {
            margin-left: 10px;
            color: #228B22;
        }
        .list-group-item:hover {
            background-color: #fff;
            transform: translateX(-5px);
        }
        .section-title {
            position: relative;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 100px;
            height: 3px;
            background: linear-gradient(to right, #FFA500, #228B22);
            border-radius: 3px;
        }
        .status-indicator {
            display: flex;
            align-items: center;
            margin-top: 15px;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }
        .status-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-left: 10px;
        }
        .dot-active {
            background-color: #4CAF50;
        }
        .dot-inactive {
            background-color: #f44336;
        }
        .teacher-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 15px;
            margin-top: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            color: #333;
        }
        .teacher-card h5 {
            color: #228B22;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .counter {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 5px 15px;
            display: inline-block;
            margin-top: 10px;
            font-weight: bold;
        }
        .submit-btn {
            background: linear-gradient(to right, #FFA500, #228B22);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: bold;
            font-size: 18px;
            transition: all 0.3s;
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }
        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .submit-btn i {
            margin-left: 10px;
        }
        @media (max-width: 768px) {
            .card {
                padding: 15px;
            }
            .submit-btn {
                padding: 10px 20px;
                font-size: 16px;
            }
        }
    </style>


    <div class="content p-4">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center title mb-4"><i class="fas fa-book-open me-2"></i> استعلام المواد</h2>
                        <p class="text-center mb-4">اختر المادة الدراسية من خلال الخطوات المتسلسلة التالية</p>

                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                <div class="mb-4">
                                    <label for="collegeSelect" class="form-label"><i class="fas fa-university me-2"></i>اختر الكلية:</label>
                                    <select class="form-select" id="collegeSelect">
                                        <option selected disabled>اختر الكلية</option>
                                        @foreach($colleges as $college)
                                            <option value="{{ $college->id }}">{{ $college->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="departmentSelect" class="form-label"><i class="fas fa-building me-2"></i>اختر القسم:</label>
                                    <select class="form-select" id="departmentSelect" disabled>
                                        <option selected disabled>اختر القسم</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="levelSelect" class="form-label"><i class="fas fa-layer-group me-2"></i>اختر المستوى:</label>
                                    <select class="form-select" id="levelSelect" disabled>
                                        <option selected disabled>اختر المستوى</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="subjectSelect" class="form-label"><i class="fas fa-book me-2"></i>اختر المادة:</label>
                                    <select class="form-select" id="subjectSelect" disabled>
                                        <option selected disabled>اختر المادة</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="yearSelect" class="form-label"><i class="fas fa-calendar-alt me-2"></i>اختر العام الدراسي:</label>
                                    <select class="form-select" id="yearSelect" disabled>
                                        <option selected disabled>اختر العام الدراسي</option>
                                    </select>
                                </div>

                                <div class="status-indicator">
                                    <div class="status-dot dot-inactive" id="step1"></div>
                                    <div class="status-dot dot-inactive" id="step2"></div>
                                    <div class="status-dot dot-inactive" id="step3"></div>
                                    <div class="status-dot dot-inactive" id="step4"></div>
                                    <div class="status-dot dot-inactive" id="step5"></div>
                                    <span>حالة الإكمال</span>
                                </div>

                                <div id="teachersSection" class="hidden">
                                    <h5 class="section-title"><i class="fas fa-chalkboard-teacher me-2"></i>المدرسين:</h5>
                                    <div id="teachersList"></div>

                                    <div class="counter">
                                        <span id="teachersCount">0</span> مدرسين لهذه المادة
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Function to update step indicators
    function updateStepIndicators(step) {
        for (let i = 1; i <= 5; i++) {
            const dot = document.getElementById(`step${i}`);
            if (i <= step) {
                dot.classList.remove('dot-inactive');
                dot.classList.add('dot-active');
            } else {
                dot.classList.remove('dot-active');
                dot.classList.add('dot-inactive');
            }
        }
    }

    // Function to show/hide teachers section
    function toggleTeachersSection(show) {
        const teachersSection = document.getElementById('teachersSection');
        teachersSection.style.display = show ? 'block' : 'none';
    }

    // Current selection state
    let currentSelection = {
        college: null,
        major: null,
        level: null,
        course: null
    };

    // Academic years from PHP
    const academicYears = @json($academicYears);
    const allCourses = @json($courses);


    $(document).ready(function() {
        toggleTeachersSection(false);
        updateStepIndicators(0);

        // Set CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // College selection changed
        $("#collegeSelect").change(function () {
            const collegeId = $(this).val();
            currentSelection.college = collegeId;

            // Reset subsequent selects
            $("#departmentSelect").prop("disabled", true).empty().append('<option selected disabled>اختر القسم</option>');
            $("#levelSelect").prop("disabled", true).empty().append('<option selected disabled>اختر المستوى</option>');
            $("#subjectSelect").prop("disabled", true).empty().append('<option selected disabled>اختر المادة</option>');
            $("#yearSelect").prop("disabled", true).empty().append('<option selected disabled>اختر العام الدراسي</option>');
            $("#teachersList").empty();
            toggleTeachersSection(false);

            // Fetch departments for this college
            $.get("{{ route('ajax.departments') }}", { college_id: collegeId })
                .done(function(data) {
                    $("#departmentSelect").prop("disabled", false);
                    data.forEach(department => {
                        $("#departmentSelect").append(`<option value="${department.id}">${department.name}</option>`);
                    });
                    updateStepIndicators(1);
                })
                .fail(function() {
                    alert('حدث خطأ أثناء جلب الأقسام');
                });
        });

        // Department selection changed
        $("#departmentSelect").change(function () {
            const majorId = $(this).val();
            currentSelection.major = majorId;

            // Reset subsequent selects
            $("#levelSelect").prop("disabled", true).empty().append('<option selected disabled>اختر المستوى</option>');
            $("#subjectSelect").prop("disabled", true).empty().append('<option selected disabled>اختر المادة</option>');
            $("#yearSelect").prop("disabled", true).empty().append('<option selected disabled>اختر العام الدراسي</option>');
            $("#teachersList").empty();
            toggleTeachersSection(false);

            // Fetch levels for this college and department
            $.get("{{ route('ajax.levels') }}", {
                college_id: currentSelection.college,
                major_id: majorId
            })
                .done(function(data) {
                    $("#levelSelect").prop("disabled", false);
                    data.forEach(level => {
                        $("#levelSelect").append(`<option value="${level.id}">${level.name}</option>`);
                    });
                    updateStepIndicators(2);
                })
                .fail(function() {
                    alert('حدث خطأ أثناء جلب المستويات');
                });
        });

        // Level selection changed
        $("#levelSelect").change(function () {
            const level = $(this).val();
            currentSelection.level = level;

            // Reset subsequent selects
            $("#subjectSelect").prop("disabled", true).empty().append('<option selected disabled>اختر المادة</option>');
            $("#yearSelect").prop("disabled", true).empty().append('<option selected disabled>اختر العام الدراسي</option>');
            $("#teachersList").empty();
            toggleTeachersSection(false);

            // Fetch courses for this combination
            {{--$.get("{{ route('ajax.courses') }}", {--}}
            {{--    college_id: currentSelection.college,--}}
            {{--    major_id: currentSelection.major,--}}
            {{--    level: level--}}
            {{--})--}}
            {{--    .done(function(data) {--}}
            {{--        $("#subjectSelect").prop("disabled", false);--}}
            {{--        data.forEach(course => {--}}
            {{--            $("#subjectSelect").append(`<option value="${course.id}">${course.name}</option>`);--}}
            {{--        });--}}
            {{--        updateStepIndicators(3);--}}
            {{--    })--}}
            {{--    .fail(function() {--}}
            {{--        alert('حدث خطأ أثناء جلب المواد');--}}
            {{--    });--}}


            const filteredCourses = allCourses.filter(course => course.college_id ==  currentSelection.college && course.level_id == currentSelection.level );
            $("#subjectSelect").prop("disabled", false);
            filteredCourses.forEach(course => {
                const option = document.createElement('option');
                option.value = course.id;
                option.textContent = course.name;
                $("#subjectSelect").append(option);
            });
            updateStepIndicators(3);


        });

        // Course selection changed
        $("#subjectSelect").change(function () {
            const courseId = $(this).val();
            currentSelection.course = courseId;

            // Reset year select
            $("#yearSelect").prop("disabled", true).empty().append('<option selected disabled>اختر العام الدراسي</option>');
            $("#teachersList").empty();
            toggleTeachersSection(false);

            // Populate academic years
            $("#yearSelect").prop("disabled", false);
            academicYears.forEach(year => {
                $("#yearSelect").append(`<option value="${year.id}">${year.name}</option>`);
            });
            updateStepIndicators(4);
        });

        // Year selection changed
        $("#yearSelect").change(function () {
            const yearId = $(this).val();

            // Fetch teachers for this combination
            $.get("{{ route('ajax.teachers') }}", {
                college_id: currentSelection.college,
                major_id: currentSelection.major,
                course_id: currentSelection.course,
                academic_year_id: yearId
            })
                .done(function(data) {
                    $("#teachersList").empty();
                    if (data.length === 0) {
                        $("#teachersList").append('<div class="alert alert-info">لا يوجد مدرسين لهذه المادة</div>');
                    } else {
                        data.forEach(teacher => {
                            const teacherCard = `
                        <div class="teacher-card">
                            <h5><i class="fas fa-user-graduate me-2"></i>${teacher.name}</h5>
                            <div class="d-flex justify-content-between mt-3">
                                <div>
                                    <i class="fas fa-envelope me-2"></i>
                                    <small>${teacher.email || 'N/A'}</small>
                                </div>
                                <div>
                                    <i class="fas fa-phone me-2"></i>
                                    <small>${teacher.phone || 'N/A'}</small>
                                </div>
                            </div>
                        </div>`;
                            $("#teachersList").append(teacherCard);
                        });
                    }

                    $("#teachersCount").text(data.length);
                    toggleTeachersSection(true);
                    updateStepIndicators(5);
                })
                .fail(function() {
                    alert('حدث خطأ أثناء جلب المدرسين');
                });
        });
    });
</script>

@endsection
