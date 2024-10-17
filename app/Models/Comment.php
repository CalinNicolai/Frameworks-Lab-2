<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'author_id', 'content'];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
