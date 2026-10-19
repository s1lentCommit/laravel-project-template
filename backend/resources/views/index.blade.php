@extends('layouts.app')

@section('title', 'The list of tasks')


@section('content')
    @if (count($tasks) > 0)
        <h2>There are {{ count($tasks) }} tasks:</h2>
    @endif

    @forelse($tasks as $task)
        <a href="{{ route('tasks.show', ['id' => $task->id]) }}">
            <div>
                <h3>{{ $task->title }}</h3>
            </div>
        </a>
    @empty
        <div>There are no tasks</div>
    @endforelse
@endsection
