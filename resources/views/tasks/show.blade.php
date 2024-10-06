@extends('layouts.app')

@section('body')
    <div class="container">
        <h1>Детали задачи</h1>

        <div class="app-info mt-5">
            <h2>Последняя добавленная задача</h2>
            <x-task
                title="{{ $task['title'] }}"
                description="{{ $task['description'] }}"
                createdAt="{{ $task['created_at'] }}"
                updatedAt="{{ $task['updated_at'] }}"
                status="{{ $task['status'] ? 'Выполнена' : 'Не выполнена' }}"
                priority="{{ $task['priority'] }}"
                assignee="{{ $task['assignee'] }}"
            />
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
