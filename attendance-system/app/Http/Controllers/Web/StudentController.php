<?php

namespace App\Http\Controllers\Web;

use App\Enums\AttendanceStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Attendance;
use App\Models\College;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Level;
use App\Models\Major;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        $query = User::query();
        $query->role('student');
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('birthdate', 'like', "%{$search}%")
                    ->orWhere('gender', 'like', "%{$search}%")
                    ->orWhere('enrollment_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('college', function ($q) use($search){
                        $q->where('name', 'like', "%{$search}%");})
                    ->orWhereHas('major', function ($q) use($search){
                        $q->where('name', 'like', "%{$search}%");})
                    ->orWhereHas('level', function ($q) use($search){
                        $q->where('name', 'like', "%{$search}%");});
            });
        }

        $query->latest();

        $users = $query->paginate(15);
        $viewPath = auth()->user()->hasRole('coordinator') ? 'dashboard.coordinator.students.index' : 'dashboard.admin.students.index';
        return view($viewPath, compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $colleges = College::query()->get(['name', 'id']);
        $majors = Major::query()->get(['name', 'id', 'college_id', 'num_levels']);
        $levels = Level::query()->get(['name', 'id']);
        $viewPath = auth()->user()->hasRole('coordinator') ? 'dashboard.coordinator.students.create' : 'dashboard.admin.students.create';

        return view($viewPath, compact(['colleges', 'majors', 'levels']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
//        $data['enrollment_number'] = $this->generateEnrollmentNumber($data['major_id']);
        $user = User::query()->create($data);
        $user->assignRole('student');

        $returnPath = auth()->user()->hasRole('coordinator') ? 'coordinator.students.index' : 'students.index';

        return to_route($returnPath)->with(['message' => ucwords(__('main.successfully_saved'))]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::query()->role('student')->findOrFail($id);
        $colleges = College::query()->get(['name', 'id']);
        $majors = Major::query()->get(['name', 'id', 'college_id', 'num_levels']);
        $levels = Level::query()->get(['name', 'id']);

        $viewPath = auth()->user()->hasRole('coordinator') ? 'dashboard.coordinator.students.edit' : 'dashboard.admin.students.edit';

        return view($viewPath, compact(['colleges', 'majors', 'levels', 'user']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $data = $request->validated();
        if(empty($data['password'])){
            unset($data['password']);
        }else{
            $data['password'] = bcrypt($data['password']);
        }
        $user = User::query()->role('student')->findOrFail($id);

        $is_updated = $user->update($data);

        $returnPath = auth()->user()->hasRole('coordinator') ? 'coordinator.students.index' : 'students.index';

        return to_route($returnPath)->with(['message' => $is_updated ? ucwords(__('main.successfully_edited')) : ucwords(__('main.edit_process_failed'))]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::query()->role('student')->findOrFail($id);

        $is_deleted = $user->delete();
        $returnPath = auth()->user()->hasRole('coordinator') ? 'coordinator.students.index' : 'students.index';

        return to_route($returnPath)->with(['message' =>$is_deleted ? ucwords(__('main.successfully_deleted')) : ucwords(__('main.delete_process_failed'))]);

    }


    public function getStudent(Request $request)
    {
        $request->validate([
            'search' => 'required|string'
        ]);

        $search = $request->input('search');

        try {
            $user = User::role('student')
                ->where('id', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('enrollment_number', 'like', "%{$search}%")
                ->first();

            $user->college_name = $user->college->name;
            $user->major_name = $user->major->name;
            $user->level_name = $user->level->name;
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function generateEnrollmentNumber(int $majorId): string
    {
        $prefix = substr((string)$majorId, -1);
        $maxAttempts = 100;
        $attempts = 0;

        do {
            $randomPart = str_pad(mt_rand(0, 9999999), 7, '0', STR_PAD_LEFT);
            $enrollmentNumber = $prefix . $randomPart;

            $exists = User::query()->role('student')->where('enrollment_number', $enrollmentNumber)->exists();

            if (++$attempts >= $maxAttempts) {
                throw new \RuntimeException('Failed to generate unique enrollment number');
            }
        } while ($exists);

        return $enrollmentNumber;
    }

    public function transfer()
    {
        $settings = Setting::getAllSettings();

        $maxAbsentAllowed = !empty($settings['max_absence_percentage']) ? $settings['max_absence_percentage'] : config('app.max_absence_percentage');

        $levels = Level::query()->get();
        $nextLevelMap = [];

        foreach ($levels as $index => $level) {
            if (isset($levels[$index + 1])) {
                $nextLevelMap[$level->id] = $levels[$index + 1]->id;
            }
        }


        User::role('student')
            ->whereNotNull('level_id')
            ->whereNotNull('major_id')
            ->chunkById(500, function ($students) use ($maxAbsentAllowed, $nextLevelMap) {
                foreach ($students as $student) {
                    $maxLevelSequence = $student->major->num_levels;

                    if ($student->level_id >= $maxLevelSequence) {
                        Log::warning("Student {$student->id} is at max level ({$maxLevelSequence}) for major {$student->major->name}");
                        continue;
                    }

                    $this->processStudent($student, $maxAbsentAllowed, $nextLevelMap);
                }
            });

        return to_route('students.index')->with(['message' => ucwords(__('main.successfully_edited'))]);
    }

    private function processStudent(User $student, $maxAbsentAllowed, $nextLevelMap)
    {
        $courses = Course::query()->where('is_blocked', false)->where('level_id', $student->level_id)->get();

        if($courses->isEmpty()) {
            return;
        }

        foreach ($courses as $course) {
            $absencePercentage = $this->calculateAbsencePercentage($student, $course);


            if ($absencePercentage > $maxAbsentAllowed) {
                Log::warning("Student {$student->id} failed transfer due to {$absencePercentage}% absence in course {$course->id}");
                return;
            }
        }


        if (isset($nextLevelMap[$student->level_id])) {
            $student->update(['level_id' => $nextLevelMap[$student->level_id]]);
            Log::info("Student {$student->id} promoted to level {($student->level_id + 1)}");
        } else {
            Log::info("Student {$student->id} completed all levels");
        }
    }

   /* private function calculateAbsencePercentage(User $student, Course $course)
    {
        $lectureIds = Lecture::where('course_id', $course->id)
            ->where('college_id', $student->college_id)
            ->where('major_id', $student->major_id)
            ->where('level_id', $student->level_id)
            ->pluck('id');

        $totalLectures = $lectureIds->count();
        if ($totalLectures === 0) return 0;

        $absentCount = Attendance::where('user_id', $student->id)
            ->where(function ($query) use ($lectureIds){
                $query->whereIn('lecture_id', $lectureIds)
                ->orWhereNull('lecture_id')
                    ->where('status', AttendanceStatus::ABSENT->value);

            })
            ->where('course_id', $course->id)
            ->where('level_id', $student->level_id)
            ->where('status', AttendanceStatus::ABSENT->value)
            ->count();

        return ($absentCount / $totalLectures) * 100;
    }*/

    private function calculateAbsencePercentage(User $student, Course $course)
    {
        $lectureIds = Lecture::where('course_id', $course->id)
            ->where('level_id', $student->level_id)
            ->pluck('id');

        // Count total lectures (including manual entries)
        $totalRecords = Attendance::where('course_id', $course->id)
            ->where('level_id', $student->level_id)
            ->where(function ($query) use ($lectureIds) {
                $query->whereIn('lecture_id', $lectureIds)
                    ->orWhereNull('lecture_id');
            })
            ->count();

        if ($totalRecords === 0) return 0;

        $absentCount = Attendance::where('user_id', $student->id)
            ->where('course_id', $course->id)
            ->where('level_id', $student->level_id)
            ->where('status', AttendanceStatus::ABSENT->value)
            ->where(function ($query) use ($lectureIds) {
                $query->whereIn('lecture_id', $lectureIds)
                    ->orWhereNull('lecture_id');
            })
            ->count();


        return ($absentCount / $totalRecords) * 100;
    }
}
