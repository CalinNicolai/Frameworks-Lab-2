@props(['title', 'description', 'createdAt', 'updatedAt', 'status', 'priority', 'assignee'])

<div class="task">
    <h2>{{ $title }}</h2>
    <p>{{ $description }}</p>
    <p><strong>Дата создания:</strong> {{ $createdAt }}</p>
    <p><strong>Дата обновления:</strong> {{ $updatedAt }}</p>
    <p><strong>Статус:</strong> {{ $status }}</p>
    <x-task-priority :priority="$priority" />
    <p><strong>Исполнитель:</strong> {{ $assignee }}</p>
    <div class="actions">
        <a href="#" class="btn btn-edit">Редактировать</a>
        <a href="#" class="btn btn-delete">Удалить</a>
    </div>
</div>
