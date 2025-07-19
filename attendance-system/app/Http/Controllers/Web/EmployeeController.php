<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
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
       $query->role(['admin', 'coordinator']);
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('birthdate', 'like', "%{$search}%")
                    ->orWhere('gender', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $query->latest();

        $users = $query->paginate(15);
        return view('dashboard.admin.employees.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::query()->whereIn('name', ['admin', 'coordinator'])->get(['name', 'id']);
        return view('dashboard.admin.employees.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $user = User::query()->create($data);
        $user->syncRoles($data['role']);

//        $user->assignRole('admin');

        return to_route('employees.index')->with(['message' => ucwords(__('main.successfully_saved'))]);
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
        $user = User::query()->findOrFail($id);
        $roles = Role::query()->whereIn('name', ['admin', 'coordinator'])->get(['name', 'id']);
        return view('dashboard.admin.employees.edit', compact('user', 'roles'));
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
        $user = User::query()->findOrFail($id);

        $is_updated = $user->update($data);

        $user->syncRoles($data['role']);

        return to_route('employees.index')->with(['message' => $is_updated ? ucwords(__('main.successfully_edited')) : ucwords(__('main.edit_process_failed'))]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::query()->findOrFail($id);

        $is_deleted = $user->delete();
        return to_route('employees.index')->with(['message' =>$is_deleted ? ucwords(__('main.successfully_deleted')) : ucwords(__('main.delete_process_failed'))]);

    }
}
