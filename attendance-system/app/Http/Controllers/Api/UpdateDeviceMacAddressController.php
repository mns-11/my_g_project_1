<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStudentMacAddressRequest;
use Illuminate\Http\Request;

class UpdateDeviceMacAddressController extends Controller
{
    /**
     * Update Student MAC Address.
     *
     * This endpoint allows an authenticated student to update their MAC address.
     * Typically used to ensure device-level security or control access based on specific hardware.
     *
     * ### Request Requirements:
     * - The request must include a valid `mac_address` field.
     * - The student must be authenticated via the `student-api` guard.
     *
     * ### JSON Response Structure:
     * - `status`: HTTP status code:
     *   - `200`: Update was successful.
     *   - `400`: Failed to update the student's record.
     * - `data`: Empty array (reserved for future use).
     *
     * @response array{status: int, data: array}
     *
     * @param UpdateStudentMacAddressRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(UpdateStudentMacAddressRequest $request) {
        $validatedData = $request->validated();
        $student = auth()->user();
        $updatedSuccessful = $student->update($validatedData);
        $status = $updatedSuccessful ? 200 : 400;
        return response()->json([
            'status' => $status,
            'data' => []
        ],$status);
    }
}
