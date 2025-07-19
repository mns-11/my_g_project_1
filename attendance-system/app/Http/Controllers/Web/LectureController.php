<?php

namespace App\Http\Controllers\Web;

use App\Enums\AttendanceStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Lecture\GetLecturesRequest;
use App\Http\Requests\Lecture\StoreLectureRequest;
use App\Http\Requests\Lecture\UpdateLectureRequest;
use App\Models\AcademicYearCollegeCourseHallMajorUser;
use App\Models\Attendance;
use App\Models\College;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Level;
use App\Models\Major;
use App\Models\QrCode;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode as SimpleSoftwareQrCode;

class LectureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetLecturesRequest $request)
    {

        $request->validated();

        $query = Lecture::query();
        $query->where('user_id', auth()->id());

        $query->when(!empty($request->course_id), fn(Builder $query) => $query->where('course_id', $request->course_id));

        $query->when(!empty($request->status), function(Builder $query) use ($request) {
            $timezone = 'Asia/Riyadh';
            $now = \Carbon\Carbon::now($timezone);

            switch($request->status) {
                case 1:
                    $query->where(function($q) use ($now) {
                        $q->where('datetime', '<=', $now)
                            ->whereRaw('ADDTIME(`datetime`, SEC_TO_TIME(`duration` * 3600)) >= ?', [$now->format('Y-m-d H:i:s')]);
                    });
                    break;

                case 2:
                    $query->where('datetime', '>', $now);
                    break;

                case 3:
                    $query->whereRaw('ADDTIME(`datetime`, SEC_TO_TIME(`duration` * 3600)) < ?', [$now->format('Y-m-d H:i:s')]);
                    break;
            }
        });

        $coursesIds = auth()->user()->academicYearCourseHallCollegeMajor()->pluck('course_id')->unique();
        $courses = Course::query()->where('is_blocked', false)->whereIn('id',$coursesIds)->get();

        $query->latest();

        $lectures = $query->paginate(5);

        return view('dashboard.teacher.lectures.index', compact('lectures', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $coursesIds = auth()->user()->academicYearCourseHallCollegeMajor()->pluck('course_id')->unique();
        $courses = Course::query()->where('is_blocked', false)->whereIn('id',$coursesIds)->get();
        $colleges = College::query()->get(['name', 'id']);
        $majors = Major::query()->get(['name', 'id', 'college_id', 'num_levels']);
        $levels = Level::query()->get(['name', 'id']);
        return view('dashboard.teacher.lectures.create', compact(['courses', 'colleges', 'majors', 'levels']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLectureRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();


       if ( $hallName = AcademicYearCollegeCourseHallMajorUser::query()
                        ->where('course_id', $data['course_id'])
                        ->where('college_id', $data['college_id'])
                        ->where('major_id', $data['major_id'])
                        ->where('type', $data['type'])
                        ->where('user_id', $data['user_id'])
                        ->first()->hall->name) {
            $data['hall'] = $hallName;
        }



//        $expiration = Carbon::parse($data['datetime'])->addHours(5);
//        dd($data);
        $lecture = Lecture::query()->create($data);

      /*  $attendanceUrl = URL::temporarySignedRoute(
             'attendance.scan',
            $expiration
            ,
            [
                'lecture' => $lecture->id,
            ]
        );

        $qrImage = SimpleSoftwareQrCode::size(300)->format('svg')->generate($attendanceUrl,null,'gd');

        $path = 'qr_codes/' . uniqid() . '.svg';
        if(Storage::disk('public')->put($path, $qrImage)){
            QrCode::query()->create(['image_path' => $path, 'lecture_id' => $lecture->id]);
        }*/

        return to_route('teacher.lectures.index')->with(['message' => ucwords(__('main.successfully_saved'))]);
    }

    /**
     * Display the specified resource.
     */
    public function processScan(Lecture $lecture, Request $request)
    {
        if (!$request->hasValidSignature()) {
            return response()->json(['error' => 'رمز الاستجابة غير صالح'], 403);
        }

        $request->validate([
            'mac_address' => ['required', 'string', 'max:255']
        ]);

        $user = auth()->user();

        if (empty($user->mac_address)) {
            return response()->json(['error' => 'العنوان الرمزي للجهاز غير متوفر "mac address"'], 403);
        }


        $status = now()->diffInMinutes($lecture->date) > 20
            ? AttendanceStatus::LATE->value
            : AttendanceStatus::PRESENT->value;

        Attendance::create([
            'user_id' => $user->id,
            'lecture_id' => $lecture->id,
            'course_id' => $lecture->course_id,
            'mac_address' => $user->mac_address,
            'status' => $status,
            'date' => now(),
            'level_id' => $user->level_id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'تم تسجيل الحضور بنجاح',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lecture $lecture)
    {
        $coursesIds = auth()->user()->academicYearCourseHallCollegeMajor()->pluck('course_id')->unique();
        $courses = Course::query()->where('is_blocked', false)->whereIn('id',$coursesIds)->get();
        $colleges = College::query()->get(['name', 'id']);
        $majors = Major::query()->get(['name', 'id', 'college_id', 'num_levels']);
        $levels = Level::query()->get(['name', 'id']);
        return view('dashboard.teacher.lectures.edit', compact(['courses', 'colleges', 'majors', 'levels', 'lecture']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLectureRequest $request, Lecture $lecture)
    {
        $data = $request->validated();
        $data['datetime'] = $data['datetime'] ?? $lecture->datetime;
//        $expiration = Carbon::parse($data['datetime'])->addHours(5);
//        dd($data);

        $is_updated = $lecture->update($data);

//        $attendanceUrl = URL::temporarySignedRoute(
//            'attendance.scan',
//            $expiration
//            ,
//            [
//                'lecture' => $lecture->id,
//            ]
//        );

//        $qrImage = SimpleSoftwareQrCode::size(300)->format('svg')->generate($attendanceUrl,null,'gd');

//        $path = 'qr_codes/' . uniqid() . '.svg';
//        if(Storage::disk('public')->put($path, $qrImage)){
//            QrCode::query()->where('lecture_id', $lecture->id)->update(['image_path' => $path]);
//        }

        return to_route('teacher.lectures.index')->with(['message' => $is_updated ? ucwords(__('main.successfully_edited')) : ucwords(__('main.edit_process_failed'))]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function showStudents(Lecture $lecture)
    {
        $attendances = Attendance::query()->where('lecture_id',$lecture->id)->get();
        $numberOfAttendees = Attendance::query()->where('lecture_id',$lecture->id)->where('status', AttendanceStatus::PRESENT->value)->count();
        $numberOfAbsentees = Attendance::query()->where('lecture_id',$lecture->id)->where('status', AttendanceStatus::ABSENT->value)->count();
        $numberOfLatecomers = Attendance::query()->where('lecture_id',$lecture->id)->where('status', AttendanceStatus::LATE->value)->count();

        return view('dashboard.teacher.lectures.students', compact(['attendances'], 'numberOfAbsentees', 'numberOfAttendees', 'numberOfLatecomers'));
    }

    public function generateQRCode(Lecture $lecture)
    {
        $lectureDuration = (int)$lecture->duration;
        $expiration = Carbon::parse($lecture->datetime)->addHours($lectureDuration);

        $attendanceUrl = URL::temporarySignedRoute(
            'attendance.scan',
            $expiration
            ,
            [
                'lecture' => $lecture->id,
            ]
        );

        $qrImage = SimpleSoftwareQrCode::size(300)->format('svg')->generate($attendanceUrl,null,'gd');

        $path = 'qr_codes/' . uniqid() . '.svg';
        if(Storage::disk('public')->put($path, $qrImage)){
            QrCode::query()->create(['image_path' => $path, 'lecture_id' => $lecture->id]);
        }
        return to_route('teacher.lectures.index')->with(['message' => ucwords(__('main.successfully_saved'))]);
    }
}
