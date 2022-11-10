<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
    protected $table = 'todos';
    protected $fillable = ['todo_name','task_id','image','date','is_checked','status'];

    public function task(){
        return $this->belongsTo(Task::class,'task_id','id');
    }
}
