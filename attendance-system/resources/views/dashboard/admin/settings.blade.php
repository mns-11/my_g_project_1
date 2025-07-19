@extends('layouts.main')

@section('title', ucwords(__('main.settings')))

@section('content')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <!-- Animate.css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #F5F6FA 0%, #E0E6F0 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            color: #333;
        }
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
        .card {
            border: none;
            border-radius: 30px;
            box-shadow: 0 6px 20px rgba(237, 171, 72, 0.721);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 20px;
            background: linear-gradient(45deg, #228B22, #FFA500);
            color: #fff;
            padding: 20px;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .btn {
            border-radius: 25px;
            margin: 0 5px;
            padding: 10px 20px;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #218838;
            border: none;
            transition: background 0.3s;
        }
        .btn-primary:hover {
            background-color: #FFA500;
        }
        /* فئة الإخفاء */
        .hidden {
            display: none;
        }
        /* تنسيق سلسلة الدروب داون الأفقي */
        .dropdown-horizontal {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .dropdown-horizontal > div {
            min-width: 200px;
            flex: 1;
        }
        .form-check-label {
            font-weight: bold;
            font-size: 18px;
        }

        /* تنسيقات متجاوبة */
        @media (max-width: 768px) {
            .dropdown-horizontal {
                flex-direction: column;
                gap: 10px;
            }
            .dropdown-horizontal > div {
                width: 100%;
            }
            .btn {
                width: 100%;
                margin: 5px 0;
            }
        }

        /* تحسينات الشاشات الصغيرة */
        @media (max-width: 576px) {
            .card {
                padding: 15px;
            }
            .form-label {
                font-size: 16px;
            }
            .form-select {
                padding: 8px 12px;
                font-size: 14px;
            }
            .btn {
                padding: 8px 16px;
                font-size: 14px;
            }
        }

        /* تحسين مظهر القوائم المنسدلة */
        .form-select {
            background-color: #fff;
            border: 2px solid #218838;
            border-radius: 10px;
            color: #333;
            font-weight: 500;
        }

        /* تنسيقات إضافية */
        .card-title {
            font-size: 24px;
            margin-bottom: 25px;
            text-align: center;
            padding-bottom: 15px;
            border-bottom: 2px solid rgba(255,255,255,0.3);
        }

        /* تظليل للأزرار */
        .btn-block {
            background-color: #ff6b00;
            border: none;
        }

        /* إبراز الصفحة الحالية */
        .sidebar a[href="لوحة التحكم - الاعدادات.html"] {
            background-color: #228B22;
            font-weight: bold;
        }

        /* تنسيقات متقدمة للوضع الداكن */
        .dark-mode {
            background: linear-gradient(135deg, #1a2a3a 0%, #0d1b2a 100%);
            color: #f0f0f0;
        }
        .dark-mode .card {
            background: linear-gradient(45deg, #1a3a1a, #2a5a2a);
            color: #f0f0f0;
        }
        .dark-mode .form-select {
            background-color: #2c3e50;
            border-color: #4da64d;
            color: #f0f0f0;
        }

        /* تنسيقات التحويل بين الوضعين */
        .theme-toggle {
            position: absolute;
            top: 20px;
            left: 20px;
            background: #f8f9fa;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 10;
        }
    </style>

    <div class="content">
{{--    <button class="theme-toggle" id="themeToggle">--}}
{{--        <i class="fas fa-moon"></i>--}}
{{--    </button>--}}

    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><strong>{{ucwords(__('main.system_settings'))}}</strong></h5>
            <form action="{{ route('settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label for="language" class="form-label">{{ucfirst(__('main.language'))}}</label>
                        <select class="form-select" id="language" name="language">
                            <option value="ar" {{ $settings['language'] == 'ar' ? 'selected' : '' }}>العربية</option>
                            <option value="en" {{ $settings['language'] == 'en' ? 'selected' : '' }}>English</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="theme" class="form-label">{{ucfirst(__('main.theme'))}}</label>
                        <select class="form-select" id="theme" name="theme">
                            <option value="light" {{ $settings['theme'] == 'light' ? 'selected' : '' }}>{{ucfirst(__('main.light'))}}</option>
                            <option value="dark" {{ $settings['theme'] == 'dark' ? 'selected' : '' }}>{{ucfirst(__('main.dark'))}}</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12 mb-3">
                        <label for="emailNotifications" class="form-label">{{ucwords(__('main.email_notifications'))}}</label>
                        <select class="form-select" id="emailNotifications" name="email_notifications">
                            <option value="on" {{ $settings['email_notifications'] == 'on' ? 'selected' : '' }}>{{ucfirst(__('main.enabled'))}}</option>
                            <option value="off" {{ $settings['email_notifications'] == 'off' ? 'selected' : '' }}>{{ucfirst(__('main.disabled'))}}</option>
                        </select>
                    </div>
{{--                    <div class="col-md-6 mb-3">--}}
{{--                        <label for="backupFrequency" class="form-label">نسخ احتياطي تلقائي</label>--}}
{{--                        <select class="form-select" id="backupFrequency" name="backup_frequency">--}}
{{--                            <option value="daily" {{ $settings['backup_frequency'] == 'daily' ? 'selected' : '' }}>يومي</option>--}}
{{--                            <option value="weekly" {{ $settings['backup_frequency'] == 'weekly' ? 'selected' : '' }}>أسبوعي</option>--}}
{{--                            <option value="monthly" {{ $settings['backup_frequency'] == 'monthly' ? 'selected' : '' }}>شهري</option>--}}
{{--                            <option value="none" {{ $settings['backup_frequency'] == 'none' ? 'selected' : '' }}>لا يوجد</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
                </div>

                <div class="settings-section mb-4">
                    <h6 class="mb-3"><i class="fas fa-ban me-2"></i>{{ ucwords(__('main.manage_blocked_courses')) }}</h6>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="blockSubjectCheck"
                                   name="block_subject_enabled" value="1"
                                   {{ $settings['block_subject_enabled'] ? 'checked' : '' }}
                                   style="transform: scale(1.5);">
                            <label class="form-check-label ms-2" for="blockSubjectCheck">
                                <strong>{{ ucwords(__('main.activate_blocking_of_courses')) }}</strong>
                            </label>
                        </div>
                    </div>

                    <div id="dropdownContainer" class="dropdown-horizontal {{ $settings['block_subject_enabled'] ? '' : 'd-none' }}">
                        <!-- Major -->
                        <div>
                            <label for="specializationSelect" class="form-label">{{ ucfirst(__('main.major')) }}</label>
                            <select class="form-select" id="specializationSelect" name="specialization">
                                <option value="">{{ ucwords(__('main.select_major')) }}</option>
                                @foreach($specializations as $major)
                                    <option value="{{ $major['id'] }}"
                                            data-num-levels="{{ $major['num_levels'] }}"
                                        {{ $settings['specialization'] == $major['id'] ? 'selected' : '' }}>
                                        {{ $major['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="levelSelect" class="form-label">{{ ucfirst(__('main.level')) }}</label>
                            <select class="form-select" id="levelSelect" name="level">
                                <option value="">{{ ucwords(__('main.select_level')) }}</option>
                                @foreach($levels as $level)
                                    <option value="{{ $level['id'] }}"
                                        {{ $settings['level'] == $level['id'] ? 'selected' : '' }}>
                                        {{ $level['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="subjectDiv" class="d-none">
                            <label for="subjectSelect" class="form-label">{{ ucfirst(__('main.course')) }}</label>
                            <select class="form-select" id="subjectSelect" name="subject">
                                <option value="">{{ ucwords(__('main.select_course')) }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="button" class="btn btn-block btn-primary d-none" id="blockButton">
                            {{ ucwords(__('main.execute_blocking')) }}
                        </button>
                    </div>
                </div>

                <div class="settings-section mb-4">
                    <h6 class="mb-3"><i class="fas fa-user-clock me-2"></i> {{ucwords(__('main.attendance_settings'))}}</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="attendanceThreshold" class="form-label"> {{ucwords(__('main.required_attendance_percentage'))}} (%)</label>
                            <input type="range" class="form-range" id="attendanceThreshold"
                                   min="50" max="100" value="{{ $settings['attendance_threshold'] }}"
                                   name="attendance_threshold">
                            <div class="text-center mt-2" id="thresholdValue">{{ $settings['attendance_threshold'] }}%</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lateThreshold" class="form-label">{{ucwords(__('main.allowed_delay_limit_minutes'))}}</label>
                            <input type="number" class="form-control" id="lateThreshold"
                                   min="1" max="30" value="{{ $settings['late_threshold'] }}"
                                   name="late_threshold">
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-3 mt-4">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="fas fa-save me-2"></i>{{ucwords(__('main.save_settings'))}}
                    </button>
                    <button type="button" class="btn btn-secondary flex-grow-1" id="resetButton">
                        <i class="fas fa-undo me-2"></i>{{ucwords(__('main.restore_default_settings'))}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS & SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const blockSubjectCheck = document.getElementById('blockSubjectCheck');
            const dropdownContainer = document.getElementById('dropdownContainer');
            const specializationSelect = document.getElementById('specializationSelect');
            const levelSelect = document.getElementById('levelSelect');
            const subjectDiv = document.getElementById('subjectDiv');
            const subjectSelect = document.getElementById('subjectSelect');
            const blockButton = document.getElementById('blockButton');

            const allLevels = @json($levels);
            const allSubjects = @json($subjects);
            const savedSettings = {
                major: "{{ $settings['specialization'] }}",
                level: "{{ $settings['level'] }}",
                subject: "{{ $settings['subject'] }}"
            };

            specializationSelect?.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const numLevels = parseInt(selectedOption.getAttribute('data-num-levels'));

                levelSelect.innerHTML = '<option value="">{{ ucwords(__("main.select_level")) }}</option>';
                subjectDiv.classList.add('d-none');
                blockButton?.classList.add('d-none');

                if (!isNaN(numLevels) && numLevels > 0) {
                    const validLevels = allLevels.slice(0, numLevels);
                    validLevels.forEach(level => {
                        const option = document.createElement('option');
                        option.value = level.id;
                        option.textContent = level.name;
                        levelSelect.appendChild(option);
                    });

                    if (savedSettings.level) {
                        levelSelect.value = savedSettings.level;
                        filterSubjects();
                    }
                }
            });

            levelSelect?.addEventListener('change', filterSubjects);
            window.translations = {
                'main.one': @json(__('main.one')),
                'main.two': @json(__('main.two')),
            };

            function filterSubjects() {
                const majorId = specializationSelect?.value;
                const levelId = levelSelect?.value;

                subjectDiv.classList.add('d-none');
                blockButton?.classList.add('d-none');
                subjectSelect.innerHTML = '<option value="">{{ ucwords(__("main.select_course")) }}</option>';

                if (!majorId || !levelId) return;

                const filtered = allSubjects.filter(subject =>
                    subject.major_id == majorId && subject.level_id == levelId
                );

                if (filtered.length > 0) {
                    subjectDiv.classList.remove('d-none');
                    filtered.forEach(subject => {
                        const option = document.createElement('option');
                        let subjectName = subject.term.toLowerCase();
                        subjectName = window.translations['main.' + subjectName] || subjectName;

                        option.value = subject.id;
                        option.textContent = subject.name + ' - {{__('main.term')}} ' + subjectName;
                        subjectSelect.appendChild(option);
                    });

                    if (savedSettings.subject) {
                        subjectSelect.value = savedSettings.subject;
                        blockButton?.classList.remove('d-none');
                    }
                }
            }

            blockSubjectCheck?.addEventListener('change', function () {
                if (this.checked) {
                    dropdownContainer.classList.remove('d-none');
                } else {
                    dropdownContainer.classList.add('d-none');
                    specializationSelect.value = "";
                    levelSelect.innerHTML = '<option value="">{{ ucwords(__("main.select_level")) }}</option>';
                    subjectDiv.classList.add('d-none');
                    blockButton?.classList.add('d-none');
                }
            });

            // --- Block Button Action ---
            blockButton?.addEventListener('click', function () {
                Swal.fire({
                    text: '{{ ucwords(__('main.course_will_be_blocked_on_save')) }}',
                    icon: 'success'
                }).then(() => {
                    dropdownContainer.classList.add('d-none');
                    blockSubjectCheck.checked = false;
                    specializationSelect.value = "";
                    levelSelect.innerHTML = '<option value="">{{ ucwords(__("main.select_level")) }}</option>';
                    subjectDiv.classList.add('d-none');
                    blockButton?.classList.add('d-none');
                });
            });

            // --- Initialize on Page Load ---
            window.addEventListener('load', () => {
                if (savedSettings.major) {
                    const event = new Event('change');
                    specializationSelect.dispatchEvent(event);
                }
            });





            const thresholdSlider = document.getElementById('attendanceThreshold');
            const thresholdValue = document.getElementById('thresholdValue');

            if (thresholdSlider && thresholdValue) {
                thresholdSlider.addEventListener('input', function() {
                    thresholdValue.textContent = this.value + '%';
                });
            }

            const themeToggle = document.getElementById('themeToggle');
            const themeSelect = document.getElementById('theme');

            if (themeToggle) {
                themeToggle.addEventListener('click', function() {
                    document.body.classList.toggle('dark-mode');

                    if (document.body.classList.contains('dark-mode')) {
                        themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
                        if (themeSelect) themeSelect.value = 'dark';
                    } else {
                        themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
                        if (themeSelect) themeSelect.value = 'light';
                    }
                });
            }

            if (themeSelect) {
                themeSelect.addEventListener('change', function() {
                    if (this.value === 'dark') {
                        document.body.classList.add('dark-mode');
                        if (themeToggle) themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
                    } else {
                        document.body.classList.remove('dark-mode');
                        if (themeToggle) themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
                    }
                });
            }

            document.getElementById('resetButton').addEventListener('click', function() {
                Swal.fire({
                    title: '{{ucwords(__('main.are_you_sure'))}}',
                    text: '{{ucwords(__('main.all_settings_will_be_restored_to_default_values'))}}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '{{ucwords(__('main.yes_restore'))}}',
                    cancelButtonText: '{{ucwords(__('main.cancel'))}}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("{{ route('settings.reset') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('{{ucfirst(__('main.done'))}}', '{{ucwords(__('main.default_settings_restored_successfully'))}}', 'success')
                                        .then(() => {
                                            location.reload();
                                        });
                                } else {
                                    Swal.fire('{{ucfirst(__('main.error'))}}', '{{ucwords(__('main.error_while_attempting_to_restore_settings'))}}', 'error');
                                }
                            });
                    }
                });
            });
        });
    </script>
@endsection
