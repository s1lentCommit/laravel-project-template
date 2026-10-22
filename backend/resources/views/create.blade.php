@extends('layouts.app')

@section('title', 'Add Task')

@section('content')
    <h2>Add a new task</h2>

    {{ $errors }}

    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf
        <div>
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required>
        </div>

        <div>
            <label for="description">Description:</label>
            <textarea name="description" id="description" rows="5" required></textarea>
        </div>

        <div>
            <label for="long_description">Long Description:</label>
            <textarea name="long_description" id="long_description" rows="10"></textarea>
        </div>

        <div>
            <button type="submit">Add Task</button>
        </div>
    </form>
@endsection
