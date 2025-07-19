<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    /**
     * Get all majors.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $majors = Major::query()->get();
        return response()->json(['data' => $majors->toResourceCollection()]);

    }

    /**
     * Display the specified major.
     */
    public function show(Major $major)
    {
        return response()->json(['data' => $major->toResource()]);
    }
}
