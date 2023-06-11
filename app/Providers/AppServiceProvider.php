<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\bookMark;
use App\Models\Book;
use App\Models\BookType;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Follow;
use App\Models\NoteType;
use App\Models\readingHistory;
use App\Models\ratingBook;
use App\Models\report;
use App\Models\User;

use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
 
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
            
            view()->composer('admin.layouts.app',function($view){
                $note_types = NoteType::all();
                $books = Book::where('deleted_at','=',null)->get();
                $documents = Document::where('deleted_at','=',null)->get();
                $users = User::where('deleted_at','=',null)->get();

                $view
                ->with('books',$books)
                ->with('documents',$documents)
                ->with('users',$users)
                ->with('note_types',$note_types);  
            });

            
            view()->composer('admin.layouts.header', function ($view) {
                $report_notifications = report::where('status','=',1)->where('deleted_at','=',null)->get();
                $view
                ->with('report_notifications',$report_notifications);  
            });

            view()->composer('admin.layouts.sidebar', function ($view) {

                $books = Book::where('deleted_at','=',null)->where('status','=',0)->get();
                $documents = Document::where('deleted_at','=',null)->where('status','=',0)->get();

                $wait_verified_totals = $books->count() +  $documents->count();

                $report_not_done_totals = report::where('status','=',1)->get()->count();

                $view
                ->with('report_not_done_totals',$report_not_done_totals)
                ->with('wait_verified_totals',$wait_verified_totals);  
            });

            view()->composer('client.homepage.layouts.header', function ($view) {

            

                if(Auth::check()){   
                    $follow_notifications = Follow::where('userID','=',Auth::user()->id)->where('isDone','=',0)->where('status','=',1)->orderBy('updated_at','desc')->get();
                    $comment_notifications = Notification::where('receiverID','=',Auth::user()->id)->where('deleted_at','=',null)->orderBy('created_at','desc')->get();

                    $comment_notifications_show  = Notification::where('receiverID','=',Auth::user()->id)->where('deleted_at','=',null)->where('status','=',1)->orderBy('created_at','desc')->get();

                    $view
                    ->with('follow_notifications',$follow_notifications)
                    ->with('comment_notifications_show',$comment_notifications_show)
                    ->with('comment_notifications',$comment_notifications);

                }
              
            });
        
         
        
    

          

            view()->composer('client.homepage.layouts.app',function($view){
                $books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get(['id','slug','author','name']);
        
                $documents = Document::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get(['id','slug','author','name']);
        
             

                $view
                ->with('documentContentsForSearch',$documents)
                ->with('bookContentsForSearch',$books);
        
            });
     
    }
}
