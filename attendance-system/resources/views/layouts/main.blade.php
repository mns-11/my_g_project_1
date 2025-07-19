<!DOCTYPE html>
@php
    $dir = \LaravelLocalization::getCurrentLocaleDirection();
    $currentLocale = LaravelLocalization::getCurrentLocale();
    $settings = \App\Models\Setting::getAllSettings();
//    if($settings = \App\Models\Setting::getAllSettings()) {
//        $currentLocale = $settings['language'];
//        if($currentLocale == 'ar') {
//            $dir = 'rtl';
//        }else{
//            $dir = 'ltr';
//        }
//    }

@endphp
<html lang="{{$currentLocale}}" dir="{{ $dir }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token()}}">


  <title>@yield('title')</title>


  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
  <!-- Animate.css -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Bootstrap JS & SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- FontAwesome للأيقونات -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    body {
      font-family: 'Cairo', sans-serif;
      background: linear-gradient(135deg, #F5F6FA 0%, #E0E6F0 100%);
      min-height: 100vh;
      margin: 0;
      padding: 0;
      color: #333;
    }

    /* Card */
    .card {
      border: none;
      border-radius: 30px;
      box-shadow: 0 6px 20px rgba(237, 171, 72, 0.72);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      margin-bottom: 20px;
      background: linear-gradient(45deg, #228B22, #FFA500);
      color: #fff;
      padding: 20px;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    /* Table */
    .table {
      background-color: #FFA500;
      border-radius: 10px;
      overflow: hidden;
      /*margin-right: -20px;*/
    }
    .table th, .table td {
      padding: 15px;
      text-align: center;
    }
    /* Buttons */
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
    .btn-success {
      background-color: #28a745;
      border: none;
      border-radius: 25px;
      transition: background 0.3s;
    }
    .btn-success:hover {
      background-color: #218838;
    }
    .btn-danger {
      background-color: #dc3545;
      border: none;
      border-radius: 25px;
      transition: background 0.3s;
    }
    .btn-danger:hover {
      background-color: #c82333;
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

    /* Floating Action Button */
    .floating-btn-container {
        position: fixed;
        bottom: 30px;
        left: 30px;
        z-index: 1000;
    }

    .floating-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(45deg, #FFA500, #228B22);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        transition: all 0.3s;
    }

    .floating-btn:hover {
        transform: scale(1.1) rotate(15deg);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }

    .logout-form {
        display: none;
    }


  </style>


</head>

<body class="@if(str_contains(request()->path(), 'admin') and $settings['theme'] == 'dark') {{ 'dark-mode'}} @endif">
    @hasrole('admin')
         @include('layouts.sidebar')
    @endhasrole

    @hasanyrole(['coordinator', 'teacher', 'chief'])
        @include('layouts.topbar')
    @endhasanyrole

    <div class="floating-btn-container">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
        </form>


        <!-- Floating Logout Button -->
        <div class="floating-btn-container">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
            </form>
            <button type="button" id="logoutBtn" class="floating-btn">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </button>
        </div>
    </div>
    <div>@yield('content')</div>

    @if(session('message'))
        <script>
            Toastify({
                text: "{{ session('message') }}",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#28a745",
            }).showToast();
        </script>
    @endif
 <!-- Bootstrap JS & SweetAlert2 -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Theme Toggle Functionality
        const themeToggleBtn = document.getElementById('themeToggleBtn');
        const themeIcon = document.getElementById('themeIcon');
        const logoutForm = document.getElementById('logout-form');

        // Check saved theme
        const currentTheme = localStorage.getItem('theme') ||
            (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        document.documentElement.classList.toggle('dark-theme', currentTheme === 'dark');

        // Set initial icon
        // if (currentTheme === 'dark') {
        //     themeIcon.classList.remove('fa-moon');
        //     themeIcon.classList.add('fa-sun');
        // } else {
        //     themeIcon.classList.remove('fa-sun');
        //     themeIcon.classList.add('fa-moon');
        // }

        // themeToggleBtn.addEventListener('click', function () {
        //     const isDark = document.documentElement.classList.toggle('dark-theme');
        //     localStorage.setItem('theme', isDark ? 'dark' : 'light');
        //
        //     // Change icon based on theme
        //     if (isDark) {
        //         themeIcon.classList.remove('fa-moon');
        //         themeIcon.classList.add('fa-sun');
        //     } else {
        //         themeIcon.classList.remove('fa-sun');
        //         themeIcon.classList.add('fa-moon');
        //     }
        // });

        // Logout functionality
        document.getElementById('logoutBtn').addEventListener('click', function () {
            {{--Swal.fire({--}}
            {{--    title: '{{ __('main.are_you_sure_you_want_to_logout') }}',--}}
            {{--    icon: 'warning',--}}
            {{--    showCancelButton: true,--}}
            {{--    confirmButtonColor: '#3085d6',--}}
            {{--    cancelButtonColor: '#d33',--}}
            {{--    confirmButtonText: '{{ __('main.yes_logout') }}',--}}
            {{--    cancelButtonText: '{{ __('main.cancel') }}'--}}
            {{--}).then((result) => {--}}
            {{--    if (result.isConfirmed) {--}}
            {{--        document.getElementById('logout-form').submit();--}}
            {{--    }--}}
            {{--});--}}

            if (confirm('{{__('main.are_you_sure_you_want_to_logout')}}')) {
                logoutForm.submit();
            }

        });
    </script>


    {{--<script>--}}
    {{--    const themeToggle = document.getElementById('themeToggle');--}}
    {{--    const themeSelect = document.getElementById('theme');--}}

    {{--    if (themeToggle) {--}}
    {{--        themeToggle.addEventListener('click', function() {--}}
    {{--            document.body.classList.toggle('dark-mode');--}}

    {{--            if (document.body.classList.contains('dark-mode')) {--}}
    {{--                themeToggle.innerHTML = '<i class="fas fa-sun"></i>';--}}
    {{--                if (themeSelect) themeSelect.value = 'dark';--}}
    {{--            } else {--}}
    {{--                themeToggle.innerHTML = '<i class="fas fa-moon"></i>';--}}
    {{--                if (themeSelect) themeSelect.value = 'light';--}}
    {{--            }--}}
    {{--        });--}}
    {{--    }--}}

    {{--    if (themeSelect) {--}}
    {{--        themeSelect.addEventListener('change', function() {--}}
    {{--            if (this.value === 'dark') {--}}
    {{--                document.body.classList.add('dark-mode');--}}
    {{--                if (themeToggle) themeToggle.innerHTML = '<i class="fas fa-sun"></i>';--}}
    {{--            } else {--}}
    {{--                document.body.classList.remove('dark-mode');--}}
    {{--                if (themeToggle) themeToggle.innerHTML = '<i class="fas fa-moon"></i>';--}}
    {{--            }--}}
    {{--        });--}}
    {{--    }--}}
    {{--</script>--}}
    <!-- Floating Action Button with Theme Toggle -->


</body>
</html>
