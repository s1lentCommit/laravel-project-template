<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

// Define a simple Task class to represent a task entity.
class Task
{
  public function __construct(
    public int $id,
    public string $title,
    public string $description,
    public ?string $long_description,
    public bool $completed,
    public string $created_at,
    public string $updated_at
  ) {
  }
}

// Define an array of Task objects to simulate a database of tasks.
$tasks = [
  new Task(
    1,
    'Buy groceries',
    'Task 1 description',
    'Task 1 long description',
    false,
    '2023-03-01 12:00:00',
    '2023-03-01 12:00:00'
  ),
  new Task(
    2,
    'Sell old stuff',
    'Task 2 description',
    null,
    false,
    '2023-03-02 12:00:00',
    '2023-03-02 12:00:00'
  ),
  new Task(
    3,
    'Learn programming',
    'Task 3 description',
    'Task 3 long description',
    true,
    '2023-03-03 12:00:00',
    '2023-03-03 12:00:00'
  ),
  new Task(
    4,
    'Take dogs for a walk',
    'Task 4 description',
    null,
    false,
    '2023-03-04 12:00:00',
    '2023-03-04 12:00:00'
  ),
];

// Redirect the root URL to the tasks index route.
Route::get('/', function () {
    return redirect()->route('tasks.index');
});

// Route to display all tasks.
Route::get('/tasks', function ()  use($tasks){
    return view('index', [
        'tasks' => $tasks
    ]);
})->name('tasks.index');

// Route to display a single task based on its ID.
Route::get('/tasks/{id}', function ($id)  {

    // Find the task by its ID using Eloquent ORM.
    $task = \App\Models\Task::find($id);

    // Return the view for displaying a single task, passing the task data.
    return view('show', ['task' => $task]);
})->name('tasks.show');

// Fallback route to handle any undefined routes.
Route::fallback(function () {
    return 'This route does not exist';
});
