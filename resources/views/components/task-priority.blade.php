@props(['priority'])

<div>
    @if ($priority === 'low')
        <span class="badge bg-success">Низкий</span>
    @elseif ($priority === 'medium')
        <span class="badge bg-warning">Средний</span>
    @elseif ($priority === 'high')
        <span class="badge bg-danger">Высокий</span>
    @endif
</div>
