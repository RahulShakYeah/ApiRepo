<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = ['category_name','status'];

    public function blog(){
        return $this->hasMany(Blog::class,'category_id','id');
    }
}
