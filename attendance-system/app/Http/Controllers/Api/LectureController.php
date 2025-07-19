<?php

namespace App\Http\Controllers\Api;

use App\Enums\AttendanceStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\StoreAttendanceViaScanRequest;
use App\Models\Attendance;
use App\Models\Lecture;
use App\Models\Setting;
use App\Notifications\SentAttendanceScanNotification;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    /**
     * Process attendance scan from a QR code.
     *
     * @param Lecture $lecture
     * @param StoreAttendanceViaScanRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function processScan(Lecture $lecture, StoreAttendanceViaScanRequest $request)
    {

//        if (!$request->hasValidSignature()) {
//            return response()->json(['error' => __('main.invalid_response_code')], 400);
//        }


        $request->validated();

        $user = auth()->user();


        if (empty($user->mac_address)) {
            return response()->json(['error' => __('main.device_symbolic_address_not_available_mac_address')], 400);
        }

//        $date = $lecture->qrCode->created_at;

        $date = $lecture->datetime;

        $timezone = 'Asia/Riyadh';
        $now = \Carbon\Carbon::now($timezone);
        $start = \Carbon\Carbon::parse($lecture->datetime)->setTimezone($timezone);
        $end = $start->copy()->addHours($lecture->duration);

        $settings = Setting::getAllSettings();
        $allowedLateTime = $settings['late_threshold'] ?? 20;

        if ($now->between($start, $end)) {
            $minutesLate = $now->diffInMinutes($start,true);

            if ($minutesLate <= $allowedLateTime) {
                $status = AttendanceStatus::PRESENT->value;
            } else {
                $status = AttendanceStatus::LATE->value;
            }
        } elseif ($now->lt($start)) {
            $status = null;
        } else {
            $status = AttendanceStatus::ABSENT->value;
        }


        $body = __('main.attendance_not_recorded_future_lecture');
        $title = __('main.attendance_not_recorded');

//        if(!Attendance::query()->where('lecture_id', $lecture->id)->where('mac_address', $user->mac_address)->exists()) {
            if(!empty($status)) {
               if( $attendance =  Attendance::create([
                    'user_id' => $user->id,
                    'lecture_id' => $lecture->id,
                    'course_id' => $lecture->course_id,
                    'mac_address' => $user->mac_address,
                    'status' => $status,
                    'date' => now(),
                    'level_id' => $user->level_id
                ]) )
               {
                   if($status != AttendanceStatus::ABSENT->value) {
                       $body = __('main.successfully_recorded_attendance');
                       $title = __('main.recorded_attendance');
                   }else{
                       $body = __('main.successfully_recorded_attendance_as_absent');
                       $title = __('main.recorded_attendance_as_absent');
                   }
               }
            }

            $user->notify(new SentAttendanceScanNotification($title, $body));

        return response()->json([
                'status' => true,
                'message' => $body,
            ]);
//        }

//        return response()->json([
//            'status' => false,
//            'message' => __('main.attendance_has_already_been_recorded'),
//        ]);
    }
}
