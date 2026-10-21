@extends('layouts.app')

@section('title', 'The list of tasks')

@section('content')
    @if (count($tasks) > 0)
        <h2>There are {{ count($tasks) }} tasks:</h2>

        <ol>
            @foreach ($tasks as $task)
                <li>
                    <a href="{{ route('tasks.show', ['id' => $task->id]) }}">
                        {{ $task->title }}
                    </a>
                </li>
            @endforeach
        </ol>
    @else
        <div>There are no tasks</div>
    @endif
@endsection
