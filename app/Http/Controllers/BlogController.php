<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function addNewBlog(BlogRequest $request){
        $blog = new Blog();
        $blog->title = $request->get('title');
        $blog->description = $request->get('description');
        $blog->status = $request->get('status');
        $blog->category_id = $request->get('category_id');
        if($request->hasFile('image')){
            $file = $request->file('image');
            $path = public_path().'/image/blog/';
            $fileName = $file->hashName();
            $file->move($path,$fileName);
        }else{
            $fileName="noimg.jpg";
        }
        $blog->image = $fileName;
        $blog = $blog->save();
        if($blog){
            return response()->json(['status'=>true,'message' => 'Blog inserted successfully']);
        }else{
            return response()->json(['status'=>false,'message' => 'Something went wrong!Please try again later']);
        }
    }

    public function getAllBlog(){
        $blogs = Blog::with('category')->orderBy('created_at','DESC')->get();

        $mappedBlog = $blogs->map(function ($blogs,$keys){
            return [
                'id' => $blogs->id,
                'title' => $blogs->title,
                'description' => $blogs->description,
                'status' => $blogs->status,
                'image' => url('/')."/image/blog/".$blogs->image,
                'category_id' => $blogs->category_id,
                'category' => [
                    'category_id' => $blogs->category ? $blogs->category->id : null,
                    'category_name' => $blogs->category ? $blogs->category->category_name : null,
                    'status' => $blogs->category ? $blogs->category->status : null
                ],
            ];
        });
        return response()->json(['status'=>true,'message'=>'All blog fetched successfully','data'=>$mappedBlog]);
    }

    public function getActiveBlog(){
        $blogs = Blog::with('category')->where('status','active')->orderBy('created_at','DESC')->get();
        $mappedBlog = $blogs->map(function ($blogs,$keys){
            return [
                'id' => $blogs->id,
                'title' => $blogs->title,
                'description' => $blogs->description,
                'status' => $blogs->status,
                'image' => url('/')."/image/blog/".$blogs->image,
                'category_id' => $blogs->category_id,
                'category' => [
                    'category_id' => $blogs->category ? $blogs->category->id : null,
                    'category_name' => $blogs->category ? $blogs->category->category_name : null,
                    'status' => $blogs->category ? $blogs->category->status : null
                ],
            ];
        });
        return response()->json(['status'=>true,'message'=>'Active blog fetched successfully','data'=>$mappedBlog]);
    }

    public function getInactiveBlog(){
        $blogs = Blog::with('category')->where('status','inactive')->orderBy('created_at','DESC')->get();
        $mappedBlog = $blogs->map(function ($blogs,$keys){
            return [
                'id' => $blogs->id,
                'title' => $blogs->title,
                'description' => $blogs->description,
                'status' => $blogs->status,
                'image' => url('/')."/image/blog/".$blogs->image,
                'category_id' => $blogs->category_id,
                'category' => [
                    'category_id' => $blogs->category ? $blogs->category->id : null,
                    'category_name' => $blogs->category ? $blogs->category->category_name : null,
                    'status' => $blogs->category ? $blogs->category->status : null,
                ],
            ];
        });
        return response()->json(['status'=>true,'message'=>'Active blog fetched successfully','data'=>$mappedBlog]);
    }

    public function deleteBlog($id){
        $blog = Blog::findOrFail($id);
        if($blog->image){
            if(\File::exists(public_path().'/image/blog/'.$blog->image)){
                \File::delete(public_path().'/image/blog/'.$blog->image);
            }
        }
        $blog = $blog->delete();
        if($blog){
            return response()->json(['status'=>true,'message'=>'Blog deleted successfully']);
        }else{
            return response()->json(['status'=>false,'message' => 'Something went wrong!Please try again later']);
        }
    }

    public function updateBlog($id,BlogRequest $request){
        $blog = Blog::findOrFail($id);
        $blog->title = $request->get('title');
        $blog->description = $request->get('description');
        $blog->status = $request->get('status');
        if($request->hasFile('image')){
            if(\File::exists(public_path().'/image/blog/'.$blog->image)){
                \File::delete(public_path().'/image/blog/'.$blog->image);
            }

            $file = $request->file('image');
            $path = public_path().'/image/blog/';
            $fileNameToStore = $file->hashName();
            $file->move($path,$fileNameToStore);
        }else{
            $fileNameToStore = $blog->image;
        }
        $blog->category_id = $request->get('category_id');
        $blog->image = $fileNameToStore;
        $blog = $blog->save();
        if($blog){
            return response()->json(['status'=>true,'message'=>'Blog updated successfully']);
        }else{
            return response()->json(['status'=>false,'message' => 'Something went wrong!Please try again later']);
        }
    }

    public function getBlogDetails($id){
        $blog = Blog::findOrFail($id);
        return response()->json(['status' => true,'message' => 'Single blog data received successfully','data' => $blog]);
    }

    public function filterBlog($id){
        $blogs = Blog::where('category_id',$id)->where('status','active')->get();
        $mappedBlog = $blogs->map(function ($blogs,$keys){
            return [
                'id' => $blogs->id,
                'title' => $blogs->title,
                'description' => $blogs->description,
                'status' => $blogs->status,
                'image' => url('/')."/image/blog/".$blogs->image,
                'category_id' => $blogs->category_id,
                'category' => [
                    'category_id' => $blogs->category ? $blogs->category->id : null,
                    'category_name' => $blogs->category ? $blogs->category->category_name : null,
                    'status' => $blogs->category ? $blogs->category->status : null
                ],
            ];
        });
        return response()->json(['status'=>true,'message' => 'Filtered blog received successfully','data'=>$mappedBlog]);
    }
}
