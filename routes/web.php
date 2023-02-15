<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ForumPostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource("/admin/book",BookController::class);
Route::get("/admin/book/update/changeStatus",[BookController::class,'changeBookStatus']);



Route::resource("/admin/book/chapter",ChapterController::class, ['except' => ['create', 'index']]);
Route::get("/admin/book/chapter/create/{book_id}",[ChapterController::class,'create'])->where('book_id', '[0-9]+');
// Route::get("/admin/chapter/all",[ChapterController::class,'index']);


Route::resource("/admin/forum",ForumController::class);
Route::get("/admin/forum/update/changeStatus",[ForumController::class,'changeForumStatus']);

Route::resource("/admin/forum/post",ForumPostController::class,['except' => ['create', 'index']]);
Route::get("/admin/forum/post/create/{forum_id}",[ForumPostController::class,'create'])->where('forum_id', '[0-9]+');


//Client PAGE
// Route::get("/forum",[PagesController::class,'index']);
// Route::get("/forum/{forum_slug}",[PagesController::class,'detail']);
Route::get("/forum/{forum_slug}/{forum_post_slug}",[PagesController::class,'read_post']);

    
Route::get("/",[PagesController::class,'index']);
Route::get("/{book_id}/{book_slug}",[PagesController::class,'detail'])->where('book_id', '[0-9]+');
Route::get("/read-book/{book_slug}/{chapter_slug}",[PagesController::class,'read_book']);



