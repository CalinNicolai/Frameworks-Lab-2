<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = [
            ['id' => 1, 'title' => 'Первая задача'],
            ['id' => 2, 'title' => 'Вторая задача'],
            ['id' => 3, 'title' => 'Третья задача'],
        ];

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $task = [
            'id' => $id,
            'title' => 'Название задачи',
            'description' => 'Описание задачи',
            'created_at' => '2024-10-01',
            'updated_at' => '2024-10-01',
            'status' => false,
            'priority' => 'Высокий',
            'assignee' => 'Имя исполнителя'
        ];

        return view('tasks.show', ['task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
