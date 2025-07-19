<!DOCTYPE html>
@php
    $dir = \LaravelLocalization::getCurrentLocaleDirection();
    $currentLocale = LaravelLocalization::getCurrentLocale();
@endphp
<html lang="{{$currentLocale}}" dir="{{ $dir }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ucfirst(__('main.login'))}}</title>
    <!-- ربط Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- خط Google: Cairo -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <!-- تضمين Font Awesome للأيقونات -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <style>
        /* الإعدادات العامة */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Cairo', sans-serif;
            /* خلفية متدرجة متحركة */
            background: linear-gradient(45deg, #FFA500, #67bc67, #f7c66c, #228B22);
            background-size: 400% 400%;
            animation: gradientBG 10s ease infinite;
            color: #67bc67;
            direction: rtl; /* تغيير الاتجاه ليكون من اليمين إلى اليسار للغة العربية */
            overflow-x: hidden;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* تصميم بطاقة تسجيل الدخول */
        .login-container {
            position: relative;
            width: 400px;
            margin: 100px auto;
            padding: 40px 30px;
            background-color: rgba(255, 255, 255, 0.482);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.15);
            overflow: hidden;
            animation: fadeInUp 1.5s ease-out;
            z-index: 1;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* الشعار أعلى البطاقة */
        .logo-top {
            text-align: center;
            margin-bottom: 0.5px;
        }
        .logo-top img {
            max-width: 200px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            color: #228B22; /* أخضر الغابة */
        }
        /* حقول الإدخال مع الأيقونات */
        .input-box {
            position: relative;
            margin-bottom: 20px;
        }
        .input-box i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #FFA500;
            font-size: 18px;
        }
        .form-control {
            width: 100%;
            padding: 12px 45px 12px 12px;
            border-radius: 30px;
            background-color: rgba(255, 255, 255, 0.9);
            border: 2px solid #FFA500;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #228B22;
            box-shadow: 0 0 10px rgba(34,139,34,0.3);
        }
        /* زر تسجيل الدخول مع تأثير التحويم */
        .btn-custom {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 30px;
            background-color: #FFA500;
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #e59400;
            transform: scale(1.05);
        }
        /* رابط "نسيت كلمة المرور" */
        .forgot {
            margin-top: 10px;
            font-size: 14px;
            text-align: center;
        }
        .forgot a {
            color: #228B22;
            text-decoration: none;
            transition: text-decoration 0.3s;
        }
        .forgot a:hover {
            text-decoration: underline;
        }
        @media (max-width: 768px) {
        html[dir="rtl"] .content,
        html[dir="ltr"] .content {
            margin: 0 !important;
        }
        }
    </style>
</head>
<body>
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

<div class="login-container">
    <!-- الشعار أعلى البطاقة -->
    <div class="logo-top">
        <img src="{{asset('image/Uni.png')}}" alt="شعار الجامعة">
    </div>

{{--    <div class="dropdown mb-5 d-flex justify-content-end">--}}
{{--                                    <span class="dropdown-toggle d-flex align-items-center text-dark" type="button" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                                        <iconify-icon icon="iconoir:language" class="me-2"></iconify-icon>--}}
{{--                                        {{ LaravelLocalization::getCurrentLocaleNative() }}--}}
{{--                                    </span>--}}
{{--        <ul class="dropdown-menu">--}}
{{--            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)--}}
{{--                @if ($localeCode != LaravelLocalization::getCurrentLocale())--}}
{{--                    <li>--}}
{{--                        <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">--}}
{{--                            {{ $properties['native'] }}--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endif--}}
{{--            @endforeach--}}
{{--        </ul>--}}
{{--    </div>--}}
    <h2>{{ucfirst(__('main.login'))}}</h2>
    <form id="loginForm" action="{{route('login')}}" method="POST">
        @csrf
        <div class="input-box">
            <i class="fas fa-user"></i>
            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="{{ucfirst(__('main.email'))}}" required name="email">
            @error('email')
            <span class="validation-text text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="input-box">
            <i class="fas fa-lock"></i>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="{{ucfirst(__('main.password'))}}" required>
            @error('password')
            <span class="validation-text text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-custom">{{ucfirst(__('main.login'))}}</button>
        <div class="forgot">
            <a href="{{route('password.request')}}">{{ucfirst(__('main.forgot_password'))}}</a>
        </div>
    </form>
</div>
<script>
    window.onload = function() {
        document.getElementById('email').setAttribute('autocomplete', 'nope');
        document.getElementById('password').setAttribute('autocomplete', 'new-password');
    };
</script>
<!-- تضمين jQuery و Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
