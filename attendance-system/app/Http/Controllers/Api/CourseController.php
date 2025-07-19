<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $query = Course::query();

        $query->where('is_blocked', false);

        $query->where('college_id', auth()->user()->college_id);

        $query->where('major_id', auth()->user()->major_id);

        $query->where('level_id', auth()->user()->level_id);

       $courses = $query->paginate(20);

        return response()->json(['data' => $courses->toResourceCollection()]);

    }

    public function show(Course $course)
    {
        return response()->json(['data' => $course->toResource()]);
    }
}
