<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\Admin\ForumController;
use App\Http\Controllers\Admin\ForumPostController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\MailController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\CommentController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\PagesController;
use App\Http\Controllers\Client\ClientUserController;
use App\Http\Controllers\Client\ClientBookController;
use App\Http\Controllers\Client\ClientChapterController;
use App\Http\Controllers\Client\ClientDocumentController;
use App\Http\Controllers\Client\ClientDashboard;
use App\Http\Controllers\Client\ClientForumPostController;
use App\Http\Controllers\Client\ClientCommentController;

use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Client\ClientFollowController;
use App\Http\Controllers\Client\LikeController;

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
Route::group(['middleware' => ['isVerified']],function(){
    

// Route::get('/summarizeText',[PagesController::class,'summarizeText']);
// Route::get('/getKeywords',[PagesController::class,'getKeywords']);

// Route::get("/tom-tat-tai-lieu",[PagesController::class,'summarizePage']);


Route::get('/',[PagesController::class,'home_page']);

Route::get('/sach/all/{option?}',[PagesController::class,'book_page_more']);
Route::get('/tai-lieu/all/{option?}',[PagesController::class,'document_page_more']);




    
Route::get("/sach/{book_id}/{book_slug}",[PagesController::class,'book_detail'])->where('book_id', '[0-9]+');
Route::get("/tai-lieu/{document_id}/{document_slug}",[PagesController::class,'document_detail'])->where('document_id', '[0-9]+');


Route::get("/generation-link",[PagesController::class,'generate_link_download']);
Route::get("/tai-lieu/download",[PagesController::class,'download_document_page'])->name('tai-lieu.download');
Route::get("/tai-tai-lieu",[PagesController::class,'download_document']);


 
Route::get("/doc-sach/{book_slug}/{chapter_slug}",[PagesController::class,'read_book']);
Route::get("/sach-noi/{book_slug}/{chapter_slug}",[PagesController::class,'listening_book']);


Route::get("/tim-kiem",[PagesController::class,'search_name_page']);
Route::get("/tim-kiem-ket-qua",[PagesController::class,'search_name']);

Route::get("/the-loai/{option?}/{type_slug?}",[PagesController::class,'search_type_page']);
Route::get("/tac-gia/{option}/{author}",[PagesController::class,'search_author_page']);
Route::get("/ngon-ngu/{option}/{language}",[PagesController::class,'search_language_page']);
Route::get("/tinh-trang/{option}/{isCompleted}",[PagesController::class,'search_status_page']);

Route::get("/dien-dan",[PagesController::class,'forum_home_page']);
Route::get("/dien-dan/bai-viet/{topic}",[PagesController::class,'forum_search_page']);
Route::get("/dien-dan/{forum_slug}/",[PagesController::class,'forum_detail']);
Route::get("/dien-dan/{forum_slug}/all/{type_slug?}",[PagesController::class,'forum_detail_filter']);

Route::get("/dien-dan/{forum_slug}/{post_slug}/{post_id}",[PagesController::class,'post_detail']);

Route::get("/thanh-vien/{user_id}",[ProfileController::class,'user_info']);

Route::get('/preview-document', [PagesController::class, 'preview_document']);

Route::post("/binh-luan",[ClientCommentController::class,'user_comment']);
Route::post("/phan-hoi",[ClientCommentController::class,'user_reply']);

Route::get("/xoa-binh-luan/{item_id}",[ClientCommentController::class,'delete_user_comment']);
Route::get("/xoa-phan-hoi/{item_id}",[ClientCommentController::class,'delete_reply_comment']);


Route::put("/cap-nhat-binh-luan/{item_id}",[ClientCommentController::class,'edit_user_comment']);
Route::put("/cap-nhat-phan-hoi/{item_id}",[ClientCommentController::class,'edit_user_reply']);
Route::post('/upload', [ClientCommentController::class,'uploadCommentImage']);

Route::get("/notification-update",[NotificationController::class,'changeStatus']);
Route::get("/notification-all-update",[NotificationController::class,'changeAllStatus']);
Route::get("/following-status-update-no-direct",[ClientBookController::class,'changeFollowStatus']);
Route::get("/following-status-update",[NotificationController::class,'changeFollowStatus']);
Route::get("/following-status-all-update",[NotificationController::class,'changeAllFollowStatus']);




Route::group(['prefix' => 'admin',  'middleware' => ['auth','isAdmin']], function()
{
    Route::get('/wait-verification',[DashboardController::class,'wait_verification']);
    Route::get("/wait-verification/update/changeStatus/verification",[DashboardController::class,'verification_item']);
    Route::get("/wait-verification/update/changeStatus/rejection",[DashboardController::class,'rejection_item']);

    Route::get('/dashboard',[DashboardController::class,'index']);
    Route::get('/dashboard/get/LoginHistory',[DashboardController::class,'getLoginHistory']);

    Route::get('/calendar',[NoteController::class,'calendar_page']);
    Route::get('/getObject',[NoteController::class,'getObject']);
    Route::post('/create-note',[NoteController::class,'create']);


   

    //All the routes that belongs to the group goes here
    Route::resource("/book",BookController::class,['except' => ['destroy','show']]);
    Route::get("/book/detail/{id}/{year?}",[BookController::class,'show']);

    Route::get("/statistics/book/{year?}",[BookController::class,'statistics_book_page']);
    Route::get("/deleted/book",[BookController::class,'deletedItem']);
    Route::get("/deleted/book/filter/{fromDate}/{toDate}",[BookController::class,'getFilterValueDeleted']);

    Route::get("/deleted/book/recovery",[BookController::class,'recoveryItem']);

    Route::get("/book/customDelete/{book_id}",[BookController::class,'customDelete']);
    Route::get("/book/update/changeStatus",[BookController::class,'changeBookStatus']);
    Route::get("/book/filter/{fromDate}/{toDate}",[BookController::class,'getFilterValue']);

    
    Route::resource("/book/chapter",ChapterController::class, ['except' => ['create', 'index','destroy']]);
    Route::get("/book/chapter/{book_id}/filter/{fromDate}/{toDate}",[ChapterController::class,'getFilterValueShow']);

    Route::get("/statistics/chapter/{year?}",[ChapterController::class,'statistics_chapter_page']);

    Route::get("/book/chapter/customDelete/{chapter_id}",[ChapterController::class,'customDelete']);
    Route::get("/book/chapter/create/{book_id}",[ChapterController::class,'create'])->where('book_id', '[0-9]+');
    Route::get("/chapter",[ChapterController::class,'index']);
    Route::get("/deleted/chapter",[ChapterController::class,'deletedItem']);
    Route::get("/deleted/chapter/filter/{fromDate}/{toDate}",[ChapterController::class,'getFilterValueDeleted']);

    Route::get("/deleted/chapter/recovery",[ChapterController::class,'recoveryItem']);
    Route::get("/chapter/filter/{fromDate}/{toDate}",[ChapterController::class,'getFilterValue']);

    Route::resource("/forum",ForumController::class,['except' => ['destroy']]);
    Route::get("/forum/customDelete/{forum_id}",[ForumController::class,'customDelete']);
    Route::get("/forum/update/changeStatus",[ForumController::class,'changeForumStatus']);
    

    Route::resource("/document",DocumentController::class,['except' => ['destroy','show']]);
    Route::get("/document/detail/{id}/{year?}",[DocumentController::class,'show']);

    Route::get("/deleted/document",[DocumentController::class,'deletedItem']);
    Route::get("/deleted/document/filter/{fromDate}/{toDate}",[DocumentController::class,'getFilterValueDeleted']);

    Route::get("/deleted/document/recovery",[DocumentController::class,'recoveryItem']);

    Route::get("/statistics/document/{year?}",[DocumentController::class,'statistics_document_page']);

    Route::get("/document/customDelete/{document_id}",[DocumentController::class,'customDelete']);

    Route::get("/document/update/changeStatus",[DocumentController::class,'changeDocumentStatus']);
    Route::get("/document/filter/{fromDate}/{toDate}",[DocumentController::class,'getFilterValue']);

    Route::resource("/forum/post",ForumPostController::class,['except' => ['create', 'index','destroy']]);
    Route::get("/forum/post/{post_id}/detail",[ForumPostController::class,'detail']);
    Route::get("/forum/post/{forum_id}/filter/{fromDate}/{toDate}",[ForumPostController::class,'getFilterValueShow']);

    Route::get("/deleted/post",[ForumPostController::class,'deletedItem']);
    Route::get("/deleted/post/filter/{fromDate}/{toDate}",[ForumPostController::class,'getFilterValueDeleted']);

    Route::get("/deleted/post/recovery",[ForumPostController::class,'recoveryItem']);
    Route::get("/statistics/post/{year?}",[ForumPostController::class,'statistics_post_page']);

    Route::get("/forum/post/customDelete/{post_id}",[ForumPostController::class,'customDelete']);

    Route::get("/forum/post/create/{forum_id}",[ForumPostController::class,'create'])->where('forum_id', '[0-9]+');
    Route::get("/post",[ForumPostController::class,'index']);

    Route::get("/post/filter/{fromDate}/{toDate}",[ForumPostController::class,'getFilterValue']);

    Route::get("/report",[ReportController::class,'index']);
    Route::get("/statistics/report/{year?}",[ReportController::class,'statistics_report_page']);

    Route::get("/report/done",[ReportController::class,'report_done_page']);
    Route::get("/report/done/filter/{fromDate}/{toDate}",[ReportController::class,'getFilterValueDone']);

    Route::get("/report/update/changeStatus",[ReportController::class,'changeReportStatus']);
    Route::get("/report/detail",[ReportController::class,'detail']);

    Route::get("/report/filter/{fromDate}/{toDate}",[ReportController::class,'getFilterValue']);

    Route::get("/user",[UserController::class,'index']);
    Route::get("/user/{user_id}",[UserController::class,'detail']);
    Route::get("/statistics/user/{year?}",[UserController::class,'statistics_user_page']);
    Route::get("/statistics/user/get/LoginHistoryPerMonth",[UserController::class,'getLoginHistoryPerMonth']);

    Route::get("/user/update/changeStatus",[UserController::class,'changeUserStatus']);
    Route::put("/user/{user_id}",[UserController::class,'update']);
    Route::get("/user/deleteUser",[UserController::class,'deleteUser']);
    Route::get("/user/filter/{fromDate}/{toDate}",[UserController::class,'getFilterValue']);


    Route::resource("/comment",CommentController::class,['except' => ['create', 'store','edit','update','destroy']]);
    Route::get("/comment/getContent/{item_id}",[CommentController::class,'get_content']);
    Route::get("/comment/delete/{item_id}",[CommentController::class,'delete_user_comment']);
    Route::get("/comment/filter/{fromDate}/{toDate}",[CommentController::class,'getFilterValue']);

    Route::get("/deleted/comment",[CommentController::class,'deletedItem']);
    Route::get("/deleted/comment/filter/{fromDate}/{toDate}",[CommentController::class,'getFilterValueDeleted']);

    Route::get("/comment/replies/{item_id}",[CommentController::class,'reply_index']);
    Route::get("/comment/replies/delete/{item_id}",[CommentController::class,'delete_user_reply']);

    Route::get("/comment/replies/getContent/{item_id}",[CommentController::class,'get_replies_content']);

});

Route::group(['prefix' => 'quan-ly',  'middleware' => ['auth']], function()
{

    Route::get("/",[ClientDashboard::class,'index']);
    Route::put("/xet-duyet-lai",[ClientDashboard::class,'re_verified']);
    Route::get("/xem-thong-tin-co-ban",[ClientDashboard::class,'searchInfoByName']);
    Route::resource("/sach",ClientBookController::class,['except' => ['create','edit','destroy','show']]);

    Route::get("/sach/customDelete/{book_id}",[ClientBookController::class,'customDelete']);

    Route::get("/them-sach",[ClientBookController::class,'create']);
    Route::get("/chi-tiet-sach/{book_id}",[ClientBookController::class,'show']);
    Route::get("/cap-nhat-sach/{book_id}",[ClientBookController::class,'edit']);
    Route::get("/sach/update/changeStatus",[ClientBookController::class,'changeBookStatus']);
    

    Route::resource("/chuong",ClientChapterController::class, ['except' => ['create', 'index','edit','destroy']]);
    Route::get("/chuong/customDelete/{chapter_id}",[ClientChapterController::class,'customDelete']);

    Route::get("/them-chuong/{chapter_id}",[ClientChapterController::class,'create'])->where('book_id', '[0-9]+');
    Route::get("/cap-nhat-chuong/{chapter_id}",[ClientChapterController::class,'edit']);


    Route::resource("/tai-lieu",ClientDocumentController::class,['except' => ['create','edit','destroy','show']]);
    Route::get("/tai-lieu/customDelete/{document_id}",[ClientDocumentController::class,'customDelete']);

    Route::get("/them-tai-lieu",[ClientDocumentController::class,'create']);
    Route::get("/cap-nhat-tai-lieu/{document_id}",[ClientDocumentController::class,'edit']);
    Route::get("/chi-tiet-tai-lieu/{document_id}",[ClientDocumentController::class,'show']);

    Route::get("/tai-lieu/update/changeStatus",[ClientDocumentController::class,'changeDocumentStatus']);

    Route::get("/bai-viet",[ClientForumPostController::class,'index']);
    Route::get("/binh-luan",[ClientCommentController::class,'index']);
    Route::get("/binh-luan/phan-hoi/{comment_id}",[ClientCommentController::class,'reply_index']);


});


//Client PAGE

Route::group(['middleware'=>['auth']],function(){

    Route::resource('/profile', ProfileController::class,['except' => ['index','show','store','destroy','create','edit']]);
    Route::get("/trang-ca-nhan",[ProfileController::class,'index']);
    Route::put("/profile/changeAvatar/{profile_id}",[ProfileController::class,'changeAvatar']);
    
    Route::resource('/user',ClientUserController::class,['only' => ['update']]);
    Route::get("/doi-mat-khau",[ClientUserController::class,'changePassword']);
    Route::get('/them-tai-lieu',[PagesController::class,'post_navigation_page']);

    Route::get("/trang-theo-doi",[PagesController::class,'follow_page']);
    Route::post("/theo-doi",[ClientFollowController::class,'following']) ;
    Route::delete("/sach-theo-doi/{book_mark_id}",[ClientFollowController::class,'stopFollowing']);

    Route::post("/sach-danh-gia",[ClientBookController::class,'ratingBook']);
    Route::delete("/xoa-danh-gia",[ClientBookController::class,'deleteRatingBook']);
    
    Route::resource('/bai-viet', ClientForumPostController::class,['except' => ['create', 'edit','delete']]);

    Route::get("/cap-nhat-bai-viet/{forum_slug}/{forum_post_id}",[ClientForumPostController::class,'edit']);
    Route::get("/xoa-bai-viet",[ClientForumPostController::class,'detelePost']);

    Route::post("/bao-cao",[PagesController::class,'report_action']);

    Route::post("/thich-binh-luan",[LikeController::class,'like_comment']);
    Route::post("/thich-phan-hoi",[LikeController::class,'like_reply']);


    Route::get('/trang-chatGPT',[PagesController::class,'chat_gpt_page']);
    Route::get('/chat_gpt',[PagesController::class,'chat_gpt']);
}); 
});


Route::post('login', 'Auth\LoginController@login');
Route::get('password/forgot',[ForgetPasswordController::class,'index']);
Route::post('password/forgot',[ForgetPasswordController::class,'sendEmail']);

Auth::routes([
    'reset' => false, // Reset Password Routes...
    'sendReset' =>false,
    'verify' => false, // Email Verification Routes...,
    'confirm' => false, //
]);


Route::group(['middleware' => ['auth','alreadyVerified']], function(){

    Route::get('/send-email', [MailController::class, 'sendMail']);
    Route::get('/verify-email', [MailController::class, 'verifyPage']);
    Route::post('/verify-email', [MailController::class, 'verifyEmail']);


});



