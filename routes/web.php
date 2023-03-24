<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\Admin\ForumController;
use App\Http\Controllers\Admin\ForumPostController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\MailController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\NotificationController;

use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\PagesController;
use App\Http\Controllers\Client\ClientUserController;
use App\Http\Controllers\Client\ClientBookController;
use App\Http\Controllers\Client\ClientChapterController;
use App\Http\Controllers\Client\ClientDocumentController;
use App\Http\Controllers\Client\ClientDashboard;
use App\Http\Controllers\Client\ClientForumPostController;
use App\Http\Controllers\Client\PDFController;

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
Route::get('/',[PagesController::class,'redirect_book_home_page']);
Route::get('/sach',[PagesController::class,'book_home_page']);
Route::get('/sach/all/{option?}',[PagesController::class,'book_page_more']);

Route::get('/tai-lieu',[PagesController::class,'document_home_page']);


    
Route::get("/sach/{book_id}/{book_slug}",[PagesController::class,'book_detail'])->where('book_id', '[0-9]+');
Route::get("/tai-lieu/{document_id}/{document_slug}",[PagesController::class,'document_detail'])->where('document_id', '[0-9]+');

Route::get("/tai-tai-lieu",[PagesController::class,'download_document']);

Route::get("/doc-sach/{book_slug}/{chapter_slug}",[PagesController::class,'read_book']);
Route::get("/sach-noi/{book_slug}/{chapter_slug}",[PagesController::class,'listening_book']);


Route::get("/tim-kiem",[PagesController::class,'search_name_page']);
Route::get("/tim-kiem-ket-qua",[PagesController::class,'search_name']);

Route::get("/the-loai/{option?}/{type_slug?}",[PagesController::class,'search_type_page']);
Route::get("/the-loai-ket-qua",[PagesController::class,'search_type_result']);

Route::get("/dien-dan",[PagesController::class,'forum_home_page']);
Route::get("/dien-dan/{forum_slug}",[PagesController::class,'forum_detail']);
Route::get("/dien-dan/{forum_slug}/{post_slug}/{post_id}",[PagesController::class,'post_detail']);

Route::get("/thanh-vien/{user_id}",[PagesController::class,'user_info']);

Route::get('/preview-document', [PagesController::class, 'preview_document']);

Route::post("/binh-luan",[PagesController::class,'user_comment']);
Route::post("/phan-hoi",[PagesController::class,'user_reply']);

Route::get("/xoa-binh-luan/{option}/{item_id}",[PagesController::class,'delete_user_comment']);
Route::get("/xoa-phan-hoi/{option}/{item_id}",[PagesController::class,'delete_reply_comment']);


Route::put("/cap-nhat-binh-luan/{item_id}",[PagesController::class,'edit_user_comment']);
Route::put("/cap-nhat-phan-hoi/{item_id}",[PagesController::class,'edit_user_reply']);
Route::post('/upload', [PagesController::class,'uploadCommentImage']);

Route::get("/notification-update",[NotificationController::class,'changeStatus']);
Route::get("/notification-all-update",[NotificationController::class,'changeAllStatus']);
Route::get("/bookmark-status-update-no-direct",[ClientBookController::class,'changeBookMarkStatus']);
Route::get("/bookmark-status-update",[NotificationController::class,'changeBookMarkStatus']);
Route::get("/bookmark-status-all-update",[NotificationController::class,'changeAllbookMarkStatus']);

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

    Route::get("/report",[ReportController::class,'index']);
    Route::get("/report/waiting",[ReportController::class,'report_wait_page']);
    Route::get("/report/done",[ReportController::class,'report_done_page']);
    Route::get("/report/update/changeStatus",[ReportController::class,'changeReportStatus']);
    Route::get("/report/detail",[ReportController::class,'detail']);

    Route::get("/user",[UserController::class,'index']);
    Route::get("/user/update/changeStatus",[UserController::class,'changeUserStatus']);
    Route::put("/user/{user_id}",[UserController::class,'update']);
    Route::get("/user/deleteUser",[UserController::class,'deleteUser']);
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
    Route::get("/tai-lieu/update/changeStatus",[ClientDocumentController::class,'changeDocumentStatus']);
    
});


//Client PAGE

Route::group(['middleware'=>['auth','isVerified']],function(){

    Route::resource('/profile', ProfileController::class,['except' => ['index','show','store','destroy','create','edit']]);
    Route::get("/trang-ca-nhan",[ProfileController::class,'index']);
    Route::put("/profile/changeAvatar/{profile_id}",[ProfileController::class,'changeAvatar']);
    
    Route::resource('/user',ClientUserController::class,['only' => ['update']]);
    Route::get("/doi-mat-khau",[ClientUserController::class,'changePassword']);
    Route::get('/them-tai-lieu',[PagesController::class,'post_navigation_page']);

    Route::get("/sach-theo-doi",[PagesController::class,'book_mark_page']);
    Route::post("/sach-theo-doi",[ClientBookController::class,'markBook']) ;
    Route::delete("/sach-theo-doi/{book_mark_id}",[ClientBookController::class,'removeMarkBook']);

    Route::post("/sach-danh-gia",[ClientBookController::class,'ratingBook']);

    
    Route::resource('/bai-viet', ClientForumPostController::class,['except' => ['create', 'edit','delete']]);

    Route::get("/cap-nhat-bai-viet/{forum_slug}/{forum_post_id}",[ClientForumPostController::class,'edit']);
    Route::get("/xoa-bai-viet",[ClientForumPostController::class,'detelePost']);

    Route::post("/bao-cao",[PagesController::class,'report_action']);
});




Route::group(['middleware' => ['auth','alreadyVerified']], function(){

    Route::get('/send-email', [MailController::class, 'sendMail']);
    Route::get('/verify-email', [MailController::class, 'verifyPage']);
    Route::post('/verify-email', [MailController::class, 'verifyEmail']);


});
// Route::get('/verify-success', [MailController::class, 'verifySucessPage']);



