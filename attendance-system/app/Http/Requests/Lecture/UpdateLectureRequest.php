<?php

namespace App\Http\Requests\Lecture;

use App\Enums\CourseType;
use App\Models\Lecture;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateLectureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() and auth()->user()->hasRole('teacher');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'course_id' => 'sometimes|required|exists:courses,id',
            'type' => 'sometimes|required|in:' . implode(',', CourseType::values()),
            'college_id' => 'sometimes|required|exists:colleges,id',
            'major_id' => 'sometimes|required|exists:majors,id',
            'level_id' => 'sometimes|required|exists:levels,id',
//            'hall' => 'sometimes|required|string',
            'datetime' => 'sometimes|required|date_format:Y-m-d\TH:i',
            'duration' => 'sometimes|required|in:1,2,3,4,5,6'

        ];
    }

    public function attributes()
    {
        return [
            'course_id' => __('main.course'),
            'type' => __('main.type'),
            'college_id' => __('main.college'),
            'major_id' => __('main.major'),
            'level_id' => __('main.level'),
//            'hall' => __('main.location_gps_coordinates'),
            'datetime' => __('main.date_and_time_of_the_lecture'),
            'duration' => __('main.duration'),

        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($this->isLectureOverlapping()) {
                    $validator->errors()->add(
                        'datetime',
                        __('main.conflict_there_are_lecture_in_same_duration')
                    );
                }
            }
        ];
    }

    private function isLectureOverlapping(): bool
    {
        $timezone = 'Asia/Riyadh';
        $now = \Carbon\Carbon::now($timezone);
        $duration = (int)$this->duration;
        $startTime = Carbon::createFromFormat('Y-m-d\TH:i', $this->datetime, $timezone);
        $endTime = $startTime->copy()->addHours($duration);

        /* $hallConflict = Lecture::query()
             ->where('id', '!=', $this->lecture->id)
             ->where('hall_id', (int)$this->hall)
             ->where('academic_year_id', $this->academic_year_id)
             ->where(function ($query) use ($startTime, $endTime) {
                 $query->where('datetime', '<', $endTime)
                     ->whereRaw('ADDTIME(`datetime`, SEC_TO_TIME(`duration` * 3600)) > ?',
                         [$startTime->format('Y-m-d H:i:s')]);
             })
             ->exists();*/

        $teacherConflict = Lecture::query()
            ->where('id', '!=', $this->lecture->id)
            ->where('user_id', auth()->id())
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where('datetime', '<', $endTime)
                    ->whereRaw('ADDTIME(`datetime`, SEC_TO_TIME(`duration` * 3600)) > ?',
                        [$startTime->format('Y-m-d H:i:s')]);
            })
            ->exists();

//        return $hallConflict || $teacherConflict;
        return $teacherConflict;
    }
}
