<?php

namespace App\Console\Commands;

use App\Enums\AttendanceStatus;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\AbsenceWarningNotification;
use Illuminate\Console\Command;

class SendAbsenceAlerts extends Command
{
    protected $signature = 'alerts:absence';
    protected $description = 'Send absence warnings to students approaching limit';

    public function handle()
    {
        $settings = Setting::getAllSettings();

        if($settings['email_notifications'] == 'on' or $settings['email_notifications'] == true or $settings['email_notifications'] == 1) {
            $allowedPercentage = !empty($settings['max_absence_percentage']) ? $settings['max_absence_percentage'] : config('app.max_absence_percentage');
            $warningThreshold = !empty($settings['attendance_threshold']) ? $settings['attendance_threshold'] : config('app.attendance_threshold');

            $maxAbsenceForWarning = $allowedPercentage * ($warningThreshold / 100);

            User::role('student')
                ->whereNotNull('level_id')
                ->whereNotNull('major_id')
                ->chunkById(200, function ($students) use ($maxAbsenceForWarning, $allowedPercentage) {
                    foreach ($students as $student) {
                        $this->processStudent($student, $maxAbsenceForWarning, $allowedPercentage);
                    }
                });

            $this->info('Absence warnings sent successfully.');
        }else{
            $this->info('Absence warnings is disable by admin. turn it in Settings page in dashboard.');

        }

    }

    private function processStudent(User $student, $maxAbsenceForWarning, $allowedPercentage)
    {
        $courses = Course::query()->where('is_blocked', false)->where('level_id', $student->level_id)->get();

        if($courses->isNotEmpty()) {
            foreach ($courses as $course) {

                $absencePercentage = $this->calculateAbsencePercentage($student, $course);

                if ($absencePercentage >= $maxAbsenceForWarning) {
                    $this->sendWarning($student, $course, $absencePercentage, $allowedPercentage);
                }
            }
        }

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

    private function sendWarning(User $student, Course $course, $absencePercentage, $allowedPercentage)
    {
        $student->notify(new AbsenceWarningNotification(
            courseName: $course->name,
            absencePercentage: $absencePercentage,
            allowedPercentage: $allowedPercentage
        ));

        $this->info("Sent warning to {$student->email} for {$course->name} ({$absencePercentage}% absent)");
    }
}
