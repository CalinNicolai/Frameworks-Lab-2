@extends('layouts.app')

@section('body')
    <div class="container">
        <h1>Детали задачи</h1>

        <div class="app-info mt-5">
            <h2>Задача {{ $task['id'] }}</h2>
            <x-task
                :id="$task['id']"
                :title="$task['title']"
                :description="$task['description']"
                :createdAt="$task['created_at']"
                :category="$task->category"
                :tags="$tags"
                :updatedAt="$task['updated_at']"
                :status="$task['status'] ? 'Выполнена' : 'Не выполнена'"
                :priority="$task['priority']"
                :assignee="$task['assignee']"
            />
        </div>

        <div class="app-info mt-5">
            <form method="post" action="{{ route('tasks.comments.store', $task) }}">
                @csrf
                <div class="form-group">
                    <label for="content">Комментарий</label>
                    <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Отправить</button>
            </form>
        </div>

        <div class="app-info mt-5">
            <h2>Комментарии</h2>
            @if ($task->comments->isNotEmpty())
                @foreach ($task->comments as $comment)
                    <x-comment
                        :task="$task"
                        :comment="$comment"
                        :createdAt="$comment['created_at']"
                        :updatedAt="$comment['updated_at']"
                    />
                @endforeach
            @else
                <p>Комментариев нет</p>
            @endif
        </div>

        <a href="{{ route('tasks.index') }}" class="btn btn-back">Назад к списку задач</a>
    </div>
@endsection


@push('styles')
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .nav-links a {
            padding: 10px 20px;
            font-size: 16px;
        }

        .app-info {
            margin-top: 30px;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }

        p, li {
            font-size: 16px;
        }

        ul {
            list-style-type: disc;
            padding-left: 20px;
        }
    </style>
@endpush
