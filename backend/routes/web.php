<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Task;
use Symfony\Component\HttpFoundation\Response;

// Redirect the root URL to the tasks index route.
Route::get('/', function () {
    return redirect()->route('tasks.index');
});

// Route to display all tasks.
Route::get('/tasks', function () {

    // Retrieve all tasks from the database using Eloquent ORM.
    $tasks = Task::latest()->get();

    // Return the view for displaying tasks, passing the tasks data.
    return view('index', ['tasks' => $tasks]);
})->name('tasks.index');

// Route to display the form for creating a new task.
Route::view('/tasks/create', 'create')->name('tasks.create');

// Route to display a single task based on its ID.
Route::get('/tasks/{id}', function ($id) {

    // Find the task by its ID using Eloquent ORM.
    $task = \App\Models\Task::findOrFail($id);

    // Return the view for displaying a single task, passing the task data.
    return view('show', ['task' => $task]);
})->name('tasks.show');

// Route to handle the submission of the new task form.
Route::post('/tasks', function (Request $request) {

    // Validate the incoming request data.
    $data = $request->validate([
        'title' => 'required|string|max:30',
        'description' => 'required|string',
        'long_description' => 'nullable|string',
    ]);

    // Create a new task using the validated data (Task Model's fillable property is used here).
    $task = Task::create($data);

    // Redirect to the tasks index route after successful creation.
    return redirect()->route('tasks.show', ['id' => $task->id]);
})->name('tasks.store');

// Fallback route to handle any undefined routes.
Route::fallback(function () {
    return 'This route does not exist';
});
