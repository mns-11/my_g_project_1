<?php

namespace App\Http\Controllers\Api;

use App\Enums\AttendanceStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\GetAttendancesRequest;
use App\Http\Requests\Attendance\UpdateAbsentAttendanceRequest;
use App\Models\Attendance;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttendanceController extends Controller
{

    /**
     * Display a paginated list of all attendances for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(GetAttendancesRequest $request)
    {
        $request->validated();

        $query = Attendance::query();

        $query->when(!empty($request->course_id), fn(Builder $query) => $query->where('course_id', $request->course_id));

        $query->where('level_id', auth()->user()->level_id);

        $query->where('user_id', auth()->user()->id);

        $attendances = $query->paginate(20);

        return response()->json(['data' => $attendances->toResourceCollection()]);
    }

    /**
     * Display a paginated list of absent absences pending approval for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function absent()
    {
        $query = Attendance::query();

        $query->where('level_id', auth()->user()->level_id);
        $query->where('user_id', auth()->user()->id);
        $query->where('status', AttendanceStatus::ABSENT->value);
        $query->whereNull('is_approved');
        $query->whereNull('reject_reason');
        $query->whereNull('is_transformed');

        $attendances = $query->paginate(15);
        return response()->json(['data' => $attendances->toResourceCollection()]);
    }

    /**
     * Display a paginated list of present absences pending approval for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function present()
    {
        $query = Attendance::query();

        $query->where('level_id', auth()->user()->level_id);
        $query->where('user_id', auth()->user()->id);
        $query->where('status', AttendanceStatus::PRESENT->value);
        $query->whereNull('is_approved');
        $query->whereNull('reject_reason');
        $query->whereNull('is_transformed');

        $attendances = $query->paginate(15);
        return response()->json(['data' => $attendances->toResourceCollection()]);
    }


    /**
     * Display a paginated list of absent absences pending approval for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function late()
    {
        $query = Attendance::query();

        $query->where('level_id', auth()->user()->level_id);
        $query->where('user_id', auth()->user()->id);
        $query->where('status', AttendanceStatus::LATE->value);
        $query->whereNull('is_approved');
        $query->whereNull('reject_reason');
        $query->whereNull('is_transformed');

        $attendances = $query->paginate(15);
        return response()->json(['data' => $attendances->toResourceCollection()]);
    }
    /**
     * Display a paginated list of transformed absences pending approval for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function transformed()
    {
        $query = Attendance::query();

        $query->where('level_id', auth()->user()->level_id);
        $query->where('user_id', auth()->user()->id);
        $query->where('status', AttendanceStatus::ABSENT->value);
        $query->whereNull('is_approved');
        $query->whereNull('reject_reason');
        $query->where('is_transformed', true);

        $attendances = $query->paginate(15);
        return response()->json(['data' => $attendances->toResourceCollection()]);
    }

    /**
     * Display a paginated list of approved mean accepted also absences for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function approved() // mean accepted also
    {
        $query = Attendance::query();

        $query->where('level_id', auth()->user()->level_id);
        $query->where('user_id', auth()->user()->id);
        $query->where('is_approved', true);
        $query->whereNull('reject_reason');

        $attendances = $query->paginate(15);
        return response()->json(['data' => $attendances->toResourceCollection()]);
    }


    /**
     * Display a paginated list of rejected absences for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function rejected()
    {
        $query = Attendance::query();

        $query->where('level_id', auth()->user()->level_id);
        $query->where('user_id', auth()->user()->id);
        $query->whereNotNull('reject_reason');

        $attendances = $query->paginate(15);
        return response()->json(['data' => $attendances->toResourceCollection()]);
    }

    /**
     * Upload an attachment for an absent attendance record.
     *
     * @param Attendance $attendance
     * @param UpdateAbsentAttendanceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadAbsentAttendanceAttachment(Attendance $attendance, UpdateAbsentAttendanceRequest $request)
    {
        $request->validated();
        $is_updated = false;
        if($user_id = auth()->id()) {
            $attachmentPath = null;
            if (request()->hasFile('attachment')) {
                $attachment = request()->file('attachment');
                $attachmentName = Str::random(10) . '_' . time() . '.' . $attachment->getClientOriginalExtension();
                $attachmentPath = $attachment->storeAs('attachments', $attachmentName, 'public');
            }
            if($attendance = Attendance::query()->where('id', $attendance->id)->whereNull('document_path')->where('status', AttendanceStatus::ABSENT->value)->where('user_id',$user_id )->first()){
                $data = [];
                $data['document_path'] = $attachmentPath;
                $data['excuse_type'] = $request->excuse_type ?? null;
                $is_updated = $attendance->update($data);
            }
        }
        return response()->json([
            'status' => $is_updated,
        ], $is_updated ? 200 : 400);
    }
}
