<style>
    /* تنسيق عام */
    body {
        font-family: 'Cairo', sans-serif;
        background: linear-gradient(135deg, #F5F6FA 0%, #E0E6F0 100%);
        min-height: 100vh;
        margin: 0;
        padding: 0;
    }
    .navbar {
        background-color: #4A90E2;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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
    }
    .btn-danger {
        background-color: #E74C3C;
        border: none;
        border-radius: 25px;
    }
    .btn-outline-light:hover{
        background-color: #228B22;
    }
    .form-control, .form-select {
        border-radius: 10px;
        box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
    }
    .modal-content {
        border-radius: 15px;
        overflow: hidden;
    }
    .sidebar {
        background-color: #FFFFFF;
        height: 100vh;
        position: fixed;
        top: 0;
        right: 0;
        width: 250px;
        padding: 20px;
        box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
    }
    /* المحتوى الرئيسي مع ضبط الهوامش */
    .main-content {
        margin-right: 50px; /* مساحة الشريط الجانبي + هامش إضافي */
        padding-top: 10px;
    }
    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
        }
        .main-content {
            margin-right: 0;
        }
    }
</style>

<nav class="navbar navbar-expand-lg" style="background: linear-gradient(45deg, #FFA500, #228B22);">
    <div class="container-fluid">
        <!-- شعار الموقع -->
        <a class="navbar-brand d-flex align-items-center" href="https://alarabuni.edu.ye/">
            <img src="{{asset('image\University Logo white.png')}}" alt="Logo" style="height: 57px; ">
            <strong>{{__('main.attendance_registration_system')}}</strong>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- قائمة الروابط -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                @hasrole('teacher')
                    <li class="nav-item mx-2">
                        <a class="nav-link btn btn-outline-light" href="{{route('lectures.create')}}"
                           style="border-radius: 25px; padding: 10px 20px;">
                            <strong>{{__('main.creating_lectures')}}</strong>
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link btn btn-outline-light" href="{{route('teacher.lectures.index')}}"
                           style="border-radius: 25px; padding: 10px 20px;">
                            <strong>{{__('main.lectures')}}</strong>
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link btn btn-outline-light" href="{{route('manual.attendance')}}"
                           style="border-radius: 25px; padding: 10px 20px;">
                            <strong>{{__('main.manual_attendance')}}</strong>
                        </a>
                    </li>
                @endhasrole

                @hasrole('coordinator')
                    <li class="nav-item mx-2">
                        <a class="nav-link btn btn-outline-light" href="{{route('attendances.excuses')}}"
                           style="border-radius: 25px; padding: 10px 20px;">
                            <strong>{{__('main.excuses')}}</strong>
                        </a>
                    </li>

                    <li class="nav-item mx-2">
                        <a class="nav-link btn btn-outline-light" href="{{route('attendance.reports')}}"
                           style="border-radius: 25px; padding: 10px 20px;">
                            <strong>{{__('main.reports')}}</strong>
                        </a>
                    </li>


                <li class="nav-item mx-2">
                    <a class="nav-link btn btn-outline-light" href="{{route('coordinator.students.index')}}"
                       style="border-radius: 25px; padding: 10px 20px;">
                        <strong>{{__('main.student_management')}}</strong>
                    </a>
                </li>
                @endhasrole

                @hasrole('chief')
                <li class="nav-item mx-2">
                    <a class="nav-link btn btn-outline-light" href="{{route('attendances.transferred')}}"
                       style="border-radius: 25px; padding: 10px 20px;">
                        <strong>{{__('main.excuses')}}</strong>
                    </a>
                </li>

                <li class="nav-item mx-2">
                    <a class="nav-link btn btn-outline-light" href="{{route('reports.transferred')}}"
                       style="border-radius: 25px; padding: 10px 20px;">
                        <strong>{{__('main.reports')}}</strong>
                    </a>
                </li>

                <li class="nav-item mx-2">
                    <a class="nav-link btn btn-outline-light" href="{{route('chief.teachers.index')}}"
                       style="border-radius: 25px; padding: 10px 20px;">
                        <strong>{{__('main.doctor_management')}}</strong>
                    </a>
                </li>
                @endhasrole

                <li class="nav-item mx-2 dropdown nav-icon-hover-bg rounded-circle">
                    @php
                        $currentLocale = LaravelLocalization::getCurrentLocale();
                    @endphp
                    <a class="nav-link dropdown-toggle btn btn-outline" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 25px; padding: 10px 20px;">
                        <b>{{ ucfirst(__('main.language')) }}</b>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="languageDropdown">
                        <div class="message-body">
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <a rel="alternate" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                                   hreflang="{{ $localeCode }}"
                                   class="d-flex align-items-center gap-3 py-2 px-4 dropdown-item {{ $localeCode == $currentLocale ? 'active' : '' }}">
                                    <p class="mb-0">{{ $properties['native'] }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </li>

{{--                <li class="nav-item mx-2">--}}
{{--                    <a class="nav-link btn btn-outline-light" href="#"--}}
{{--                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"--}}
{{--                       style="border-radius: 25px; padding: 10px 20px;">--}}
{{--                        <strong>{{ __('main.logout') }}</strong>--}}
{{--                    </a>--}}
{{--                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">--}}
{{--                        @csrf--}}
{{--                    </form>--}}
{{--                </li>--}}
            </ul>
        </div>
    </div>
</nav>
