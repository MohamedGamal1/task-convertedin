<?php


namespace App\Repositories\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Prettus\Repository\Eloquent\BaseRepository;

class TaskRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */


    public function index()
    {
        $data = DB::table('tasks')
            ->leftJoin('users', 'tasks.assigned_by_id', '=', 'users.id')
            ->leftJoin('users as userName', 'tasks.assigned_to_id', '=', 'userName.id')
            ->select('tasks.title', 'tasks.description', 'users.name as admin_name','userName.name as user_name')
            ->paginate(10);

        return view('tasks.tasks', compact('data'));
    }

    public function create_task()
    {
        $users = User::where('is_admin', 0)->get();
        $admins = User::where('is_admin', 1)->get();
        var_dump(count($admins));exit();
        return view('tasks.createTask', compact('users', 'admins'));
    }


    public function store_task(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'min:2'],
            'description' => ['required', 'string', 'min:5'],
            'assigned_by_id' => ['required', 'int'],
            'assigned_to_id' => ['required', 'int'],
        ]);
        try {
            $user = $this->model->create([
                'title' => $request->title,
                'description' => $request->description,
                'assigned_by_id' => $request->assigned_by_id,
                'assigned_to_id' => $request->assigned_to_id,
            ]);
            if ($user)
                return redirect('/tasks')->with('message', 'Task Assigned Successfully ');
        } catch (Exception $e) {
            return redirect()->back()->with('message', 'SomeThing Is Wrong');
        }

    }
    public function statistics()
    {
        try {
            $data = DB::table('tasks')
                ->leftJoin('users as user', 'tasks.assigned_to_id', '=', 'user.id')
                ->select(DB::raw('count(assigned_to_id) as task_counts'))
                ->addSelect('tasks.assigned_to_id')
                ->addSelect('user.name')
                ->groupBy('tasks.assigned_to_id')
                ->groupBy('user.name')
                ->orderByDesc('task_counts')
                ->limit('10')
                ->get();
            return view('tasks.statistics', compact('data'));
        } catch (Exception $e) {
            return redirect()->back()->with('message', 'SomeThing Is Wrong');
        }


    }

    function model(): string
    {
        return "App\Models\Task";
    }




}
