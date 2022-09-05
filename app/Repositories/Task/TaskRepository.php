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
        return $this->model
            ->leftJoin('users', 'tasks.assigned_by_id', '=', 'users.id')
            ->leftJoin('users as userName', 'tasks.assigned_to_id', '=', 'userName.id')
            ->select('tasks.title', 'tasks.description', 'users.name as admin_name', 'userName.name as user_name')
            ->paginate(10);
    }

    public function create_task()
    {
        $data = [];
        $data['users'] = User::where('is_admin', 0)->get();
        $data['admins'] = User::where('is_admin', 1)->get();
        return $data;

    }


    public function store_task($data)
    {
        return $this->model->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'assigned_by_id' => $data['assigned_by_id'],
            'assigned_to_id' => $data['assigned_to_id'],
        ]);

    }

    public function statistics()
    {
        return$this->model
                ->leftJoin('users as user', 'tasks.assigned_to_id', '=', 'user.id')
                ->select(DB::raw('count(assigned_to_id) as task_counts'))
                ->addSelect('tasks.assigned_to_id')
                ->addSelect('user.name')
                ->groupBy('tasks.assigned_to_id')
                ->groupBy('user.name')
                ->orderByDesc('task_counts')
                ->limit('10')
                ->get();
    }

    function model(): string
    {
        return "App\Models\Task";
    }


}
