<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function store(TodoRequest $request){
        $todo = new Todo();
        $todo->todo_name = $request->get('todo_name');
        $todo->task_id = $request->get('task_id');
        $todo->status = $request->get('status');
        if($request->hasFile('image')){
            $file = $request->file('image');
            $path = public_path().'/image/todo/';
            $fileName = $file->hashName();
            $file->move($path,$fileName);
        }else{
            $fileName = null;
        }
        $todo->image = $fileName;
        $todo->date = $request->get('date');
        $todo->save();
        if($todo){
            return response()->json(['status'=>true,'message' => 'Todo saved successfully','data' => $todo]);
        }else{
            return response()->json(['status'=>true,'message'=>'Something went wrong|Please try again later']);
        }

    }

    public function getAllTodo(){
        $todos = Todo::with('task')->orderByDesc('created_at')->get();
        $mappedTodo = $todos->map(function($todo){
           return [
               'id' => $todo->id,
               'todo_name' => $todo->todo_name,
               'image' => $todo->image != null ? url('/').'/image/todo/'.$todo->image : '',
               'date' => $todo->date,
               'status' => $todo->status,
               'is_checked' => $todo->is_checked,
               'task' => [
                   'task_id' => $todo->task ? $todo->task->id : null,
                   'task_name' => $todo->task ? $todo->task->task_name : null,
                   'status' => $todo->task ? $todo->task->status :null
               ]
           ];
        });
        return response()->json(['status' => true,'message' => 'Todo fetched successfully','data' => $mappedTodo]);
    }

    public function getTodoAccordingTask(Request $request){
        $todos = Todo::where('task_id',$request->get('task_id'))->where('status','active')->get();
        return response()->json(['status'=>true,'message' => 'Todo fetched according to task completed','data' =>$todos]);
    }

    public function toggleTodo($id){
        $todo = Todo::findOrFail($id);
        $currentDate = Carbon::now();
        if($currentDate->gt($todo->date)){
            return response()->json(['status' => false,'message' => 'This task has been expired. Expiry Date : '.$todo->date,'data' => $todo]);
        }
        if($todo->is_checked == 0){
            $todo->is_checked = 1;
        }else{
            $todo->is_checked = 0;
        }
        $todo->save();
        return response()->json(['status'=>true,'message' => 'Todo toggled successfully','data' =>$todo]);

    }

    public function uploadImage(Request $request,$todoId){
        $todo = Todo::findOrFail($todoId);
        if($request->hasFile('image')){
            if($todo->image != null){
                if (\File::exists(public_path().'/image/todo/',$todo->image)){
                    \File::delete(public_path().'/image/todo/',$todo->image);
                }
            }

            $file = $request->file('image');
            $fileName = $file->hashName();
            $path = public_path().'/image/todo/';
            $file->move($path,$fileName);
        }else{
            $fileName = $todo->image;
        }
        $todo->image = $fileName;
        $todo->save();
        if($todo){
            return response()->json(['status'=>true,'message' => 'Image in todo saved successfully','data' => $todo]);
        }else{
            return response()->json(['status'=>true,'message'=>'Something went wrong|Please try again later']);
        }
    }
}
