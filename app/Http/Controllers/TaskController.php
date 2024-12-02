<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Task;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        $tags = Tag::all();

        return view('tasks.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTaskRequest $request)
    {
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);

        if ($request->has('tags')) {
            $task->tags()->attach($request->tags);
        }

        session()->flash('success', 'Task created successfully');
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $task = Task::with('category', 'tags', 'comments')->findOrFail($id);

        return view('tasks.show', [
            'task' => $task,
            'tags' => $task->tags
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $task = Task::with('category', 'tags')->findOrFail($id);

        $categories = Category::all();

        $tags = Tag::all();

        return view('tasks.edit', compact('task', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, int $id)
    {
        $task = Task::findOrFail($id);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);

        if ($request->has('tags')) {
            DB::transaction(function () use ($task, $request) {
                $currentTags = $task->tags->pluck('id')->toArray();

                if ($currentTags !== $request->tags) {
                    $task->tags()->sync($request->tags);
                }
            });
        }

        return redirect()->route('tasks.show', $task->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $task = Task::findOrFail($id);

        $task->delete();

        return redirect()->route('tasks.index');
    }
}
