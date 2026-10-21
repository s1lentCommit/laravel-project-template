<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

// Redirect the root URL to the tasks index route.
Route::get('/', function () {
    return redirect()->route('tasks.index');
});

// Route to display all tasks.
Route::get('/tasks', function () {

    // Retrieve all tasks from the database using Eloquent ORM.
    $tasks = \App\Models\Task::latest()->get();

    return view('index', [
        'tasks' => $tasks
    ]);
})->name('tasks.index');

// Route to display a single task based on its ID.
Route::get('/tasks/{id}', function ($id) {

    // Find the task by its ID using Eloquent ORM.
    $task = \App\Models\Task::findOrFail($id);

    // Return the view for displaying a single task, passing the task data.
    return view('show', ['task' => $task]);
})->name('tasks.show');

// Fallback route to handle any undefined routes.
Route::fallback(function () {
    return 'This route does not exist';
});
