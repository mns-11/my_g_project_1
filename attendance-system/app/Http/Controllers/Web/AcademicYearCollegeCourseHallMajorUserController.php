<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcademicYearCollegeCourseHallMajorUser\StoreAcademicYearCollegeCourseHallMajorUserRequest;
use App\Http\Requests\AcademicYearCollegeCourseHallMajorUser\UpdateAcademicYearCollegeCourseHallMajorUserRequest;
use App\Models\AcademicYear;
use App\Models\AcademicYearCollegeCourseHallMajorUser;
use App\Models\College;
use App\Models\Course;
use App\Models\Hall;
use App\Models\Level;
use App\Models\Major;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AcademicYearCollegeCourseHallMajorUserController extends Controller
{
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
        $query = AcademicYearCollegeCourseHallMajorUser::query();

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->whereHas('major', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('college', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('academicYear', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('course', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('hall', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }
        $records = $query->paginate(15);
        return view('dashboard.admin.acchmus.index', compact('records'));
    }

    public function inquiry(Request $request)
    {
        $colleges = College::query()->get(['name', 'id']);
        $majors = Major::query()->get(['name', 'id', 'college_id', 'num_levels']);
        $levels = Level::query()->get(['name', 'id']);
        $halls = Hall::query()->get(['name', 'location', 'id']);
        $users = User::query()->role('teacher')->get(['id', 'name', 'college_id', 'major_id']);
        $academicYears = AcademicYear::query()->get(['id', 'name']);
        $courses = Course::query()->where('is_blocked', false)->get(['id', 'name', 'college_id', 'level_id', 'major_id']);

        return view('dashboard.admin.acchmus.inquiry', compact([
            'colleges', 'majors', 'levels', 'halls', 'users', 'academicYears', 'courses'
        ]));
    }

    public function create()
    {
        $colleges = College::query()->get(['name', 'id']);
        $majors = Major::query()->get(['name', 'id', 'college_id', 'num_levels']);
        $levels = Level::query()->get(['name', 'id']);
        $halls = Hall::query()->get(['name', 'location', 'id']);
        $users = User::query()->role('teacher')->get(['id', 'name', 'college_id', 'major_id']);
        $academicYears = AcademicYear::query()->get(['id', 'name']);
        $courses = Course::query()->where('is_blocked', false)->get(['id', 'name', 'college_id', 'level_id', 'major_id']);
        return view(
            'dashboard.admin.acchmus.create',
            compact([
                'colleges', 'majors', 'levels', 'halls', 'users', 'academicYears', 'courses'
            ]));
    }

    public function store(StoreAcademicYearCollegeCourseHallMajorUserRequest $request)
    {
        $data = $request->validated();
        $record = AcademicYearCollegeCourseHallMajorUser::query()->create($data);
        return to_route('acchmus.index')->with(['message' => ucwords(__('main.successfully_saved'))]);
    }

    public function edit(string $id)
    {
        $record = AcademicYearCollegeCourseHallMajorUser::query()->findOrFail($id);

        $colleges = College::query()->get(['name', 'id']);
        $majors = Major::query()->get(['name', 'id', 'college_id', 'num_levels']);
        $levels = Level::query()->get(['name', 'id']);
        $halls = Hall::query()->get(['name', 'location', 'id']);
        $users = User::query()->role('teacher')->get(['id', 'name', 'college_id', 'major_id']);
        $academicYears = AcademicYear::query()->get(['id', 'name']);
        $courses = Course::query()->where('is_blocked', false)->get(['id', 'name', 'college_id', 'level_id', 'major_id']);
        return view(
            'dashboard.admin.acchmus.edit',
            compact([
                'colleges', 'majors', 'levels', 'halls', 'users', 'record', 'academicYears', 'courses'
            ]));
    }

    public function update(UpdateAcademicYearCollegeCourseHallMajorUserRequest $request, string $id)
    {
        $record = AcademicYearCollegeCourseHallMajorUser::query()->findOrFail($id);

        $data = $request->validated();

        $is_updated = $record->update($data);

        return to_route('acchmus.index')->with(['message' => $is_updated ? ucwords(__('main.successfully_edited')) : ucwords(__('main.edit_process_failed'))]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = AcademicYearCollegeCourseHallMajorUser::query()->findOrFail($id);

        $is_deleted = $record->delete();
        return to_route('acchmus.index')->with(['message' =>$is_deleted ? ucwords(__('main.successfully_deleted')) : ucwords(__('main.delete_process_failed'))]);
    }

    public function showQueryForm()
    {
        $colleges = College::all();
        $academicYears = AcademicYear::all();

        return view('courses-query', compact('colleges', 'academicYears'));
    }

    public function getDepartments(Request $request)
    {
        $request->validate(['college_id' => 'required|exists:colleges,id']);
        return Major::where('college_id', $request->college_id)->get(['id', 'name']);
    }

    public function getLevels(Request $request)
    {
        $request->validate([
            'college_id' => 'required|exists:colleges,id',
            'major_id' => 'required|exists:majors,id'
        ]);

        $major = Major::query()->select('num_levels')->findOrFail($request->major_id);
        return Level::query()->limit($major->num_levels)->get();
    }

    public function getCourses(Request $request)
    {
        $request->validate([
            'college_id' => 'required|exists:colleges,id',
            'major_id' => 'required|exists:majors,id',
            'level' => 'required'
        ]);

        return Course::where('college_id', $request->college_id)
            ->where('major_id', $request->major_id)
            ->where('level', $request->level)
            ->where('is_blocked', false)
            ->get(['id', 'name']);
    }

    public function getTeachers(Request $request)
    {
        $request->validate([
            'college_id' => 'required|exists:colleges,id',
            'major_id' => 'required|exists:majors,id',
            'course_id' => 'required|exists:courses,id',
            'academic_year_id' => 'required|exists:academic_years,id'
        ]);

        return AcademicYearCollegeCourseHallMajorUser::with('user')
            ->where([
                'college_id' => $request->college_id,
                'major_id' => $request->major_id,
                'course_id' => $request->course_id,
                'academic_year_id' => $request->academic_year_id
            ])
            ->get()
            ->map(function($record) {
                return [
                    'name' => $record->user->name,
                    'email' => $record->user->email,
                    'phone' => $record->user->phone
                ];
            });
    }
}
