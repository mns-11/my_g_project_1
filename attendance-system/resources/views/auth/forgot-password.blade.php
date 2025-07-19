<!DOCTYPE html>
@php
    $dir = \LaravelLocalization::getCurrentLocaleDirection();
    $currentLocale = LaravelLocalization::getCurrentLocale();
@endphp
<html lang="{{$currentLocale}}" dir="{{ $dir }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ucwords(__('main.forgot_password_word'))}}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Cairo -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- SweetAlert2 for notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(45deg, #FFA500, #67bc67, #f7c66c, #228B22);
            background-size: 400% 400%;
            animation: gradientBG 10s ease infinite;
            color: #67bc67;
            direction: rtl;
            overflow-x: hidden;
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        /* Container Card */
        .forgot-container {
            position: relative;
            width: 400px;
            margin: 100px auto;
            padding: 40px 30px;
            background-color: rgba(255, 255, 255, 0.482);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            animation: fadeInUp 1.5s ease-out;
            z-index: 1;
            text-align: center;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Logo */
        .logo-top {
            text-align: center;
            margin-bottom: 0.5px;
        }
        .logo-top img {
            max-width: 200px;
        }
        /* Heading */
        h2 {
            margin-bottom: 30px;
            font-weight: 700;
            color: #228B22;
        }
        /* Input Field with Icon */
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
            box-shadow: 0 0 10px rgba(34, 139, 34, 0.3);
        }
        /* Button Styling */
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
        /* Back to Login Link */
        .back-to-login {
            margin-top: 15px;
            font-size: 14px;
        }
        .back-to-login a {
            color: #228B22;
            text-decoration: none;
            transition: text-decoration 0.3s;
        }
        .back-to-login a:hover {
            text-decoration: underline;
        }
        /* Instruction Text */
        .text-muted {
            font-size: 14px;
            margin-bottom: 20px;
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
<div class="forgot-container">
    <div class="logo-top">
        <img src="{{asset('image/Uni.png')}}" alt="logo">
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
    <h2>{{ucwords(__('main.forgot_password'))}}</h2>
    <p class="text-muted">{{ucwords(__('main.enter_your_email_to_receive_password_reset_link'))}}</p>
    <form id="forgotPasswordForm" action="{{route('password.email')}}" method="POST">
        @csrf
        <div class="input-box">
            <i class="fas fa-envelope"></i>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="{{ucwords(__('main.enter_your_email'))}}" required>
            @error('email', 'forgotPasswordErrors')
            <span class="validation-text text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn-custom"
{{--                onclick="sendResetLink()"--}}
        >{{ucfirst(__('main.submit'))}}</button>
    </form>

    <div class="back-to-login">
        <a href="/login">{{ucwords(__('main.back_to_login'))}}</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    window.onload = function() {
        document.getElementById('email').setAttribute('autocomplete', 'nope');
    };
</script>
{{--<script>--}}
{{--    function sendResetLink() {--}}
{{--        const email = document.getElementById('email').value;--}}
{{--        if (!email) {--}}
{{--            Swal.fire({--}}
{{--                title: '{{ucfirst(__('main.error'))}}',--}}
{{--                text: '{{ucwords(__('main.please_enter_your_email'))}}',--}}
{{--                icon: 'error'--}}
{{--            });--}}
{{--            return;--}}
{{--        }--}}
{{--        Swal.fire({--}}
{{--            title: '{{ucfirst(__('main.sent'))}}',--}}
{{--            text: '{{ucwords(__('main.password_reset_link_has_been_sent_to_your_email'))}}',--}}
{{--            icon: 'success'--}}
{{--        }).then(() => {--}}
{{--            // window.location.href = '/';--}}
{{--            document.getElementById('forgotPasswordForm').submit(); // ✅ This submits the form--}}
{{--        });--}}
{{--    }--}}
{{--</script>--}}
</body>
</html>
