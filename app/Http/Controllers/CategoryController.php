<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function addNewCategory(CategoryRequest $request){
        $category = new Category();
        $category->category_name = $request->get('category_name');
        $category->status = $request->get('status');
        $category = $category->save();
        if($category){
            return response()->json(['status'=>true,'message'=>'Category inserted successfully']);
        }else{
            return response()->json(['status'=>false,'message'=>'Something went wrong ! Please try again later']);
        }
    }

    public function getActiveCategory(){
        $categories = Category::where('status','active')->orderByDesc('created_at')->get();
        return response()->json(['status'=>true,'message'=>'Active Category fetched successfully','data'=>$categories]);
    }

    public function getInactiveCategory(){
        $categories = Category::where('status','inactive')->orderByDesc('created_at')->get();
        return response()->json(['status'=>true,'message'=>'Inactive Category fetched successfully','data'=>$categories]);
    }

    public function getAllCategories(){
        $categories = Category::orderByDesc('created_at')->get();
        return response()->json(['status'=>true,'message'=>'All Category fetched successfully','data'=>$categories]);
    }

    public function deleteCategory($id){
        $categoryInfo = $category = Category::findOrFail($id);
        $category = $category->delete();
        if($category){
            return response()->json(['status'=>true,'message'=>'Category deleted successfully','data'=>$categoryInfo]);
        }else{
            return response()->json(['status'=>false,'message'=>'Something went wrong ! Please try again later']);
        }
    }

    public function updateCategory(CategoryRequest $request,$id){
        $category = Category::findOrFail($id);
        $category->category_name = $request->get('category_name');
        $category->status = $request->get('status');
        $category = $category->save();
        if($category){
            return response()->json(['status'=>true,'message'=>'Category updated successfully']);
        }else{
            return response()->json(['status'=>false,'message'=>'Something went wrong ! Please try again later']);
        }
    }

    public function getCategoryDetails($id){
        $category = Category::findOrFail($id);
        return response()->json(['status' => true,'message'=>'Single category retrived successfully','data' => $category]);
    }
}
