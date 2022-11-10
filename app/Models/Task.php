<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    protected $fillable = ['task_name','status'];

//    public function todo(){
//        return $this->hasMany(Todo::class,'id','task_id');
//    }
}
