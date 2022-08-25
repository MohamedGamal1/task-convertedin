<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use  App\Repositories\Task\TaskRepository as TaskRepository;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{

    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index()
    {

        return $this->taskRepository->index();
    }

    public function create_task()
    {
        return $this->taskRepository->create_task();
    }

    public function store_task(Request $request)
    {
        return $this->taskRepository->store_task($request);
    }

    public function statistics()
    {
        return $this->taskRepository->statistics();
    }

}
