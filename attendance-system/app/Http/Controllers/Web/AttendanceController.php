<?php

namespace App\Http\Controllers\Web;

use App\Enums\AttendanceStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\StoreAttendanceRequest;
use App\Http\Requests\Attendance\UpdateAttendanceRequest;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\SentAttendanceScanNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{

    protected $studentController;
    public function __construct(StudentController $studentController)
    {
        $this->studentController = $studentController;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rules = [
            'search' => 'nullable|string'
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'searchErrors')->withInput();
        }

        $search = $request->input('search', null);
        $query = Attendance::query();

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('date', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('course', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('type', 'like', "%{$search}%");
                    })
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $query->latest();

        $attendances = $query->paginate(15);
        return view('dashboard.admin.attendances.index', compact('attendances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::query()->role('student')->get(['name', 'id']);
        $courses = Course::query()->where('is_blocked', false)->get(['name', 'id']);
        return view('dashboard.admin.attendances.create', compact(['users', 'courses']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttendanceRequest $request)
    {
        $data = $request->validated();
        $data['level_id'] = User::query()->role('student')->find($data['user_id'])->level_id;
        $attendance = Attendance::query()->create($data);
        return to_route('attendances.index')->with(['message' => ucwords(__('main.successfully_saved'))]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        $users = User::query()->role('student')->get(['name', 'id']);
        $courses = Course::query()->where('is_blocked', false)->get(['name', 'id']);
        return view('dashboard.admin.attendances.edit', compact(['users', 'courses', 'attendance']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        $data = $request->validated();

        if(auth()->user()->hasRole('chief') and array_key_exists('is_approved', $data) and $data['is_approved'] == 1) {
            $data['status'] = AttendanceStatus::EXCUSED->value;
        }

        if(!empty($data['user_id'])) {
            $data['level_id'] = User::query()->role('student')->find($data['user_id'])->level_id;
        }

        $is_updated = $attendance->update($data);

        $message = ucwords(__('main.edit_process_failed'));

        $routeName = 'attendances.index';

        if($is_updated) {
            $message = ucwords(__('main.successfully_edited'));

            if(auth()->user()->hasRole('chief')) {
                $routeName = 'attendances.transferred';

                if(array_key_exists('is_approved', $data)) {
                    if($data['is_approved'] == 1) {
                        $message = ucwords(__('main.excuse_accepted_and_attendance_status_updated_to_excused'));
                    }elseif($data['is_approved'] == 0 and !empty($data['reject_reason'])){
                        $message = ucwords(__('main.excuse_successfully_rejected'));
                    }else{
                        $message = ucwords(__('main.an_error_occurred'));
                    }
                }
            }elseif(auth()->user()->hasRole('coordinator')) {
                $routeName = 'attendances.excuses';

                if(array_key_exists('is_transformed', $data)) {
                    if($data['is_transformed'] == 1) {
                        $message = ucwords(__('main.excuse_successfully_forwarded_to_department_head'));
                    }elseif($data['is_transformed'] == 0 and !empty($data['reject_reason'])){
                        $message = ucwords(__('main.excuse_successfully_rejected'));
                    }else{
                        $message = ucwords(__('main.an_error_occurred'));
                    }
                }
            }
        }

        return to_route($routeName)->with(['message' => $message]);
    }

    public function excuses()
    {
        $query = Attendance::query();
        $query->where('status', AttendanceStatus::ABSENT->value);
        $query->whereNotNull('document_path');
        $query->whereNull('is_approved');
        if(auth()->user()->hasRole('chief')) {
            $query->whereNotNull('is_transformed');
            $query->whereHas('user',function ($q) {
                $q->where('major_id',auth()->user()->major_id);
            });
            $viewName = 'dashboard.chief.attendances-transferred';
        }else{
            $query->whereNull('is_transformed');
            $viewName = 'dashboard.coordinator.attendances.index';
        }
        $attendances = $query->paginate(15);
        return view($viewName, compact('attendances'));
    }

    public function manualAttendancePage(Request $request)
    {
        $user = null;
        $lectures = null;

        if(auth()->user()->hasRole('teacher')) {
//            $coursesIds = auth()->user()->academicYearCourseHallCollegeMajor()->pluck('course_id')->unique();
//            $courses = Course::query()->where('is_blocked', false)->whereIn('id',$coursesIds)->get();
            $lectures = Lecture::query()
                ->where('user_id', auth()->id())
                ->whereDate('datetime', today()->startOfDay())
                ->get();
        }

        if(!empty($request->search)){
            $searchRequest = new Request(['search' => $request->search]);
            $response = $this->studentController->getStudent($searchRequest);
            if ($response->getStatusCode() == 200) {
                $user = json_decode($response->getContent());
            }
        }
        return view('dashboard.teacher.manual-attendances', compact(['user', 'lectures']));
    }

    public function manualAttendance(Request $request)
    {
       $request->validate([
           'lecture_id' => 'required|exists:lectures,id',
           'user_id' => 'required|exists:users,id',
           'attendance' => 'required'
       ]);

       $attendance = null;


        $lecture = Lecture::query()->findOrFail($request->lecture_id);

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

        $exists = Attendance::query()
            ->where('user_id', $request->user_id)
            ->where('lecture_id', $lecture->id)
            ->exists();

        $body = __('main.attendance_not_recorded_future_lecture');
        $title = __('main.attendance_not_recorded');

        $user = User::query()->role('student')->findOrFail($request->user_id);

        if (!$exists and !empty($status)) {
            if($userLevelId = $user->level_id) {
                if($attendance = Attendance::create([
                    'course_id' => $lecture->course_id,
                    'lecture_id' => $lecture->id,
                    'user_id' => $user->id,
                    'date' => now(),
                    'status' => $status,
                    'level_id' => $userLevelId
                ])){
                    if($status != AttendanceStatus::ABSENT->value) {
                        $body = __('main.successfully_recorded_attendance');
                        $title = __('main.recorded_attendance');
                    }else{
                        $body = __('main.successfully_recorded_attendance_as_absent');
                        $title = __('main.recorded_attendance_as_absent');
                    }
                }

            }

        }

        $user->notify(new SentAttendanceScanNotification($title, $body));

        $message = $exists ? ucwords(__('main.student_has_already_been_prepared_for_this_lecture')) : null;
       return response()->json(data: ['message' => $message], status: $attendance ? 200 : 400);
    }

}
