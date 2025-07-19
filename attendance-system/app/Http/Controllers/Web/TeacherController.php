<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\StoreTeacherRequest;
use App\Http\Requests\Teacher\UpdateTeacherRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\College;
use App\Models\Major;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
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
        $query = User::query();
        $query->role('teacher');
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('birthdate', 'like', "%{$search}%")
                    ->orWhere('gender', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('college', function ($q) use($search){
                        $q->where('name', 'like', "%{$search}%");})
                    ->orWhereHas('major', function ($q) use($search){
                        $q->where('name', 'like', "%{$search}%");});
            });
        }

        $query->latest();


        if( auth()->user()->hasRole('chief')) {
            $query->where('major_id', auth()->user()->major_id);
            $viewPath = 'dashboard.chief.teachers.index';

        }else{
            $viewPath = 'dashboard.admin.teachers.index';
        }

        $users = $query->paginate(15);
        return view($viewPath, compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $colleges = College::query()->get(['name', 'id']);
        $majors = Major::query()->get(['name', 'id', 'college_id']);
        $viewPath = auth()->user()->hasRole('chief') ?  'dashboard.chief.teachers.create' : 'dashboard.admin.teachers.create';
        return view($viewPath, compact('colleges', 'majors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        if( auth()->user()->hasRole('chief')) {
            $data['major_id'] = auth()->user()->major_id;
            $data['college_id'] = auth()->user()->college_id;
        }

        $user = User::query()->create($data);
        $user->assignRole('teacher');

        $returnPath = auth()->user()->hasRole('chief') ? 'chief.teachers.index' : 'teachers.index';

        return to_route($returnPath)->with(['message' => ucwords(__('main.successfully_saved'))]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::query()->role('teacher')->findOrFail($id);
        $colleges = College::query()->get(['name', 'id']);
        $majors = Major::query()->get(['name', 'id', 'college_id']);

        $viewPath = auth()->user()->hasRole('chief') ?  'dashboard.chief.teachers.edit' : 'dashboard.admin.teachers.edit';

        return view($viewPath, compact('user', 'colleges', 'majors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $data = $request->validated();
        if(empty($data['password'])){
            unset($data['password']);
        }else{
            $data['password'] = bcrypt($data['password']);
        }
        $user = User::query()->role('teacher')->findOrFail($id);

        $is_updated = $user->update($data);

        $returnPath = auth()->user()->hasRole('chief') ? 'chief.teachers.index' : 'teachers.index';


        return to_route($returnPath)->with(['message' => $is_updated ? ucwords(__('main.successfully_edited')) : ucwords(__('main.edit_process_failed'))]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::query()->role('teacher')->findOrFail($id);

        $is_deleted = $user->delete();

        $returnPath = auth()->user()->hasRole('chief') ? 'chief.teachers.index' : 'teachers.index';

        return to_route($returnPath)->with(['message' =>$is_deleted ? ucwords(__('main.successfully_deleted')) : ucwords(__('main.delete_process_failed'))]);

    }
}
