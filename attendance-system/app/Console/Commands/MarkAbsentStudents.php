<?php

namespace App\Console\Commands;

use App\Enums\AttendanceStatus;
use App\Models\Attendance;
use App\Models\Lecture;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MarkAbsentStudents extends Command
{
    protected $signature = 'attendance:mark-absent';
    protected $description = 'Mark students as absent for lectures after specific time of qr code created';

    public function handle()
    {
        $timezone = 'Asia/Riyadh';
        $now = Carbon::now($timezone);

        $timeOfCheckQrCodeCreated = $now->copy()->subMinutes(25);

    //Finished Lectures
        $lectures = Lecture::query()
            ->whereRaw('ADDTIME(datetime, SEC_TO_TIME(duration * 3600)) < ?',
                [$now->format('Y-m-d H:i:s')])
            ->get();

        // Ongoing Lectures
//        $lectures = Lecture::query()
//            ->where('datetime', '<=', $now)
//            ->whereRaw('ADDTIME(datetime, SEC_TO_TIME(duration * 3600)) >= ?',
//                [$now->format('Y-m-d H:i:s')])
//            ->get();


//        $lectures = Lecture::query()
//            ->whereHas('qrCode', function ($query) use ($timeOfCheckQrCodeCreated) {
//                $query->where('created_at', '<=', $timeOfCheckQrCodeCreated);
//            })
//            ->get();

        foreach ($lectures as $lecture) {
            $this->processLecture($lecture);
        }

//        $this->info('Successfully marked absent students for ongoing lectures.');
        $this->info('Successfully marked absent students for finished lectures.');
    }

    private function processLecture(Lecture $lecture)
    {
        $enrolledStudentIds = User::query()->role('student')
                ->where('college_id', $lecture->college_id)
                ->where('major_id', $lecture->major_id)
                ->where('level_id', $lecture->level_id)
                ->pluck('id');


        $attendedStudentIds = $lecture->attendances()
            ->whereIn('status', [
                AttendanceStatus::PRESENT->value,
                AttendanceStatus::LATE->value
            ])
            ->pluck('user_id');

        $absentStudentIds = $enrolledStudentIds->diff($attendedStudentIds);

//        $records = [];
        $timestamp = now();

      /*  foreach ($absentStudentIds as $studentId) {
            $records[] = [
                'course_id' => $lecture->course_id,
                'lecture_id' => $lecture->id,
                'user_id' => $studentId,
                'status' => AttendanceStatus::ABSENT->value,
                'date' => $timestamp,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        }

        foreach (array_chunk($records, 500) as $chunk) {
            Attendance::insertOrIgnore($chunk);
        }*/

        foreach ($absentStudentIds as $studentId) {
           if (!Attendance::query()->where('lecture_id', $lecture->id)->where('user_id', $studentId)->exists()) {
               if($userLevelId = User::query()->role('student')->find($studentId)->level_id){
                   Attendance::create([
                       'course_id' => $lecture->course_id,
                       'lecture_id' => $lecture->id,
                       'user_id' => $studentId,
                       'status' => AttendanceStatus::ABSENT->value,
                       'date' => $timestamp,
                       'level_id' => $userLevelId
                   ]);
               }

           }

        }

        $this->info("Marked {$absentStudentIds->count()} students as absent for lecture ID: {$lecture->id}");
    }
}
