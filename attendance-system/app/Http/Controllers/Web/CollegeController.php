<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\College\StoreCollegeRequest;
use App\Http\Requests\College\UpdateCollegeRequest;
use App\Models\College;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CollegeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rules = [
            'search' => 'nullable|string'
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'searchErrors')->withInput();
        }

        $search = $request->input('search', null);
        $query = College::query();

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $query->latest();

        $colleges = $query->paginate(15);
        return view('dashboard.admin.colleges.index', compact('colleges'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.colleges.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCollegeRequest $request)
    {
        $data = $request->validated();
        $college = College::query()->create($data);
        return to_route('colleges.index')->with(['message' => ucwords(__('main.successfully_saved'))]);
    }

    /**
     * Display the specified resource.
     */
    public function show(College $college)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(College $college)
    {
        return view('dashboard.admin.colleges.edit', compact('college'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCollegeRequest $request, College $college)
    {
        $data = $request->validated();

        $is_updated = $college->update($data);

        return to_route('colleges.index')->with(['message' => $is_updated ? ucwords(__('main.successfully_edited')) : ucwords(__('main.edit_process_failed'))]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(College $college)
    {
        $is_deleted = $college->delete();
        return to_route('colleges.index')->with(['message' =>$is_deleted ? ucwords(__('main.successfully_deleted')) : ucwords(__('main.delete_process_failed'))]);
    }
}
