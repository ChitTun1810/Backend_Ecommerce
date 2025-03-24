<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = User::with(['roles'])->latest('id')->paginate(10);
        return Inertia::render("Admin/User/Index", [
            'users' => $users,
        ]);
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = Role::all();
        return Inertia::render('Admin/User/Create', [
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:4',
            'role'     => 'exists:roles,name|required',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole($request->role);
            DB::commit();
            return to_route('admin.users.index');
        }
        catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function edit($id)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all();
        $user  = User::with(['roles'])->find($id);
        return Inertia::render('Admin/User/Edit', [
            'roles' => $roles,
            'user'  => $user,
        ]);
    }

    // public function show($id)
    // {
    //     $user = User::find($id);
    //     return Inertia::render('Admin/User/Show', [
    //         'user' => $user,
    //     ]);
    // }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:4',
            'role'     => 'exists:roles,name|required',
        ]);

        try {
            DB::beginTransaction();
            $user = User::find($id);
            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);

            if (!empty($request->password)) {
                $user->password = Hash::make($request->passowrd);
                $user->update();
            }

            $user->syncRoles($request->role);
            DB::commit();
            return to_route('admin.users.index');
        }
        catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return to_route('admin.users.index');
    }
}
