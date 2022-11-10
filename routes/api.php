<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TodoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Category Routes
Route::post('/add-new-category',[CategoryController::class,'addNewCategory']);
Route::get('/get-all-active-category',[CategoryController::class,'getActiveCategory']);
Route::get('/get-all-inactive-category',[CategoryController::class,'getInactiveCategory']);
Route::get('/get-all-category',[CategoryController::class,'getAllCategories']);
Route::delete('/delete-category/{categoryId}',[CategoryController::class,'deleteCategory']);
Route::patch('/category-update/{categoryId}',[CategoryController::class,'updateCategory']);
Route::get('/get-category-details/{categoryId}',[CategoryController::class,'getCategoryDetails']);

//Blog Routes
Route::post('/add-blog',[BlogController::class,'addNewBlog']);
Route::get('/get-all-blog',[BlogController::class,'getAllBlog']);
Route::get('/get-active-blog',[BlogController::class,'getActiveBlog']);
Route::get('/get-inactive-blog',[BlogController::class,'getInactiveBlog']);
Route::delete('/delete-blog/{blogId}',[BlogController::class,'deleteBlog']);
Route::patch('/update-blog/{blogId}',[BlogController::class,'updateBlog']);
Route::get('/get-blog-details/{blogId}',[BlogController::class,'getBlogDetails']);
Route::get('/filter-blog/{categoryId}',[BlogController::class,'filterBlog']);

//Contact Routes
Route::post('/add-contact',[ContactController::class,'createContact']);
Route::get('/get-all-contact',[ContactController::class,'getAllContacts']);
Route::delete('/delete-contact/{contactId}',[ContactController::class,'deleteContact']);


/*********************************Todo_Application_Routes**********************************************/
//Task Routes
Route::post('/add/task',[TaskController::class,'createTask']);
Route::delete('/delete/task/{taskId}',[TaskController::class,'deleteTask']);
Route::get('/getAll/task',[TaskController::class,'getAllTask']);
Route::patch('/update/task/{taskId}',[TaskController::class,'updateTask']);
Route::get('/filter/task',[TaskController::class,'filterTask']);

//Todo Routes
Route::post('/add/todo',[TodoController::class,'store']);
Route::get('/getAll/todo',[TodoController::class,'getAllTodo']);
Route::get('/get/todo/todo',[TodoController::class,'getTodoAccordingTask']);
Route::post('/toggle/todo/{todoId}',[TodoController::class,'toggleTodo']);
Route::post('/uploadImage/{todoId}',[TodoController::class,'uploadImage']);


