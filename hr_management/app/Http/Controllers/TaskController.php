<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{

    //get project list
    public function getTaskList($pjId){
        $tasks = Task::where('project_id', $pjId)->get();

        $taskMembers = [];
        foreach($tasks as $task){
            $member = TaskMember::select('task_members.*', 'users.img as img')
                                ->where('task_id', $task->id)
                                ->leftJoin('users','users.id', 'task_members.user_id')
                                ->get();
            array_push($taskMembers, $member);
        }

        return response()->json([
            'tasks' => $tasks,
            'taskMembers' => $taskMembers,
            'status' => true
        ]);

    }

     //create project
    public function createTask(Request $request , $pjId){
        $this->Validation($request);

        $data = [
            'project_id' => $pjId,
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'priority' => $request->priority,
            'status' => $request->status
        ];

        $task = Task::create($data);

        foreach(($request->members ?? []) as $member){
            TaskMember::firstOrCreate([
            'task_id' =>$task->id,
            'user_id' => $member,
        ]);
        }

        return response()->json([
            'message' => 'Task successfully created!',
            'status' => true
        ]);

    }

    //get update data
    public function getUpdateTaskData($id){
        $task = Task::where('id', $id)->first();
        $taskMembers = TaskMember::where('task_id', $id)->get();

        return response()->json([
            'status' => true,
            'task' => $task,
            'taskMembers' => $taskMembers
        ]);
    }

    //update
    public function updateTask(Request $request){
         $this->Validation($request);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'priority' => $request->priority,
            'status' => $request->status
        ];

        Task::where('id', $request->id)->update($data);

        foreach(($request->members ?? []) as $member){
            TaskMember::firstOrCreate([
            'task_id' =>$request->id,
            'user_id' => $member,
        ]);
        }

        return response()->json([
            'message' => 'Task successfully updated!',
            'status' => true
        ]);
    }

     //delete project
    public function deleteTask($id){

        Task::where('id', $id)->delete();
        TaskMember::where('task_id', $id)->delete();

        $message = 'Task deleted successfully!';
        return response()->json($message);
    }

    //drag and change status
    public function dragTask($staus, $id){
        Task::where('id', $id)->update(['status' => $staus]);
        return response()->json(true);
    }

    //validate
    private function Validation($request){
        Validator::make($request->all(), [
            'title' => 'required' ,
            'description' => 'required',
            'members' => 'required',
            'start_date' => 'required',
            'deadline' => 'required',
            'priority' => 'required',

        ])->validate();
    }
}
