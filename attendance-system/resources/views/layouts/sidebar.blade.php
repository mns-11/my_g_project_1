

{{--<style>--}}
{{--    .sidebar {--}}
{{--        position: fixed;--}}
{{--        top: 0;--}}
{{--        height: 100%;--}}
{{--        width: 250px;--}}
{{--        background: linear-gradient(45deg, #FFA500, #228B22);--}}
{{--        /*padding-top: 20px;*/--}}
{{--        color: white;--}}
{{--        transition: all 0.3s;--}}
{{--        box-shadow: 0 4px 14px #e0a800;--}}
{{--        z-index: 100;--}}

{{--    }--}}

{{--    html[dir="rtl"] .sidebar {--}}
{{--        right: 0;--}}
{{--    }--}}

{{--    html[dir="ltr"] .sidebar {--}}
{{--        left: 0;--}}
{{--    }--}}

{{--    html[dir="rtl"] .content {--}}
{{--        margin-right: 250px;--}}
{{--    }--}}

{{--    html[dir="ltr"] .content {--}}
{{--        margin-left: 250px;--}}
{{--    }--}}
{{--    .sidebar h3 {--}}
{{--        margin-bottom: 20px;--}}
{{--    }--}}
{{--    .sidebar a {--}}
{{--        color: white;--}}
{{--        padding: 14px 20px;--}}
{{--        text-decoration: none;--}}
{{--        display: block;--}}
{{--        font-size: 16px;--}}
{{--        transition: background 0.3s;--}}
{{--    }--}}
{{--    .sidebar a:hover {--}}
{{--        background-color: #228B22;--}}
{{--    }--}}
{{--    /* Main Content */--}}
{{--    .content {--}}
{{--        margin-right: 250px;--}}
{{--        padding: 40px;--}}
{{--        transition: margin 0.3s;--}}
{{--    }--}}
{{--    @media (max-width: 768px) {--}}
{{--        .sidebar {--}}
{{--            width: 100%;--}}
{{--            height: auto;--}}
{{--            position: relative;--}}
{{--        }--}}

{{--        html[dir="rtl"] .content,--}}
{{--        html[dir="ltr"] .content {--}}
{{--            margin: 0 !important;--}}
{{--        }--}}
{{--    }--}}
{{--        .sidebar-brand {--}}
{{--            padding: 1rem 1.5rem;--}}
{{--            display: flex;--}}
{{--            flex-direction: column;--}}
{{--            align-items: center;--}}
{{--            justify-content: center;--}}
{{--            text-align: center;--}}
{{--            border-bottom: 1px solid rgba(255, 255, 255, 0.1);--}}
{{--        }--}}

{{--        .sidebar-brand img {--}}
{{--            height: 75px;--}}
{{--            margin-bottom: 0.5rem;--}}
{{--        }--}}
{{--        --}}

{{--</style>--}}


{{--<style>--}}
{{--    .sidebar {--}}
{{--        position: fixed;--}}
{{--        top: 0;--}}
{{--        height: 100vh;--}}
{{--        width: 250px;--}}
{{--        background: linear-gradient(45deg, #FFA500, #228B22);--}}
{{--        color: white;--}}
{{--        transition: all 0.3s;--}}
{{--        box-shadow: 0 4px 14px #e0a800;--}}
{{--        z-index: 1000;--}}
{{--        overflow-y: auto;--}}
{{--    }--}}

{{--    html[dir="rtl"] .sidebar {--}}
{{--        right: 0;--}}
{{--    }--}}

{{--    html[dir="ltr"] .sidebar {--}}
{{--        left: 0;--}}
{{--    }--}}

{{--    .sidebar .nav-link {--}}
{{--        color: white;--}}
{{--        padding: 12px 20px;--}}
{{--        font-size: 16px;--}}
{{--        transition: background 0.3s;--}}
{{--        border-radius: 0;--}}
{{--    }--}}

{{--    .sidebar .nav-link:hover,--}}
{{--    .sidebar .nav-link.active {--}}
{{--        background-color: rgba(255, 255, 255, 0.1);--}}
{{--    }--}}

{{--    .sidebar-brand {--}}
{{--        padding: 1rem 1.5rem;--}}
{{--        display: flex;--}}
{{--        flex-direction: column;--}}
{{--        align-items: center;--}}
{{--        justify-content: center;--}}
{{--        text-align: center;--}}
{{--        border-bottom: 1px solid rgba(255, 255, 255, 0.1);--}}
{{--    }--}}

{{--    .sidebar-brand img {--}}
{{--        height: 75px;--}}
{{--        margin-bottom: 0.5rem;--}}
{{--    }--}}

{{--    .main-content {--}}
{{--        transition: margin 0.3s;--}}
{{--    }--}}

{{--    html[dir="rtl"] .main-content {--}}
{{--        margin-right: 250px;--}}
{{--    }--}}

{{--    html[dir="ltr"] .main-content {--}}
{{--        margin-left: 250px;--}}
{{--    }--}}

{{--    /* Mobile styles */--}}
{{--    @media (max-width: 768px) {--}}
{{--        .sidebar {--}}
{{--            transform: translateX(-100%);--}}
{{--            width: 280px;--}}
{{--        }--}}

{{--        html[dir="rtl"] .sidebar {--}}
{{--            transform: translateX(100%);--}}
{{--        }--}}

{{--        .sidebar.active {--}}
{{--            transform: translateX(0);--}}
{{--        }--}}

{{--        html[dir="rtl"] .main-content,--}}
{{--        html[dir="ltr"] .main-content {--}}
{{--            margin: 0 !important;--}}
{{--        }--}}

{{--        .overlay {--}}
{{--            display: none;--}}
{{--            position: fixed;--}}
{{--            top: 0;--}}
{{--            left: 0;--}}
{{--            right: 0;--}}
{{--            bottom: 0;--}}
{{--            background-color: rgba(0, 0, 0, 0.5);--}}
{{--            z-index: 999;--}}
{{--        }--}}

{{--        .overlay.active {--}}
{{--            display: block;--}}
{{--        }--}}
{{--    }--}}

{{--    /* Toggle button styles */--}}
{{--    .sidebar-toggle {--}}
{{--        display: none;--}}
{{--        position: fixed;--}}
{{--        top: 10px;--}}
{{--        left: 10px;--}}
{{--        z-index: 1001;--}}
{{--        background: linear-gradient(45deg, #FFA500, #228B22);--}}
{{--        border: none;--}}
{{--        color: white;--}}
{{--        padding: 10px 15px;--}}
{{--        border-radius: 4px;--}}
{{--        cursor: pointer;--}}
{{--    }--}}

{{--    html[dir="rtl"] .sidebar-toggle {--}}
{{--        left: auto;--}}
{{--        right: 10px;--}}
{{--    }--}}

{{--    @media (max-width: 768px) {--}}
{{--        .sidebar-toggle {--}}
{{--            display: block;--}}
{{--        }--}}
{{--    }--}}

{{--    .main-content {--}}
{{--        transition: margin 0.3s;--}}
{{--        position: relative;--}}
{{--        z-index: 1; /* Add this line */--}}
{{--        background: #fff; /* Ensure background covers behind content */--}}
{{--    }--}}

{{--    .card {--}}
{{--        position: relative;--}}
{{--        z-index: auto; /* Reset z-index for cards */--}}
{{--        margin-bottom: 20px; /* Add spacing between cards */--}}
{{--    }--}}
{{--</style>--}}

<style>
.sidebar {
position: fixed;
top: 0;
height: 100vh;
width: 250px;
background: linear-gradient(45deg, #FFA500, #228B22);
color: white;
transition: all 0.3s;
box-shadow: 0 4px 14px #e0a800;
z-index: 100;
overflow-y: auto;
}

html[dir="rtl"] .sidebar {
right: 0;
}

html[dir="ltr"] .sidebar {
left: 0;
}

html[dir="rtl"] .content {
margin-right: 250px;
}

html[dir="ltr"] .content {
margin-left: 250px;
}

.sidebar h4 {
padding: 20px;
text-align: center;
font-size: 1.2rem;
}

.sidebar a {
color: white;
padding: 14px 20px;
text-decoration: none;
display: block;
font-size: 16px;
transition: background 0.3s;
}

.sidebar a:hover {
background-color: rgba(34, 139, 34, 0.3);
}

/* Responsive adjustments */
@media (max-width: 768px) {
.sidebar {
transform: translateX(-100%);
transition: transform 0.3s ease;
z-index: 1050;
}

.sidebar.active {
transform: translateX(0);
}

.content {
margin-left: 0 !important;
}

.mobile-toggle {
display: block;
position: fixed;
top: 15px;
left: 20px;
z-index: 1051;
cursor: pointer;
background: #FFA500;
border: none;
padding: 8px 12px;
border-radius: 4px;
color: white;
}
}
</style>

<!-- Toggle Button for Mobile -->
<button class="btn btn-warning d-lg-none mobile-toggle" type="button" onclick="toggleSidebar()">
    ☰ Menu
</button>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <h4 class="mb-4 d-flex align-items-center justify-content-center" style="flex-direction: column;">
        <div>
            <img src="{{ asset('image/University Logo white.png') }}" alt="Control Icon" style="height: 75px;">
        </div>
        <span>{{ ucwords(__('main.control_panel')) }}</span>
    </h4>

    <a href="{{ route('admin.dashboard') }}"><b >{{ ucfirst(__('main.general')) }}</b></a>
    <a href="{{ route('employees.index') }}"><b >{{ ucfirst(__('main.employee_management')) }}</b></a>
    <a href="{{ route('colleges.index') }}"><b >{{ ucfirst(__('main.college_management')) }}</b></a>
    <a href="{{ route('majors.index') }}"><b >{{ ucfirst(__('main.major_management')) }}</b></a>
    <a href="{{ route('chiefs.index') }}"><b >{{ ucfirst(__('main.majors_chiefs_management')) }}</b></a>
    <a href="{{ route('teachers.index') }}"><b >{{ ucfirst(__('main.doctor_management')) }}</b></a>
    <a href="{{ route('acchmus.inquiry') }}"><b >{{ ucfirst(__('main.course_management_inquiry')) }}</b></a>
    <a href="{{ route('courses.index') }}"><b >{{ ucwords(__('main.course_management')) }}</b></a>
    <a href="{{ route('acchmus.index') }}"><b >{{ ucwords(__('main.academic_years_and_courses_management')) }}</b></a>
    <a href="{{ route('students.index') }}"><b >{{ ucwords(__('main.student_management')) }}</b></a>
    <a href="{{ route('halls.index') }}"><b >{{ ucwords(__('main.hall_management')) }}</b></a>
    <a href="{{ route('attendances.index') }}"><b >{{ ucwords(__('main.attendance_management')) }}</b></a>
    <a href="{{ route('reports.index') }}"><b >{{ ucwords(__('main.reports')) }}</b></a>
    <a href="{{ route('settings.index') }}"><b >{{ ucwords(__('main.settings')) }}</b></a>
</div>

<script>
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("active");
    }

    // Optional: Close sidebar when clicking outside
    document.addEventListener("click", function (event) {
        const sidebar = document.getElementById("sidebar");
        const toggleBtn = document.querySelector(".mobile-toggle");

        if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
            sidebar.classList.remove("active");
        }
    });
</script>

{{--<button class="sidebar-toggle" id="sidebarToggle">--}}
{{--    <i class="bi bi-list"></i> Menu--}}
{{--</button>--}}

{{--<!-- Overlay for mobile (click to close sidebar) -->--}}
{{--<div class="overlay" id="overlay"></div>--}}

{{--<!-- Sidebar -->--}}
{{--<div class="sidebar" id="sidebar">--}}
{{--    <div class="sidebar-brand">--}}
{{--        <img src="{{asset('image/University Logo white.png')}}" alt="University Logo">--}}
{{--        <h4 class="mb-0 mt-2">{{ucwords(__('main.control_panel'))}}</h4>--}}
{{--    </div>--}}

{{--    <nav class="nav flex-column">--}}
{{--        <a class="nav-link" href="{{route('admin.dashboard')}}">--}}
{{--            <b >{{ucfirst(__('main.general'))}}</b>--}}
{{--        </a>--}}
{{--        <a class="nav-link" href="{{route('employees.index')}}">--}}
{{--            <b >{{ucfirst(__('main.employee_management'))}}</b>--}}
{{--        </a>--}}
{{--        <a class="nav-link" href="{{route('colleges.index')}}">--}}
{{--            <b >{{ucfirst(__('main.college_management'))}}</b>--}}
{{--        </a>--}}
{{--        <a class="nav-link" href="{{route('majors.index')}}">--}}
{{--            <b >{{ucfirst(__('main.major_management'))}}</b>--}}
{{--        </a>--}}
{{--        <a class="nav-link" href="{{route('chiefs.index')}}">--}}
{{--            <b >{{ucfirst(__('main.majors_chiefs_management'))}}</b>--}}
{{--        </a>--}}
{{--        <a class="nav-link" href="{{route('teachers.index')}}">--}}
{{--            <b >{{ucfirst(__('main.doctor_management'))}}</b>--}}
{{--        </a>--}}
{{--        <a class="nav-link" href="{{route('acchmus.inquiry')}}">--}}
{{--            <b >{{ucfirst(__('main.course_management_inquiry'))}}</b>--}}
{{--        </a>--}}
{{--        <a class="nav-link" href="{{route('courses.index')}}">--}}
{{--            <b >{{ucwords(__('main.course_management'))}}</b>--}}
{{--        </a>--}}
{{--        <a class="nav-link" href="{{route('acchmus.index')}}">--}}
{{--            <b >{{ucwords(__('main.academic_years_and_courses_management'))}}</b>--}}
{{--        </a>--}}
{{--        <a class="nav-link" href="{{route('students.index')}}">--}}
{{--            <b >{{ucwords(__('main.student_management'))}}</b>--}}
{{--        </a>--}}
{{--        <a class="nav-link" href="{{route('halls.index')}}">--}}
{{--            <b >{{ucwords(__('main.hall_management'))}}</b>--}}
{{--        </a>--}}
{{--        <a class="nav-link" href="{{route('attendances.index')}}">--}}
{{--            <b >{{ucwords(__('main.attendance_management'))}}</b>--}}
{{--        </a>--}}
{{--        <a class="nav-link" href="{{route('reports.index')}}">--}}
{{--            <b >{{ucwords(__('main.reports'))}}</b>--}}
{{--        </a>--}}
{{--        <a class="nav-link" href="{{route('settings.index')}}">--}}
{{--            <b >{{ucwords(__('main.settings'))}}</b>--}}
{{--        </a>--}}
{{--    </nav>--}}
{{--</div>--}}

{{--<div class="sidebar">--}}
{{--    <h4 class="mb-4 d-flex align-items-center justify-content-center" style="flex-direction: column;">--}}
{{--    <div>--}}
{{--        <img src="{{asset('image\University Logo white.png')}}" alt="Control Icon" style="height: 75px;">--}}
{{--    </div>--}}
{{--    <span>{{ucwords(__('main.control_panel'))}}</span>--}}
{{--    </h4>--}}
{{--        <a href="{{route('admin.dashboard')}}"> <b >{{ucfirst(__('main.general'))}}</b></a>--}}
{{--        <a href="{{route('employees.index')}}"> <b >{{ucfirst(__('main.employee_management'))}}</b></a>--}}
{{--        <a href="{{route('colleges.index')}}"> <b >{{ucfirst(__('main.college_management'))}}</b></a>--}}
{{--        <a href="{{route('majors.index')}}"> <b >{{ucfirst(__('main.major_management'))}}</b></a>--}}
{{--        <a href="{{route('chiefs.index')}}"> <b >{{ucfirst(__('main.majors_chiefs_management'))}}</b></a>--}}
{{--        <a href="{{route('coordinators.index')}}"> <b>{{ucfirst(__('main.student_coordinators_management'))}}</b></a>--}}
{{--        <a href="{{route('teachers.index')}}"> <b >{{ucfirst(__('main.doctor_management'))}}</b></a>--}}
{{--        <a href="{{route('acchmus.inquiry')}}"> <b >{{ucfirst(__('main.course_management_inquiry'))}}</b></a>--}}
{{--        <a href="{{route('courses.index')}}"><b >{{ucwords(__('main.course_management'))}}</b></a>--}}
{{--        <a href="{{route('acchmus.index')}}"><b >{{ucwords(__('main.academic_years_and_courses_management'))}}</b></a>--}}
{{--        <a href="{{route('students.index')}}"> <b >{{ucwords(__('main.student_management'))}}</b></a>--}}
{{--         <a href="{{route('halls.index')}}"> <b >{{ucwords(__('main.hall_management'))}}</b></a>--}}
{{--        <a href="{{route('attendances.index')}}"> <b >{{ucwords(__('main.attendance_management'))}}</b></a>--}}
{{--        <a href="{{route('reports.index')}}"> <b >{{ucwords(__('main.reports'))}}</b></a>--}}
{{--        <a href="{{route('settings.index')}}"> <b >{{ucwords(__('main.settings'))}}</b></a>--}}



{{--</div>--}}


{{--        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">--}}
{{--            <b>{{ucwords(__('main.logout'))}}</b>--}}
{{--        </a>--}}
{{--        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">--}}
{{--            @csrf--}}
{{--        </form>--}}

{{--    @hasrole('teacher')--}}
{{--        <a href="{{route('admin.dashboard')}}"> <b>{{ucfirst(__('main.general'))}}</b></a>--}}

{{--    @endhasrole--}}
{{--<script>--}}
{{--    document.addEventListener('DOMContentLoaded', function() {--}}
{{--        const sidebar = document.getElementById('sidebar');--}}
{{--        const sidebarToggle = document.getElementById('sidebarToggle');--}}
{{--        const overlay = document.getElementById('overlay');--}}
{{--        const mainContent = document.getElementById('mainContent');--}}

{{--        // Toggle sidebar on button click--}}
{{--        sidebarToggle.addEventListener('click', function() {--}}
{{--            sidebar.classList.toggle('active');--}}
{{--            overlay.classList.toggle('active');--}}
{{--        });--}}

{{--        // Close sidebar when clicking on overlay--}}
{{--        overlay.addEventListener('click', function() {--}}
{{--            sidebar.classList.remove('active');--}}
{{--            overlay.classList.remove('active');--}}
{{--        });--}}

{{--        // Close sidebar when clicking on a nav link (optional for mobile)--}}
{{--        const navLinks = document.querySelectorAll('.nav-link');--}}
{{--        navLinks.forEach(link => {--}}
{{--            link.addEventListener('click', function() {--}}
{{--                if (window.innerWidth <= 768) {--}}
{{--                    sidebar.classList.remove('active');--}}
{{--                    overlay.classList.remove('active');--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}

{{--        // Update sidebar and content based on RTL/LTR--}}
{{--        function updateLayoutDirection() {--}}
{{--            // This would be set by your application's language direction--}}
{{--            // For demo purposes, we'll use a query parameter or default to LTR--}}
{{--            const isRTL = document.documentElement.getAttribute('dir') === 'rtl';--}}

{{--            if (isRTL) {--}}
{{--                sidebar.style.right = '0';--}}
{{--                sidebar.style.left = 'auto';--}}
{{--                mainContent.style.marginRight = '250px';--}}
{{--                mainContent.style.marginLeft = '0';--}}
{{--                sidebarToggle.style.left = 'auto';--}}
{{--                sidebarToggle.style.right = '10px';--}}
{{--            } else {--}}
{{--                sidebar.style.left = '0';--}}
{{--                sidebar.style.right = 'auto';--}}
{{--                mainContent.style.marginLeft = '250px';--}}
{{--                mainContent.style.marginRight = '0';--}}
{{--                sidebarToggle.style.right = 'auto';--}}
{{--                sidebarToggle.style.left = '10px';--}}
{{--            }--}}
{{--        }--}}

{{--        // Initialize layout direction--}}
{{--        updateLayoutDirection();--}}
{{--    });--}}
{{--</script>--}}
