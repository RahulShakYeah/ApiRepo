<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';
    protected $fillable = ['title','description','category_id','image','status'];

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
}
