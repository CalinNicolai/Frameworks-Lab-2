<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Task $task, Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        Comment::create([
            'content' => $request['content'],
            'task_id' => $task->id,
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task,Comment $comment)
    {
        $comment->delete();

        return redirect()->back();
    }
}
