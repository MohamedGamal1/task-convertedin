<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Repositories\Task\TaskRepository as TaskRepository;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{

    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index()
    {
        try {
            $tasks = $this->taskRepository->index();
            return view('tasks.tasks', compact('tasks'));
        } catch (Exception $e) {
            return redirect('/dashboard')->with('message', 'something happen please try again ');
        }
    }

    public function create_task()
    {
        try {
            $data =  $this->taskRepository->create_task();
            return view('tasks.createTask', compact('data'));
        } catch (Exception $e) {
            return redirect('/tasks')->with('message', 'something happen please try again ');
        }
    }


    public function store_task(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required|min:5',
            'assigned_by_id' => 'required|int',
            'assigned_to_id' => 'required|int',
        ]);
        $data_request  =$request->all() ;
        try {
            if ($validator->fails()){
                return redirect()->back()->withErrors($validator->errors());
            }else{
                $task =  $this->taskRepository->store_task($data_request);
                if ($task)
                    return redirect('/tasks')->with(['message'=> ' Task Added Successfully' ]);
            }
        } catch (Exception $e) {
            return redirect('/tasks');
        }

    }

    public function statistics()
    {
        try {
            $statistics =  $this->taskRepository->statistics();
            return view('tasks.statistics', compact('statistics'));
        } catch (Exception $e) {
            return redirect('/dashboard');
        }
    }

}
