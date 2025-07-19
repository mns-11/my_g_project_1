<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $coursesCount = Course::query()->count();
        $studentsCount = User::query()->role('student')->count();
        $teachersCount = User::query()->role('teacher')->count();
        $employeesCount = User::query()->role(['admin', 'coordinator'])->count();
        return view('dashboard.admin.index', compact(['coursesCount', 'studentsCount', 'teachersCount', 'employeesCount']));
    }
}
