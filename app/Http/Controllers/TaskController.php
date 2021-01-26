<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Task::myTasks()->orderBy('priority', 'desc')->get();
        return view('tasks.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        if (Auth::user()->hasAnyRole(['admin', 'simple'])) {
            $priorities = config('config_file.priorities');

            return view('tasks.create', compact('priorities'));

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
            'priority' => 'bail|required|integer'
        ]);

        if (Auth::user()->hasAnyRole(['admin', 'simple'])) {
            try {
                DB::beginTransaction();
                $request->merge(['user_id' => Auth::user()->id]);
                Task::create($request->all());
                DB::commit();
                return redirect()->route('task_index');
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
        if (Auth::user()->hasAnyRole(['admin', 'simple'])) {
            $item = Task::findOrFail($id);
            $priorities = config('config_file.priorities');

            return view('tasks.edit', compact('item', 'priorities'));

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
            'priority' => 'bail|required|integer'
        ]);

        if (Auth::user()->hasAnyRole(['admin', 'simple'])) {
            try {
                $item = Task::findOrFail($id);
                DB::beginTransaction();
                $item->update($request->all());
                DB::commit();
                return redirect()->route('task_index');
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
        if (Auth::user()->hasAnyRole(['admin', 'simple'])) {
            DB::beginTransaction();
            try {
                $item = Task::findOrFail($id);
                $item->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Task successfully deleted',
                ]);
            } catch (\Exception $e) {
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
