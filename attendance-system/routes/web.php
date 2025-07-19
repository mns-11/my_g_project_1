<?php

use App\Http\Controllers\RedirectionDashboardController;
use App\Http\Controllers\Web\AcademicYearCollegeCourseHallMajorUserController;
use App\Http\Controllers\Web\AcademicYearController;
use App\Http\Controllers\Web\AttendanceController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\ChiefController;
use App\Http\Controllers\Web\CollegeController;
use App\Http\Controllers\Web\CourseController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\EmployeeController;
use App\Http\Controllers\Web\LectureController;
use App\Http\Controllers\Web\AttendanceReportController;
use App\Http\Controllers\Web\MajorController;
use App\Http\Controllers\Web\SettingsController;
use App\Http\Controllers\Web\StudentCoordinatorController;
use App\Http\Controllers\Web\StudentController;
use App\Http\Controllers\Web\TeacherController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {


    Route::view('/login', 'auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendPasswordLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');

    Route::middleware('auth')->group(function (){

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/', RedirectionDashboardController::class)->name('redirection.dashboard');

        Route::prefix('admin')->middleware(['role:admin'])->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

            // Settings routes
            Route::prefix('settings')->group(function () {
                Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
                Route::put('/', [SettingsController::class, 'update'])->name('settings.update');
                Route::post('/reset', [SettingsController::class, 'reset'])->name('settings.reset');
            });


            // Employee routes
            Route::get('employees', [EmployeeController::class, 'index'])->name('employees.index');
            Route::get('employees/create', [EmployeeController::class, 'create'])->name('employees.create');
            Route::post('employees', [EmployeeController::class, 'store'])->name('employees.store');
            Route::get('employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
            Route::put('employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
            Route::delete('employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

            // College routes
            Route::resource('colleges', \App\Http\Controllers\Web\CollegeController::class)->except('show');

            // Major routes
            Route::resource('majors', \App\Http\Controllers\Web\MajorController::class)->except('show');

            // Coordinators routes
//            Route::get('coordinators', [StudentCoordinatorController::class, 'index'])->name('coordinators.index');
//            Route::get('coordinators/create', [StudentCoordinatorController::class, 'create'])->name('coordinators.create');
//            Route::post('coordinators', [StudentCoordinatorController::class, 'store'])->name('coordinators.store');
//            Route::get('coordinators/{id}/edit', [StudentCoordinatorController::class, 'edit'])->name('coordinators.edit');
//            Route::put('coordinators/{id}', [StudentCoordinatorController::class, 'update'])->name('coordinators.update');
//            Route::delete('coordinators/{id}', [StudentCoordinatorController::class, 'destroy'])->name('coordinators.destroy');

            // Chief routes
            Route::get('chiefs', [ChiefController::class, 'index'])->name('chiefs.index');
            Route::get('chiefs/create', [ChiefController::class, 'create'])->name('chiefs.create');
            Route::post('chiefs', [ChiefController::class, 'store'])->name('chiefs.store');
            Route::get('chiefs/{id}/edit', [ChiefController::class, 'edit'])->name('chiefs.edit');
            Route::put('chiefs/{id}', [ChiefController::class, 'update'])->name('chiefs.update');
            Route::delete('chiefs/{id}', [ChiefController::class, 'destroy'])->name('chiefs.destroy');

            // Teacher routes
            Route::get('teachers', [TeacherController::class, 'index'])->name('teachers.index');
            Route::get('teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
            Route::post('teachers', [TeacherController::class, 'store'])->name('teachers.store');
            Route::get('teachers/{id}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
            Route::put('teachers/{id}', [TeacherController::class, 'update'])->name('teachers.update');
            Route::delete('teachers/{id}', [TeacherController::class, 'destroy'])->name('teachers.destroy');


            // Student routes
            Route::get('students', [StudentController::class, 'index'])->name('students.index');
            Route::get('students/create', [StudentController::class, 'create'])->name('students.create');
            Route::post('students', [StudentController::class, 'store'])->name('students.store');
            Route::get('students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
            Route::put('students/{id}', [StudentController::class, 'update'])->name('students.update');
            Route::delete('students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
            Route::post('/students/transfer', [StudentController::class, 'transfer'])->name('students.transfer');

            // Course routes
            Route::resource('courses', \App\Http\Controllers\Web\CourseController::class)->except('show');

            // Attendance routes
            Route::resource('attendances', \App\Http\Controllers\Web\AttendanceController::class)->except('show');

            // Report routes
            Route::get('reports', [AttendanceReportController::class, 'index'])->name('reports.index');

            Route::resource('halls', \App\Http\Controllers\Web\HallController::class)->except('show');

            // AcademicYear routes
            Route::get('academic-years/create', [AcademicYearController::class, 'create'])->name('academic-years.create');
            Route::post('academic-years', [AcademicYearController::class, 'store'])->name('academic-years.store');

            // AcademicYearCollegeCourseHallMajorUser routes
            Route::get('acchmus', [AcademicYearCollegeCourseHallMajorUserController::class, 'index'])->name('acchmus.index');
            Route::get('acchmus/create', [AcademicYearCollegeCourseHallMajorUserController::class, 'create'])->name('acchmus.create');
            Route::post('acchmus', [AcademicYearCollegeCourseHallMajorUserController::class, 'store'])->name('acchmus.store');
            Route::get('acchmus/{id}/edit', [AcademicYearCollegeCourseHallMajorUserController::class, 'edit'])->name('acchmus.edit');
            Route::put('acchmus/{id}', [AcademicYearCollegeCourseHallMajorUserController::class, 'update'])->name('acchmus.update');
            Route::delete('acchmus/{id}', [AcademicYearCollegeCourseHallMajorUserController::class, 'destroy'])->name('acchmus.destroy');
            Route::get('acchmus/inquiry', [AcademicYearCollegeCourseHallMajorUserController::class, 'inquiry'])->name('acchmus.inquiry');
            Route::get('/courses/query', [AcademicYearCollegeCourseHallMajorUserController::class, 'showQueryForm'])
                ->name('courses.query');


            Route::prefix('ajax')->group(function() {
                Route::get('/departments', [AcademicYearCollegeCourseHallMajorUserController::class, 'getDepartments'])
                    ->name('ajax.departments');

                Route::get('/levels', [AcademicYearCollegeCourseHallMajorUserController::class, 'getLevels'])
                    ->name('ajax.levels');

                Route::get('/courses', [AcademicYearCollegeCourseHallMajorUserController::class, 'getCourses'])
                    ->name('ajax.courses');

                Route::get('/teachers', [AcademicYearCollegeCourseHallMajorUserController::class, 'getTeachers'])
                    ->name('ajax.teachers');
            });

        });


        Route::prefix('teacher')->middleware(['role:teacher'])->group(function () {
            Route::get('/', [LectureController::class, 'index'])->name('teacher.lectures.index');
            Route::get('lectures/create', [LectureController::class, 'create'])->name('lectures.create');
            Route::get('lectures/{lecture}/edit', [LectureController::class, 'edit'])->name('lectures.edit');
            Route::post('lectures', [LectureController::class, 'store'])->name('lectures.store');
            Route::put('lectures/{lecture}', [LectureController::class, 'update'])->name('lectures.update');
            Route::post('lectures/{lecture}/generate-qr-code', [LectureController::class, 'generateQRCode'])->name('lectures.generate.qr.code');
            Route::get('lectures/{lecture}/students', [LectureController::class, 'showStudents'])->name('lectures.students.view');
            Route::get('attendances/manual',[AttendanceController::class,'manualAttendancePage'])->name('manual.attendance');
            Route::post('attendances/manual',[AttendanceController::class,'manualAttendance'])->name('manual.attendance.post');
            Route::get('student', [StudentController::class, 'getStudent'])->name('students.get-student');
            Route::post('/attendances/manual',[AttendanceController::class, 'manualAttendance'])->name('manual.attendance.post');
//            Route::post('lectures/{lecture}/attendance/scan', [LectureController::class, 'processScan'])->name('attendance.scan')->middleware('signed');
        });


        Route::prefix('coordinator')->middleware(['role:coordinator'])->group(function () {
            Route::get('attendances/excuses',[AttendanceController::class,'excuses'])->name('attendances.excuses');
            Route::put('attendances/{attendance}/',[AttendanceController::class,'update'])->name('attendances.excuses.update');
            Route::get('/attendance-reports', [AttendanceReportController::class, 'create'])->name('attendance.reports');
            Route::post('/generate-report', [AttendanceReportController::class, 'generateReport']);
            Route::post('/send-report', [AttendanceReportController::class, 'sendReport']);
            Route::get('/sent-reports', [AttendanceReportController::class, 'getSentReports']);
            Route::get('/latest-sent-report', [AttendanceReportController::class, 'getLatestSentReport']);
            Route::post('/search-students', [AttendanceReportController::class, 'searchStudents']);
            Route::get('students', [StudentController::class, 'index'])->name('coordinator.students.index');
            Route::get('students/create', [StudentController::class, 'create'])->name('coordinator.students.create');
            Route::post('students', [StudentController::class, 'store'])->name('coordinator.students.store');
            Route::get('students/{id}/edit', [StudentController::class, 'edit'])->name('coordinator.students.edit');
            Route::put('students/{id}', [StudentController::class, 'update'])->name('coordinator.students.update');
            Route::delete('students/{id}', [StudentController::class, 'destroy'])->name('coordinator.students.destroy');
        });

        Route::prefix('chief')->middleware(['role:chief'])->group(function () {
            Route::get('attendances/transferred',[AttendanceController::class,'excuses'])->name('attendances.transferred');
            Route::put('attendances/{attendance}/',[AttendanceController::class,'update'])->name('chief.attendances.excuses.update');
            Route::get('/reports/transferred', [AttendanceReportController::class, 'getSentReports'])->name('reports.transferred');

            Route::get('teachers', [TeacherController::class, 'index'])->name('chief.teachers.index');
            Route::get('teachers/create', [TeacherController::class, 'create'])->name('chief.teachers.create');
            Route::post('teachers', [TeacherController::class, 'store'])->name('chief.teachers.store');
            Route::get('teachers/{id}/edit', [TeacherController::class, 'edit'])->name('chief.teachers.edit');
            Route::put('teachers/{id}', [TeacherController::class, 'update'])->name('chief.teachers.update');
            Route::delete('teachers/{id}', [TeacherController::class, 'destroy'])->name('chief.teachers.destroy');

        });

        Route::get('/reports/{id}/pdf', [AttendanceReportController::class, 'downloadPdf'])->middleware(['role:chief|coordinator'])->name('download.pdf');

    });

});
