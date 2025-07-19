<?php

use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LectureController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UpdateDeviceMacAddressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/forgot-password', [AuthController::class, 'sendForgotPasswordOtp']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);


Route::apiResource('colleges','App\Http\Controllers\Api\CollegeController')->only('index', 'show');
Route::apiResource('majors','App\Http\Controllers\Api\MajorController')->only('index', 'show');


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [AuthController::class, 'user']);

    Route::put('/update-password', [AuthController::class, 'updatePassword']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::put('/update-mac-address', UpdateDeviceMacAddressController::class);

    Route::apiResource('courses','App\Http\Controllers\Api\CourseController')->only('index', 'show');


    Route::prefix('/attendances')->group(function (){
        Route::get('/', [AttendanceController::class, 'index']);
        Route::get('/absent', [AttendanceController::class, 'absent']);
        Route::get('/present', [AttendanceController::class, 'present']);
        Route::get('/late', [AttendanceController::class, 'late']);
        Route::get('/transformed', [AttendanceController::class, 'transformed']);
        Route::get('/approved', [AttendanceController::class, 'approved']);
        Route::get('/rejected', [AttendanceController::class, 'rejected']);
        Route::post('/{attendance}', [AttendanceController::class, 'uploadAbsentAttendanceAttachment']);
    });

//    Route::post('/lectures/{lecture}/attendance/scan', [LectureController::class, 'processScan'])->name('attendance.scan')->middleware('signed');
    Route::post('/lectures/{lecture}/attendance/scan', [LectureController::class, 'processScan'])->name('attendance.scan');

    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::put('/', [NotificationController::class, 'update']);
        Route::delete('/', [NotificationController::class, 'delete']);
    });

});
