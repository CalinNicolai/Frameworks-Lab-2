@extends('layouts.app')

@section('body')
    <div class="container">
        <h1>Список задач</h1>

        <ul class="task-list">
            @foreach ($tasks as $task)
                <li>
                    <a href="{{ route('tasks.show', $task['id']) }}">{{ $task['title'] }}</a>
                </li>
            @endforeach
        </ul>

        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Создать новую задачу</a>
    </div>
@endsection
