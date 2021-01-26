<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        $items = User::with('department', 'roles')->get();

        return view('users.index', compact('items'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->hasRole('admin')) {
            $roles = Role::select('name', 'id')->pluck('name', 'id')->toArray();
            $departments = Department::select('name', 'id')->pluck('name', 'id')->toArray();

            return view('users.create', compact('departments', 'roles'));
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse;
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|string|max:255',
            'email' => 'bail|required|unique:users|email',
            'department_id' => 'bail|required|integer',
            'password' => 'bail|required|string|min:8',
            'role_id' => ' bail|required|integer',
        ]);


        if (Auth::user()->hasRole('admin')) {
            try {
                DB::beginTransaction();
                $request->merge(['password' => bcrypt($request->input('password'))]);
                $user = User::create($request->all());
                $role = Role::findOrFail($request->input('role_id'));
                $user->assignRole($role);
                DB::commit();
                return redirect()->route('user_index');
            } catch (\Throwable $e) {
                DB::rollBack();
                report($e);
                return back()->withInput();
            }
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->hasRole('admin')) {
            $item = User::findOrFail($id);
            $roles = Role::select('name', 'id')->pluck('name', 'id')->toArray();
            $departments = Department::select('name', 'id')->pluck('name', 'id')->toArray();
            $user_roles = $item->roles()->pluck('id')->toArray();

            return view('users.edit', compact('roles', 'departments', 'user_roles', 'item'));
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->hasRole('admin')) {
            $item = User::findOrFail($id);
            $request->validate([
                'email' => 'nullable|email|unique:users,email,' . $item->id,
                'name' => 'bail|required|string|max:255',
                'department_id' => 'bail|required|integer',
                'role_id' => ' bail|required|integer',
            ]);
            DB::beginTransaction();
            try {
                $item->syncRoles($request->input('role_id'));
                $item->update($request->all());
                DB::commit();
                return redirect()->route('user_index');

            } catch (\Throwable $e) {
                DB::rollBack();
                report($e);
                return back()->withInput($request->all());
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (Auth::user()->hasRole('admin')) {
            DB::beginTransaction();
            try {
                $item = User::findOrFail($id);
                $item->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'User successfully deleted',
                ]);
            } catch (\Throwable $e) {
                DB::rollBack();
                report($e);
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], empty($e->getCode()) ? 400 : $e->getCode());
            }
        }

    }

}
