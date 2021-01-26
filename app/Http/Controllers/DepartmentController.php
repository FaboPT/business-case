<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Department::all();
        return view('departments.index', compact('items'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->hasRole('admin')) {
            return view('departments.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|string|max:255',
            'description' => 'bail|nullable|string|max:5000',
        ]);

        if (Auth::user()->hasRole('admin')) {
            try {
                DB::beginTransaction();
                Department::create($request->all());
                DB::commit();
                return redirect()->route('department_index');
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
            $item = findOrFail($id);

            return view('departments.edit', compact('item'));
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
        $request->validate([
            'name' => 'bail|required|string|max:255',
            'description' => 'bail|nullable|string|max:5000',
        ]);

        if (Auth::user()->hasRole('admin')) {
            try {
                $item = Department::findOrFail($id);
                DB::beginTransaction();
                $item->update($request->all());
                DB::commit();
                return redirect()->route('department_index');
            } catch (\Throwable $e) {
                DB::rollBack();
                report($e);
                return back()->withInput();
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
                $item = Department::findOrFail($id);
                $item->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Department successfully deleted',
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                report($e);
                return response()->json([
                    'success' => false,
                    "error" => [
                        'code' => $e->getCode(),
                        'message' => $e->getMessage(),
                    ],
                ], empty($e->getCode()) ? 400 : $e->getCode());
            }
        }
    }
}
