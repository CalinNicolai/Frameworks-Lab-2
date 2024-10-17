<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Task;
use Database\Factories\TaskFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::factory()->count(20)->create()->each(function (Task $task) {
            $tags = Tag::all()->random(3);
            $task->tags()->attach($tags);
        });
    }
}
