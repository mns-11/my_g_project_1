<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\College;
use Illuminate\Http\Request;

class CollegeController extends Controller
{
    /**
     * Get all colleges.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $colleges = College::query()->get();
        return response()->json(['data' => $colleges->toResourceCollection()]);
    }

    /**
     * Display the specified college.
     */
    public function show(College $college)
    {
        return response()->json(['data' => $college->toResource()]);
    }
}
