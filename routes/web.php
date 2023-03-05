<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\Admin\ForumController;
use App\Http\Controllers\Admin\ForumPostController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\MailController;

use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\PagesController;
use App\Http\Controllers\Client\UserController;
use App\Http\Controllers\Client\ClientBookController;
use App\Http\Controllers\Client\ClientChapterController;
use App\Http\Controllers\Client\ClientDocumentController;
use App\Http\Controllers\Client\ClientDashboard;

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
Route::get('/',[PagesController::class,'index'])->name('home');

Auth::routes();


Route::group(['prefix' => 'admin',  'middleware' => ['auth','isAdmin','isVerified']], function()
{
    Route::get('/dashboard',[DashboardController::class,'index']);
    //All the routes that belongs to the group goes here
    Route::resource("/book",BookController::class);
    Route::get("/book/update/changeStatus",[BookController::class,'changeBookStatus']);
    
    
    
    Route::resource("/book/chapter",ChapterController::class, ['except' => ['create', 'index']]);
    Route::get("/book/chapter/create/{book_id}",[ChapterController::class,'create'])->where('book_id', '[0-9]+');
    Route::get("/chapter",[ChapterController::class,'index']);
    
    
    Route::resource("/forum",ForumController::class);
    Route::get("/forum/update/changeStatus",[ForumController::class,'changeForumStatus']);
    

    Route::resource("/document",DocumentController::class);
    Route::get("/document/update/changeStatus",[DocumentController::class,'changeDocumentStatus']);
    
    Route::resource("/forum/post",ForumPostController::class,['except' => ['create', 'index']]);
    Route::get("/forum/post/create/{forum_id}",[ForumPostController::class,'create'])->where('forum_id', '[0-9]+');
    Route::get("/post",[ForumPostController::class,'index']);

    
});

Route::group(['prefix' => 'quan-ly',  'middleware' => ['auth','isVerified']], function()
{

    Route::get("/",[ClientDashboard::class,'index']);
    Route::resource("/sach",ClientBookController::class,['except' => ['create','edit']]);
    Route::get("/them-sach",[ClientBookController::class,'create']);
    Route::get("/cap-nhat-sach/{book_id}",[ClientBookController::class,'edit']);
    Route::get("/sach/update/changeStatus",[ClientBookController::class,'changeBookStatus']);
    

    Route::resource("/chuong",ClientChapterController::class, ['except' => ['create', 'index','edit']]);
    Route::get("/them-chuong/{book_id}",[ClientChapterController::class,'create'])->where('book_id', '[0-9]+');
    Route::get("/cap-nhat-chuong/{chuong_id}",[ClientChapterController::class,'edit']);


    Route::resource("/tai-lieu",ClientDocumentController::class,['except' => ['create','edit']]);
    Route::get("/them-tai-lieu",[ClientDocumentController::class,'create']);
    Route::get("/cap-nhat-tai-lieu/{book_id}",[ClientDocumentController::class,'edit']);
    Route::get("/tai-lieu/update/changeStatus",[ClientDocumentController::class,'changeBookStatus']);
    
});


//Client PAGE


Route::resource('/profile', ProfileController::class,['except' => ['index','show','store','destroy','create','edit']]);
Route::get("/trang-ca-nhan",[ProfileController::class,'index']);
Route::put("/profile/changeAvatar/{profile_id}",[ProfileController::class,'changeAvatar']);

Route::resource('/user',UserController::class,['only' => ['update']]);
Route::get("/doi-mat-khau",[UserController::class,'changePassword']);


// Route::get("/forum",[PagesController::class,'index']);
// Route::get("/forum/{forum_slug}",[PagesController::class,'detail']);

Route::get('/them-tai-lieu',[PagesController::class,'post_navigation_page'])->middleware('auth','isVerified');

// Route::get("/dien-dan/{forum_slug}/{forum_post_slug}",[PagesController::class,'read_post']);

    
Route::get("/{book_id}/{book_slug}",[PagesController::class,'detail'])->where('book_id', '[0-9]+');
Route::get("/doc-sach/{book_slug}/{chapter_slug}",[PagesController::class,'read_book']);


Route::group(['middleware' => ['auth','alreadyVerified']], function(){

    Route::get('/send-email', [MailController::class, 'sendMail']);
    Route::get('/verify-email', [MailController::class, 'verifyPage']);
    Route::post('/verify-email', [MailController::class, 'verifyEmail']);


});


