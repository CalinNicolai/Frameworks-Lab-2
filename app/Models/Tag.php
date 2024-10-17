<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'created_at',
        'updated_at',
    ];

    public function tasks(){
        return $this->belongsToMany(Task::class, 'task_tag', 'tag_id', 'task_id');
    }
}
