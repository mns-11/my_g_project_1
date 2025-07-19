<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcademicYear\StoreAcademicYearRequest;
use App\Http\Requests\AcademicYearCollegeCourseHallMajorUser\StoreAcademicYearCollegeCourseHallMajorUserRequest;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    public function create()
    {
        return view('dashboard.admin.academic-years.create');
    }

    public function store(StoreAcademicYearRequest $request)
    {
        $data = $request->validated();
        $academicYear = AcademicYear::query()->create($data);
        return to_route('acchmus.index')->with(['message' => ucwords(__('main.successfully_saved'))]);
    }
}
