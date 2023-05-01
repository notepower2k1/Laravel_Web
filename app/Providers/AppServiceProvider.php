<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\bookMark;
use App\Models\Book;
use App\Models\Document;
use App\Models\Follow;
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
    public function similarity_distance($matrix,$person1,$person2){

        $similar = array();
        $sum = 0;
        foreach($matrix[$person1] as $key=>$value){

            if (array_key_exists($key,$matrix[$person2])){
                $similar[$key] = 1;
            }

        }

       
        if($similar==0){
            return 0;
        }

        foreach($matrix[$person1] as $key=>$value){

            if (array_key_exists($key,$matrix[$person2])){
               
                $sum = $sum + pow($value - $matrix[$person2][$key],2);
            }
        }

        return 1 / (1+ sqrt($sum));
    }

    public function getBookSlug($id){
        $book = Book::findOrFail($id);

        return $book->slug;

    }
    public function getMatrix(){

        $bookRatings = ratingBook::all();
        $matrix = array();

        foreach($bookRatings as $book){
            $users = User::where('id','=',$book->userID)->get();

            foreach($users as $user){
                $matrix[$user->name][$this->getBookSlug($book->bookID)] = $book->score;

            }

        }    

        return $matrix;
    }

    public function getMatrix2(){

        $bookRatings = readingHistory::selectRaw('SUM(total) as total')->groupBy(['bookID','userID'])->get();
        $matrix = array();

        foreach($bookRatings as $book){
            $users = User::where('id','=',$book->userID)->get();

            foreach($users as $user){
                $matrix[$user->name][$this->getBookSlug($book->bookID)] = $book->total;
            }

        }    

        return $matrix;
    }

    public function getRecommendation($matrix,$person){

        $total = array();
        $simsums = array();
        $ranks = array();
        foreach($matrix as $otherPerson=>$value){

            if($otherPerson != $person){
                $sim = $this->similarity_distance($matrix,$person,$otherPerson);

                foreach($matrix[$otherPerson] as $key=>$value){
                    if(!array_key_exists($key,$matrix[$person])){

                        if(!array_key_exists($key,$total)){
                            $total[$key]=0;

                        }
                        $total[$key]+=$matrix[$otherPerson][$key]*$sim;

                        if(!array_key_exists($key,$simsums)){
                            $simsums[$key]=0;
                        }

                        $simsums[$key]+=$sim;

                    }
                }
            }
        }

        foreach($total as $key=>$value){
            $ranks[$key] = $value/$simsums[$key];
        }

        array_multisort($ranks,SORT_DESC);  
        return $ranks;
    } 

    public function getRecommendationByRating(){

        //Ranks by history log
        $matrix = $this->getMatrix();

        $list = $this->getRecommendation($matrix,Auth::user()->name);


        $listUserNotReadBook = collect();
        foreach ($list as $item=>$rating){
            $book = Book::where('slug','=',$item)->first();
            $listUserNotReadBook->push($book);
        }

        return $listUserNotReadBook;
    }
    public function getRecommendationByType(){

        //Ranks by total reading
        $matrix = $this->getMatrix2();

        $list = $this->getRecommendation($matrix,Auth::user()->name);


        $listUserNotReadBook = collect();
        foreach ($list as $item=>$total){
            $book = Book::where('slug','=',$item)->first();
            $listUserNotReadBook->push($book);
        }


        $userID = Auth::user()->id;

        $rankTypeBook = DB::select("SELECT books.type_id, 
        SUM(`total`) as 'total' FROM reading_histories join books 
        on reading_histories.bookID = books.id WHERE `userID` = $userID
        GROUP BY `books`.`type_id` 
        ORDER BY total desc
        limit 2");

        $listUserNotReadBookByTypeRank = collect();

        foreach ($rankTypeBook as $rank){
            $temp = $listUserNotReadBook->where('type_id',$rank->type_id);


            if($temp->count() > 0 ){
                $listUserNotReadBookByTypeRank->push($temp);

            }
        }
        return $listUserNotReadBookByTypeRank->first();

        // $listbooks = Book::all()->pluck('id')->toArray();

        // $listUserReadBookID = readingHistory::where('userID',Auth::user()->id)->pluck('bookID')->toArray(); 

        // $listUserNotReadBookID = array_diff($listbooks, $listUserReadBookID);

        // $listUserNotReadBookID = array_values($listUserNotReadBookID);

        // $listUserNotReadBook = collect();

        // foreach ($listUserNotReadBookID as $bookID){
        //     $book = Book::findOrFail($bookID);
        //     $listUserNotReadBook->push($book);
        // }
    
        // $userID = Auth::user()->id;

        // $rankTypeBook = DB::select("SELECT books.type_id, 
        // SUM(`total`) as 'total' FROM reading_histories join books 
        // on reading_histories.bookID = books.id WHERE `userID` = $userID
        // GROUP BY `books`.`type_id` 
        // ORDER BY total desc
        // limit 2");

        // $listUserNotReadBookWithTypeRank = collect();

        // foreach ($rankTypeBook as $rank){
        //     $temp = $listUserNotReadBook->where('type_id',$rank->type_id);


        //     if($temp->count() > 0 ){
        //         $listUserNotReadBookWithTypeRank->push($temp);

        //     }
        // }

        // $listUserNotReadBookByTypeRank = $listUserNotReadBookWithTypeRank->SortByDesc('totalReading');

        // return $listUserNotReadBookByTypeRank;
    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
            
            view()->composer('admin.layouts.header', function ($view) {
                $report_notifications = report::where('status','=',1)->get();
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

                    $follow_notifications = Follow::where('userID','=',Auth::user()->id)->where('status','=',1)->get();
                    $comment_notifications = Notification::where('receiverID','=',Auth::user()->id)->where('status','=',1)->get();

                    $view
                    ->with('follow_notifications',$follow_notifications)
                    ->with('comment_notifications',$comment_notifications);

                }
              
            });
        
    

            view()->composer('client.homepage.layouts.contentFooter', function ($view) {

                if(Auth::check()){               
                    
                    $listUserNotReadBookByTypeRank = $this->getRecommendationByType();

                    $listUserNotReadBookByRating = $this->getRecommendationByRating();

                    $view
                    ->with('listUserNotReadBookByRating',$listUserNotReadBookByRating)
                    ->with('listUserNotReadBookByTypeRank',$listUserNotReadBookByTypeRank);


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
