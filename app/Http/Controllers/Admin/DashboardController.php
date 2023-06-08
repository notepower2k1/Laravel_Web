<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\Document;
use App\Models\ForumPosts;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
   
    public function wait_verification(){
        $books = Book::where('deleted_at','=',null)->where('status','=',0)->get();
        $documents = Document::where('deleted_at','=',null)->where('status','=',0)->get();

        return view('admin.other.wait_verification')
        ->with('documents',$documents)
        ->with('books', $books);   
    }

    public function verification_item(Request $request){

        $itemList = $request->data;

        //2 - document && 1 - Book
        foreach($itemList as $item){

           
            if($item['option'] == "1"){
                $book = Book::findOrFail($item['id']);
                $book->status = 1;
                $book ->save();


                Notification::create([
                    'identifier_id'=>$item['id'],
                    'type_id'=> 6, 
                    'senderID' => 1,
                    'receiverID'=>$book->users->id,
                    'status'=>1
                ]);
            }

            else if($item['option'] == "2"){
                $document = Document::findOrFail($item['id']);
                $document->status = 1;
                $document ->save();

                Notification::create([
                    'identifier_id'=>$item['id'],
                    'type_id'=> 7, 
                    'senderID' => 1,
                    'receiverID'=>$document->users->id,
                    'status'=>1
                ]);
            }
        }


    }
    public function rejection_item(Request $request){
        $itemList = $request->data;

        //0 - document && 1 - Book
        foreach($itemList as $item){

            if($item['option'] == "1"){
                $book = Book::findOrFail($item['id']);
                $book->status = -1;
                $book ->save();

                Notification::create([
                    'identifier_id'=>$item['id'],
                    'type_id'=> 4, 
                    'senderID' => 1,
                    'receiverID'=>$book->users->id,
                    'status'=>1
                ]);
            }

            else if($item['option'] == "2"){
                $document = Document::findOrFail($item['id']);
                $document->status = -1;
                $document ->save();


                Notification::create([
                    'identifier_id'=>$item['id'],
                    'type_id'=> 5, 
                    'senderID' => 1,
                    'receiverID'=>$document->users->id,
                    'status'=>1
                ]);
            }
        }
    }

    public function percentGrowth($now,$previous){

        if($previous == 0){
            return 0;
        }
        else{
            $value = ($now - $previous)/$previous;


             return round($value * 100,2);
        }
       
    }

    public function index(){
        DB::statement("SET SQL_MODE=''");
        
        $today = Carbon::now()->toDateString();
        $yesterday = Carbon::now()->subDay(1)->toDateString();                     

        
        $weekStartDate = Carbon::now()->startOfWeek()->toDateString();
        $weekEndDate = Carbon::now()->endOfWeek()->toDateString();

        $today_book = Book::whereDate('created_at', $today)->where('deleted_at','=',null)->get();

        $yesterday_book = Book::whereDate('created_at', $yesterday)->where('deleted_at','=',null)->get();

        $today_document = Document::whereDate('created_at', $today)->where('deleted_at','=',null)->get();
   
        $yesterday_document = Document::whereDate('created_at', $yesterday)->where('deleted_at','=',null)->get();

        $today_post = ForumPosts::whereDate('created_at', $today)->where('deleted_at','=',null)->get();

        $yesterday_post =  ForumPosts::whereDate('created_at', $yesterday)->where('deleted_at','=',null)->get();


        $today_user = User::whereDate('email_verified_at', $today)->where('deleted_at','=',null)->get();

        $yesterday_user = User::whereDate('email_verified_at', $yesterday)->where('deleted_at','=',null)->get();

          
        $book_today_info = collect([
            'todayValue' => $today_book->count(),
            'yestedayValue' => $yesterday_book->count(),
            'percentGrowth' => $this->percentGrowth($today_book->count(),$yesterday_book->count()),
        ]);

        $document_today_info = collect([
            'todayValue' => $today_document->count(),
            'yestedayValue' => $yesterday_document->count(),
            'percentGrowth' => $this->percentGrowth($today_document->count(),$yesterday_document->count()),
        ]);

        $post_today_info = collect([
            'todayValue' => $today_post->count(),
            'yestedayValue' => $yesterday_post->count(),
            'percentGrowth' => $this->percentGrowth($today_post->count(),$yesterday_post->count()),
        ]);

        $user_today_info = collect([
            'todayValue' => $today_user->count(),
            'yestedayValue' => $yesterday_user->count(),
            'percentGrowth' => $this->percentGrowth($today_user->count(),$yesterday_user->count()),
        ]);

        $today_logins = DB::select("SELECT HOUR(login_histories.created_at) as 'hour',COUNT(login_histories.id) as 'total'
        FROM login_histories WHERE DATE(login_histories.created_at) = '$today'
        GROUP BY HOUR(login_histories.created_at)
        ORDER BY HOUR(login_histories.created_at)");

        $week_books = DB::select("SELECT 
        SUM(IF(day = 2, total, 0)) AS 'Thứ 2', 
        SUM(IF(day = 3, total, 0)) AS 'Thứ 3', 
        SUM(IF(day = 4, total, 0)) AS 'Thứ 4', 
        SUM(IF(day = 5, total, 0)) AS 'Thứ 5', 
        SUM(IF(day = 6, total, 0)) AS 'Thứ 6', 
        SUM(IF(day = 7, total, 0)) AS 'Thứ 7',
        SUM(IF(day = 1, total, 0)) AS 'Chủ nhật'
        FROM ( 
            SELECT DAYOFWEEK(books.created_at) AS day, 
            COUNT(books.id) as total 
            FROM books         
            WHERE DATE(books.created_at) >= '$weekStartDate' and DATE(books.created_at) <= '$weekEndDate'and books.deleted_at is null
            GROUP BY DAYOFWEEK(books.created_at)
        ) as sub");

            
        $week_documents = DB::select("SELECT 
        SUM(IF(day = 2, total, 0)) AS 'Thứ 2', 
        SUM(IF(day = 3, total, 0)) AS 'Thứ 3', 
        SUM(IF(day = 4, total, 0)) AS 'Thứ 4', 
        SUM(IF(day = 5, total, 0)) AS 'Thứ 5', 
        SUM(IF(day = 6, total, 0)) AS 'Thứ 6', 
        SUM(IF(day = 7, total, 0)) AS 'Thứ 7',
        SUM(IF(day = 1, total, 0)) AS 'Chủ nhật'
        FROM ( 
            SELECT DAYOFWEEK(documents.created_at) AS day, 
            COUNT(documents.id) as total 
            FROM documents         
            WHERE DATE(documents.created_at) >= '$weekStartDate' and DATE(documents.created_at) <= '$weekEndDate'and documents.deleted_at is null
            GROUP BY DAYOFWEEK(documents.created_at)
        ) as sub");

        $week_members = DB::select("SELECT 
        SUM(IF(day = 2, total, 0)) AS 'Thứ 2', 
        SUM(IF(day = 3, total, 0)) AS 'Thứ 3', 
        SUM(IF(day = 4, total, 0)) AS 'Thứ 4', 
        SUM(IF(day = 5, total, 0)) AS 'Thứ 5', 
        SUM(IF(day = 6, total, 0)) AS 'Thứ 6', 
        SUM(IF(day = 7, total, 0)) AS 'Thứ 7',
        SUM(IF(day = 1, total, 0)) AS 'Chủ nhật'
        FROM ( 
            SELECT DAYOFWEEK(users.email_verified_at) AS day, 
            COUNT(users.id) as total 
            FROM users         
            WHERE DATE(users.email_verified_at) >= '$weekStartDate' and DATE(users.email_verified_at) <= '$weekEndDate' and 
            users.deleted_at is null and users.email_verified_at is not null
            GROUP BY DAYOFWEEK(users.email_verified_at)
        ) as sub");

        $week_posts = DB::select("SELECT 
        SUM(IF(day = 2, total, 0)) AS 'Thứ 2', 
        SUM(IF(day = 3, total, 0)) AS 'Thứ 3', 
        SUM(IF(day = 4, total, 0)) AS 'Thứ 4', 
        SUM(IF(day = 5, total, 0)) AS 'Thứ 5', 
        SUM(IF(day = 6, total, 0)) AS 'Thứ 6', 
        SUM(IF(day = 7, total, 0)) AS 'Thứ 7',
        SUM(IF(day = 1, total, 0)) AS 'Chủ nhật'
        FROM ( 
            SELECT DAYOFWEEK(forum_posts.created_at) AS day, 
            COUNT(forum_posts.id) as total 
            FROM forum_posts         
            WHERE DATE(forum_posts.created_at) >= '$weekStartDate' and DATE(forum_posts.created_at) <= '$weekEndDate'and forum_posts.deleted_at is null
            GROUP BY DAYOFWEEK(forum_posts.created_at)
        ) as sub");




        $total_books = Book::where('deleted_at','=',null)->where('status','=',1)->whereDate('created_at','<=', $weekEndDate)->whereDate('created_at','>=', $weekStartDate)->get();
        $total_documents = Document::where('deleted_at','=',null)->where('status','=',1)->whereDate('created_at','<=', $weekEndDate)->whereDate('created_at','>=', $weekStartDate)->get();
        $total_posts = ForumPosts::where('deleted_at','=',null)->whereDate('created_at','<=', $weekEndDate)->whereDate('created_at','>=', $weekStartDate)->get();
        $total_users = User::where('deleted_at','=',null)->whereDate('email_verified_at','<=', $weekEndDate)->whereDate('email_verified_at','>=', $weekStartDate)->get();


        $high_reading_book = Book::where('deleted_at','=',null)->where('status','=',1)->get()->sortByDesc('totalReading')->first();
        $high_downloading_document = Document::where('deleted_at','=',null)->where('status','=',1)->get()->sortByDesc('totalDownloading')->first();

        return view('admin.dashboard')
        ->with('today',$today)
        ->with('today_logins',$today_logins)
        ->with('book_today_info',$book_today_info)
        ->with('week_books',$week_books)
        ->with('document_today_info',$document_today_info)
        ->with('week_documents',$week_documents)
        ->with('post_today_info',$post_today_info)
        ->with('week_posts',$week_posts)
        ->with('user_today_info',$user_today_info)
        ->with('week_members',$week_members)
        ->with('total_books',$total_books->count())
        ->with('total_documents',$total_documents->count())
        ->with('total_posts',$total_posts->count())
        ->with('total_users',$total_users->count())

        ->with('today_book',$today_book)
        ->with('today_document',$today_document)
        ->with('high_reading_book',$high_reading_book)
        ->with('high_downloading_document',$high_downloading_document)
        
        ;
            


    }

    public function getLoginHistory(Request $request){

        $option = $request->option;
        $today = Carbon::now()->toDateString();
        $yesterday = Carbon::now()->subDay(1)->toDateString();                     

        
        $weekStartDate = Carbon::now()->startOfWeek()->toDateString();
        $weekEndDate = Carbon::now()->endOfWeek()->toDateString();

        $item = array();

        switch ($option) {
            case 0:
                $item = DB::select("SELECT HOUR(login_histories.created_at) as 'hour',COUNT(login_histories.id) as 'total'
                FROM login_histories WHERE DATE(login_histories.created_at) = '$today'
                GROUP BY HOUR(login_histories.created_at)
                ORDER BY HOUR(login_histories.created_at)");
                break;
            case 1:
                $item = DB::select("SELECT HOUR(login_histories.created_at) as 'hour',COUNT(login_histories.id) as 'total'
                FROM login_histories WHERE DATE(login_histories.created_at) = '$yesterday'
                GROUP BY HOUR(login_histories.created_at)
                ORDER BY HOUR(login_histories.created_at)");
              break;
            case 2:
                $item = DB::select("SELECT HOUR(login_histories.created_at) as 'hour',COUNT(login_histories.id) as 'total'
                FROM login_histories WHERE DATE(login_histories.created_at) > '$weekStartDate' and DATE(login_histories.created_at) < '$weekEndDate'
                GROUP BY HOUR(login_histories.created_at)
                ORDER BY HOUR(login_histories.created_at)");
              break;
            default:
                $item = array();
          }

          return response()->json([
            'res' => $item,
            ]);  
    }

}
