@props(['task','comment', 'createdAt', 'updatedAt', 'author'])

<div class="comment">
    <h2>{{ $comment['content'] }}</h2>
    <p><strong>Дата создания:</strong> {{ $createdAt->format('d.m.Y H:i') }}</p>
    <p><strong>Дата обновления:</strong> {{ $updatedAt ? $updatedAt->format('d.m.Y H:i') : 'Не указана' }}</p>
    <form method="POST" action="{{ route('tasks.comments.destroy', ['task' => $task, 'comment' => $comment], ) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Удалить</button>
    </form>
</div>
