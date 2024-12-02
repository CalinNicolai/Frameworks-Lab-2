@extends('layouts.app')

@section('body')
    <div class="container">
        <h1>Создать новую задачу</h1>

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf  <!-- Для защиты от CSRF-атак -->

            <div class="form-group">
                <label for="title">Название задачи</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                @error('title')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Описание задачи</label>
                <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                @error('description')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="category">Категория</label>
                <select name="category_id" id="category" class="form-control" required>
                    <option value="">Выберите категорию</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tags">Теги</label>
                <select name="tags[]" id="tags" class="form-control" multiple>
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" {{ collect(old('tags'))->contains($tag->id) ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Удерживайте Ctrl (или Command на Mac), чтобы выбрать несколько тегов.</small>
                @error('tags')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Создать задачу</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Назад к списку задач</a>
        </form>
    </div>
@endsection

@push('styles')
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 20px;
        }
    </style>
@endpush
