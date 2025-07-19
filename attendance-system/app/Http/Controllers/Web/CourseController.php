<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Models\College;
use App\Models\Course;
use App\Models\Level;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
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
        $query = Course::query();

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhereHas('major', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('level', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $query->latest();

        $courses = $query->paginate(15);
        return view('dashboard.admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $colleges = College::query()->get(['name', 'id']);
        $majors = Major::query()->get(['name', 'id', 'num_levels', 'college_id']);
        $levels = Level::query()->get(['name', 'id']);
        return view('dashboard.admin.courses.create', compact(['colleges' ,'majors', 'levels']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $data = $request->validated();
        $course = Course::query()->create($data);
        return to_route('courses.index')->with(['message' => ucwords(__('main.successfully_saved'))]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $colleges = College::query()->get(['name', 'id']);
        $majors = Major::query()->get(['name', 'id', 'num_levels', 'college_id']);
        $levels = Level::query()->get(['name', 'id']);
        return view('dashboard.admin.courses.edit', compact(['colleges' ,'majors', 'levels', 'course']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $data = $request->validated();

        $is_updated = $course->update($data);

        return to_route('courses.index')->with(['message' => $is_updated ? ucwords(__('main.successfully_edited')) : ucwords(__('main.edit_process_failed'))]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $is_deleted = $course->delete();
        return to_route('courses.index')->with(['message' =>$is_deleted ? ucwords(__('main.successfully_deleted')) : ucwords(__('main.delete_process_failed'))]);
    }
}
