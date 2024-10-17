@props(['id','title', 'description', 'createdAt', 'updatedAt', 'status', 'priority', 'assignee', 'category', 'tags'])

<div class="task">
    <h2>{{ $title }}</h2>
    <p>{{ $description }}</p>
    <p><strong>Категория:</strong> {{ $category->name ?? 'Не указана' }}</p>
    <p><strong>Теги:</strong>
        @if($tags && $tags->isNotEmpty())
            @foreach ($tags as $tag)
                <span class="tag">{{ $tag->name }}</span>,
            @endforeach
        @else
            <span class="tag">Отсутствуют</span>
        @endif
    </p>
    <p><strong>Дата создания:</strong> {{ $createdAt->format('d.m.Y H:i') }}</p>
    <p><strong>Дата обновления:</strong> {{ $updatedAt ? $updatedAt->format('d.m.Y H:i') : 'Не указана' }}</p>
    <p><strong>Статус:</strong> {{ $status }}</p>
    <x-task-priority :priority="$priority"/>
    <p><strong>Исполнитель:</strong> {{ $assignee }}</p>
    <div class="actions">
        <a href="{{ route('tasks.edit', $id) }}" class="btn btn-primary">Редактировать</a>
        <form action="{{ route('tasks.destroy', $id) }}" method="POST" class="d-inline-block">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger">Удалить
            </button>
        </form>
    </div>
</div>
