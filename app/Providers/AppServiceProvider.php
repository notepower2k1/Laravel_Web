<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\bookMark;
use App\Models\Book;
use App\Models\readingHistory;
use App\Models\ratingBook;
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
        $listbooks = Book::all()->pluck('id')->toArray();

        $listUserReadBookID = readingHistory::where('userID',Auth::user()->id)->pluck('bookID')->toArray(); 

        $listUserNotReadBookID = array_diff($listbooks, $listUserReadBookID);

        $listUserNotReadBookID = array_values($listUserNotReadBookID);

        $listUserNotReadBook = collect();

        foreach ($listUserNotReadBookID as $bookID){
            $book = Book::findOrFail($bookID);
            $listUserNotReadBook->push($book);
        }
    
        $userID = Auth::user()->id;

        $rankTypeBook = DB::select("SELECT books.type_id, 
        SUM(`total`) as 'total' FROM reading_histories join books 
        on reading_histories.bookID = books.id WHERE `userID` = $userID
        GROUP BY `books`.`type_id` 
        ORDER BY total desc
        limit 2");

        $listUserNotReadBookWithTypeRank = collect();

        foreach ($rankTypeBook as $rank){
            $temp = $listUserNotReadBook->where('type_id',$rank->type_id);


            if($temp->count() > 0 ){
                $listUserNotReadBookWithTypeRank->push($temp);

            }
        }

        $listUserNotReadBookByTypeRank = $listUserNotReadBookWithTypeRank->SortByDesc('totalReading');

        return $listUserNotReadBookByTypeRank;
    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
            view()->composer('client.homepage.layouts.header', function ($view) {

                if(Auth::check()){   

                    $bookMark_notifications = bookMark::where('userID','=',Auth::user()->id)->where('status','=',1)->get();
                    $comment_notifications = Notification::where('receiverID','=',Auth::user()->id)->where('status','=',1)->get();

                    $view
                    ->with('bookMark_notifications',$bookMark_notifications)
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
     
    }
}
