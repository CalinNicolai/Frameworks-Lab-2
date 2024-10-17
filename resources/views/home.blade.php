<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('pageTitle', 'Главная страница')

@section('body')
    <div class="container">
        <!-- Приветственное сообщение -->
        <h1 class="mt-5 text-center">Добро пожаловать в To-Do App для команд</h1>
        <p class="text-center">Простое и удобное приложение для управления задачами в командах.</p>

        <!-- Навигация -->
        <div class="nav-links text-center mt-4">
            <a href="{{ route('tasks.index') }}" class="btn btn-primary mx-2">Список задач</a>
            <a href="{{ route('tasks.create') }}" class="btn btn-secondary mx-2">Создание задачи</a>
        </div>

        <!-- Информация о приложении -->
        <div class="app-info mt-5">
            <h2>Информация о приложении</h2>
            <p>
                Наше приложение To-Do App помогает командам управлять задачами, отслеживать прогресс и эффективно работать
                над проектами. Основные функции приложения включают:
            </p>
            <ul>
                <li>Создание и редактирование задач;</li>
                <li>Отслеживание выполненных и оставшихся задач;</li>
                <li>Работа в командах и совместное использование задач.</li>
            </ul>
        </div>

        <div class="app-info mt-5">
            <h2>Последняя добавленная задача</h2>
            <x-task
                :id="$lastTask['id']"
                :title="$lastTask['title']"
                :description="$lastTask['description']"
                :createdAt="$lastTask['created_at']"
                :category="$lastTask->category"
                :tags="$lastTask->tags"
                :updatedAt="$lastTask['updated_at']"
                :status="$lastTask['status'] ? 'Выполнена' : 'Не выполнена'"
                :priority="$lastTask['priority']"
                :assignee="$lastTask['assignee']"
            />
        </div>
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
