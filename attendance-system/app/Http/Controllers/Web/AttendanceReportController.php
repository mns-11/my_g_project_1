<?php

namespace App\Http\Controllers\Web;

use App\Enums\AttendanceStatus;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceReport;
use App\Models\College;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Level;
use App\Models\Major;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Rezgui\LaravelMpdfDz\Facades\LaravelMpdfDz as Pdf;
class AttendanceReportController extends Controller
{
    public function index()
    {
        $presentCount = $this->attendances(AttendanceStatus::PRESENT->value);
        $absentCount = $this->attendances(AttendanceStatus::ABSENT->value);

        $collegesCountsInfo = User::query()
            ->role('student')
            ->select('college_id', DB::raw('count(*) as total'))
            ->with('college')
            ->groupBy('college_id')
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                        $item->college->name => $item->total
                ];
            });

        return view('dashboard.admin.reports.index', compact(['presentCount', 'absentCount', 'collegesCountsInfo']));
    }
    private function attendances($status)
    {
        $query = Attendance::query();
        $query->where('status', $status);
        return $query->count();
    }

    public function create()
    {
        $colleges = College::query()->get(['name','id']);
        $majors = Major::query()->get(['name','id', 'college_id', 'num_levels']);
        $levels = Level::query()->get(['name','id']);
        $sentReports = AttendanceReport::whereNotNull('sent_at')->latest()->paginate(15);

//        dd($sentReports[1]['report_data'][0]);
        return view('dashboard.coordinator.attendance_report', compact('colleges', 'majors', 'levels', 'sentReports'));
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'type' => 'required|in:general,custom',
            'college_id' => 'nullable|exists:colleges,id',
            'major_id' => 'nullable|exists:majors,id',
            'level_id' => 'nullable|exists:levels,id',
            'enrollment_number' => 'nullable|exists:users,enrollment_number'
        ]);

        $type = $request->type;
        $userId = auth()->id();

        if ($type === 'general') {
            $reportData = $this->generateGeneralReport($request);
            $report = AttendanceReport::create([
                'type' => 'general',
                'college_id' => $request->college_id,
                'major_id' => $request->major_id,
                'level_id' => $request->level_id,
                'report_data' => $reportData,
                'generated_by' => $userId
            ]);
        } else {
            $reportData = $this->generateCustomReport($request->user_id);
            $user = User::query()->role('student')->find($request->user_id);
            $report = AttendanceReport::create([
                'type' => 'custom',
                'user_id' => $request->user_id,
                'college_id' => $user->college_id,
                'major_id' => $user->major_id,
                'level_id' => $user->level_id,
                'report_data' => $reportData,
                'generated_by' => $userId
            ]);
        }

        return response()->json([
            'success' => true,
            'report' => $reportData,
            'report_id' => $report->id
        ]);
    }

    public function sendReport(Request $request)
    {
        $request->validate([
            'report_id' => 'required|exists:attendance_reports,id'
        ]);

        $report = AttendanceReport::find($request->report_id);
        $report->update(['sent_at' => now()]);

        return response()->json(['success' => true]);
    }

    public function getSentReports()
    {
        $query = AttendanceReport::query();
        $query->whereNotNull('sent_at')->latest();

        if(auth()->user()->hasRole('chief')) {
            if(!empty(auth()->user()->major)) {
                $query->where('college_id', auth()->user()->major->college_id)
                    ->orWhere('major_id', auth()->user()->major_id);
            }

            $reports = $query->paginate(15);
            return view('dashboard.chief.reports-transferred', compact('reports'));
        }else{
            $reports = $query->get();
            return response()->json(['reports' => $reports]);
        }
    }

   /* private function generateGeneralReport(Request $request)
    {
        $query = User::query()->role('student');

        if ($request->college_id) {
            $query->where('college_id', $request->college_id);
        }

        if ($request->major_id) {
            $query->where('major_id', $request->major_id);
        }

        if ($request->level_id) {
            $query->where('level_id', $request->level_id);
        }


        $students = $query->with(['attendances' => function($q) {
            $q->selectRaw('user_id,
                SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as present_count,
                SUM(CASE WHEN status = 3 THEN 1 ELSE 0 END) as absent_count')
                ->groupBy('user_id');
        }])->get();

//        $students = $query->with(['attendances' => function($q) {
//            $q->selectRaw('user_id, course_id,
//            SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as present_count,
//            SUM(CASE WHEN status = 3 THEN 1 ELSE 0 END) as absent_count')
//                ->groupBy('user_id', 'course_id');
//        }])->get();

        $reportData = [];
        $counter = 1;

        foreach ($students as $student) {
            $attendance = $student->attendances->first();
            $total = ($attendance->present_count ?? 0) + ($attendance->absent_count ?? 0);
            $percentage = $total > 0 ? round(($attendance->present_count / $total) * 100) : 0;

            $reportData[] = [
                'counter' => $counter++,
                'student_name' => $student->name,
                'enrollment_number' => $student->enrollment_number,
                'major' => $student->major->name,
                'college' => $student->college->name,
                'level' => $student->level->name,
//                'course' => $attendance->course->name,
//                'course_type' => __('main.' . $attendance->course->type->getName()),
                'present_count' => $attendance->present_count ?? 0,
                'absent_count' => $attendance->absent_count ?? 0,
                'percentage' => $percentage . '%'
            ];
        }

        return $reportData;
    }

    private function generateCustomReport($studentId)
    {
        $query = User::query()->role('student')->where('id', $studentId);

        $reportData = [];
        $counter = 1;

        $student = $query->with(['attendances' => function($q) {
            $q->selectRaw('user_id,
                SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as present_count,
                SUM(CASE WHEN status = 3 THEN 1 ELSE 0 END) as absent_count')
                ->groupBy('user_id');
        }])->first();


            $attendance = $student->attendances->first();
            $total = ($attendance->present_count ?? 0) + ($attendance->absent_count ?? 0);
            $percentage = $total > 0 ? round(($attendance->present_count / $total) * 100) : 0;

            $reportData[] = [
                'counter' => $counter++,
                'student_name' => $student->name,
                'enrollment_number' => $student->enrollment_number,
                'major' => $student->major->name,
                'college' => $student->college->name,
                'level' => $student->level->name,
//                'course' => $attendance->course->name,
//                'course_type' => __('main.' . $attendance->course->type->getName()),
                'present_count' => $attendance->present_count ?? 0,
                'absent_count' => $attendance->absent_count ?? 0,
                'percentage' => $percentage . '%'
            ];

        return $reportData;
    }

//    private function generateCustomReport($studentId)
//    {
//        $student = User::query()->role('student')->findOrFail($studentId);
//
//        $reportData = [];
//        $counter = 1;
//
//        foreach ($student->attendances->groupBy('course_id') as $courseId => $attendances) {
//            $present = $attendances->where('status', AttendanceStatus::PRESENT->value)->count();
//            $absent = $attendances->where('status', AttendanceStatus::ABSENT->value)->count();
//            $total = $present + $absent;
//            $percentage = $total > 0 ? round(($present / $total) * 100) : 0;
//
////            dd([
////                'type' => __('main.' . $attendances->first()->course->type->getName()),
////                'lang' => LaravelLocalization::getCurrentLocale()
////                ]);
//            $reportData[] = [
//                'counter' => $counter++,
//                'student_name' => $student->name,
//                'user_id' => $student->id,
//                'major' => $student->major->name,
//                'level' => $student->level->name,
////                'course' => $attendances->first()->course->name,
////                'course_type' =>  __('main.' . $attendances->first()->course->type->getName()),
//                'present_count' => $present,
//                'absent_count' => $absent,
//                'percentage' => $percentage . '%'
//            ];
//        }
//
////        dd($reportData);
//        return $reportData;
//    }*/

    // AttendanceReportController.php

    private function generateGeneralReport(Request $request)
    {
        $query = User::query()->role('student');

        if ($request->college_id) {
            $query->where('college_id', $request->college_id);
        }

        if ($request->major_id) {
            $query->where('major_id', $request->major_id);
        }

        if ($request->level_id) {
            $query->where('level_id', $request->level_id);
        }

        $students = $query->with(['attendances.course'])->get();
        $reportData = [];
        $counter = 1;

        foreach ($students as $student) {
            $attendanceByCourse = $student->attendances->groupBy('course_id');

            foreach ($attendanceByCourse as $courseId => $attendances) {
                if(Course::query()->where('id', $courseId)->where('level_id', $student->level_id)->where('major_id', $student->major_id)->exists()) {
                    $course = $attendances->first()->course;
                    $absencePercentage = round($this->calculateAbsencePercentage($student, $course));

                    $present = $attendances->where('status', AttendanceStatus::PRESENT->value)->count();
                    $absent = $attendances->where('status', AttendanceStatus::ABSENT->value)->count();
                    $total = $present + $absent;
                    $percentage = $total > 0 ? round(($present / $total) * 100) : 0;

                    $reportData[] = [
                        'counter' => $counter++,
                        'student_name' => $student->name,
                        'enrollment_number' => $student->enrollment_number,
                        'major' => $student->major->name,
                        'college' => $student->college->name,
                        'level' => $student->level->name,
                        'course' => $course->name,
                        'course_type' => __('main.' . $course->type->getName()),
                        'present_count' => $present,
                        'absent_count' => $absent,
//                        'percentage' => $percentage . '%',
                        'percentage' => $absencePercentage . '%',
                    ];
                }

            }
        }

        return $reportData;
    }

    private function generateCustomReport($studentId)
    {
        $student = User::query()->role('student')->findOrFail($studentId);
        $reportData = [];
        $counter = 1;

        $attendanceByCourse = $student->attendances->groupBy('course_id');

        foreach ($attendanceByCourse as $courseId => $attendances) {
            $course = $attendances->first()->course;
            $present = $attendances->where('status', AttendanceStatus::PRESENT->value)->count();
            $absent = $attendances->where('status', AttendanceStatus::ABSENT->value)->count();
            $total = $present + $absent;
            $percentage = $total > 0 ? round(($present / $total) * 100) : 0;

            $absencePercentage = round($this->calculateAbsencePercentage($student, $course));

            $reportData[] = [
                'counter' => $counter++,
                'student_name' => $student->name,
                'enrollment_number' => $student->enrollment_number,
                'major' => $student->major->name,
                'college' => $student->college->name,
                'level' => $student->level->name,
                'course' => $course->name,
                'course_type' => __('main.' . $course->type->getName()),
                'present_count' => $present,
                'absent_count' => $absent,
//                'percentage' => $percentage . '%'
                'percentage' => $absencePercentage . '%'
            ];
        }

        return $reportData;
    }

    public function searchStudents(Request $request)
    {
        $query = $request->input('query');

        $students = User::query()->role('student')->where('name', 'LIKE', "%$query%")
//            ->orWhere('id', 'LIKE', "%$query%")
            ->orWhere('enrollment_number', 'LIKE', "%$query%")
            ->limit(10)
            ->get(['id', 'name', 'enrollment_number']);

        return response()->json($students);
    }


    public function getLatestSentReport()
    {
        $report = AttendanceReport::whereNotNull('sent_at')
            ->latest('sent_at')
            ->first();

        return response()->json([
            'report' => $report ? [
                'id' => $report->id,
                'type' => $report->type,
                'sent_at' => $report->sent_at,
                'report_data' => $report->report_data
            ] : null
        ]);
    }

    public function downloadPdf(string $id)
    {
        $data = AttendanceReport::query()->findOrFail($id);
        $date = $data->created_at->format('Y-m-d H:i');
        $pdf = Pdf::loadView('pdf.attendance-report', ['data' =>$data->toArray(), 'date' => $date]);
        $fileName = date('Y-m-d H:i') . '_report.pdf';
        return $pdf->download($fileName);
    }

    private function calculateAbsencePercentage(User $student, Course $course): float
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
