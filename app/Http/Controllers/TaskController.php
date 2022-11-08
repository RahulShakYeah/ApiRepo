<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function createTask(TaskRequest $request){
        $task = new Task();
        $task->task_name = $request->get('task_name');
        $task->status = $request->get('status');
        $task->save();
        if($task){
            return response()->json(['status' => true,'message' => 'Task save successfully','data' => $task]);
        }else{
            return response()->json(['status' => false,'message' => 'Something went wrong!Please try again later','data' => $task]);
        }
    }

    public function deleteTask($id){
        $task = Task::findOrFail($id);
        $task->delete();
        if($task){
            return response()->json(['status' => true,'message' => 'Task deleted successfully','data' => $task]);
        }else{
            return response()->json(['status' => false,'message' => 'Something went wrong!Please try again later','data' => $task]);
        }
    }

    public function getAllTask(){
        $task = Task::orderByDesc('created_at')->get();
        return response()->json(['status'=>true,'message' => 'Task fetched successfully','data' => $task]);
    }

    public function updateTask($id,TaskRequest $request){
        $task = Task::findOrFail($id);
        $task->task_name = $request->get('task_name');
        $task->status = $request->get('status');
        $task->save();
        if($task){
            return response()->json(['status' => true,'message' => 'Task updated successfully','data' => $task]);
        }else{
            return response()->json(['status' => false,'message' => 'Something went wrong!Please try again later','data' => $task]);
        }
    }

    public function filterTask(Request $request){
        $task = Task::where('task_name',$request->data)->orWhere('status',$request->data)->get();
        return response()->json(['status'=>true,'message' => 'Task filtered successfully','data' =>$task]);
    }

    public function test(){
        dd('ok');
    }
}
