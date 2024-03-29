<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\bookMark;
use App\Models\BookType;
use App\Models\Comment;
use App\Models\Follow;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ratingBook;
use App\Models\Reply;
use App\Models\report;
use App\Models\User;
use Illuminate\Support\Str;


class ClientBookController extends Controller
{

    function TimeToText(){
        $now_date = Carbon::now()->toDateTimeString();
        $string = str_replace(' ', '-', $now_date);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);  
    }
    
  
    
    public function index()
    {
          
        $books = Book::where('userCreatedID','=',Auth::user()->id)->where('deleted_at','=',null)->where('status','=',1)->get();
      
        return view('client.manage.book.index')->with('books', $books);

       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = BookType::all();

        return view('client.manage.book.create')->with('types',$types);
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:books',
            'author' => 'required',
            'description' => 'required',
            'image' => 'required|image|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            'language' => 'required',
            'isCompleted' => 'required',
            'file_book' => 'mimetypes:application/pdf',

        ],
        [
            'name.required' => 'Bạn cần phải nhập tên sách',
            'name.unique' => 'Sách đã tồn tại',
            'author.required' => 'Bạn cần phải nhập tên tác giả',
            'description.required' => 'Bạn cần phải nhập mô tả sách',
            'image.required' => 'Sách cần có ảnh bìa',
            'image.image' => 'Bạn nên đưa đúng định dạng ảnh bìa',
            'image.max' => 'Dung lượng ảnh quá lớn',
            'image.dimensions' => 'Kích thước ảnh nhỏ nhất là 100x100 và lớn nhất là 2000x2000',
            'file_book.mimetypes' => 'Tài liệu đình kèm nên là file .pdf',
            'isCompleted.required' => 'Sách phải có tình trạng'
        ]);


        $slug =  Str::slug($request->name).'-'. $this->TimeToText();

        $image = $request->file('image'); //image file from frontend

        $generatedImageName = $slug.$image->hashName();

        $generatedFileName = null;
        $file_book = $request->file('file_book'); 

        if($file_book){
            $generatedFileName = $slug.$file_book->hashName();
            
            $firebase_storage_path_2 = 'bookFile/';
            $uploadedfileBook = file_get_contents($request->file('file_book'));

            app('firebase.storage')->getBucket()->upload($uploadedfileBook, ['name' => $firebase_storage_path_2 . $generatedFileName]);
            
        }
   

        $book = Book::create([
            'name' => $request->name,
            'author' => $request->author,
            'description' => $request->description,
            'isPublic' => 0,
            'slug' =>  $slug,
            'type_id' => intval($request->book_type_id),
            'image' => $generatedImageName,
            'userCreatedID' => Auth::user()->id,
            'isCompleted' => 0,
            'language' => $request -> language,
            'numberOfChapter' => 0,
            'ratingScore'=> 0,
            'totalReading'=>0,
            'totalBookMarking'=>0,
            'totalComments' => 0,
            'status' =>0,
            'file' => $generatedFileName

        ]);
        
        $firebase_storage_path = 'bookImage/';
        $uploadedfileImage = file_get_contents($request->file('image'));
        app('firebase.storage')->getBucket()->upload($uploadedfileImage, ['name' => $firebase_storage_path . $generatedImageName]);

    



        return redirect('/quan-ly');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) //like "show details"
    {
        $book = Book::where('userCreatedID','=',Auth::user()->id)->where('deleted_at','=',null)->findOrFail($id);

        return view('client.manage.book.detail')
        ->with('book',$book);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::where('userCreatedID','=',Auth::user()->id)->where('id','=',$id)->where('deleted_at','=',null)->whereIn('status',['-1','1'])->firstOrFail();
        $types = BookType::all();


        return view('client.manage.book.edit')
        ->with('book',$book)
        ->with('types',$types);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'author' => 'required',
            'description' => 'required',
            'image' => 'image|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            'isCompleted' => 'required'
        ],[
            'name.required' => 'Bạn cần phải nhập tên sách',
            'author.required' => 'Bạn cần phải nhập tên tác giả',
            'description.required' => 'Bạn cần phải nhập mô tả sách',
            'image.image' => 'Bạn nên đưa đúng định dạng ảnh bìa',
            'image.max' => 'Dung lượng ảnh quá lớn',
            'image.dimensions' => 'Kích thước ảnh nhỏ nhất là 100x100 và lớn nhất là 2000x2000'
        ]);

        $slug =  Str::slug($request->name).'-'. $this->TimeToText();

        $generatedImageName="";

        if($request->image == null){
            $generatedImageName = $request->oldImage;
        }
        else{
            $image = $request->file('image'); //image file from frontend

            //upload new image
            $generatedImageName = $slug.$image->hashName();



            $firebase_storage_path = 'bookImage/';
            $uploadedfileImage = file_get_contents($request->file('image'));
            app('firebase.storage')->getBucket()->upload($uploadedfileImage, ['name' => $firebase_storage_path . $generatedImageName]);

            //delete old image

            $imageDeleted = app('firebase.storage')->getBucket()->object($firebase_storage_path.$request->oldImage)->delete();

            
        }
        $book = Book::findOrFail($id)
                ->update([
                    'name' => $request->name,
                    'author' => $request->author,
                    'description' => $request->description,
                    'slug' =>  $slug,
                    'type_id' => intval($request->book_type_id),
                    'image' => $generatedImageName,
                    'isCompleted' => $request -> isCompleted
        ]);

      
        return redirect("/quan-ly/sach");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $book = Book::findOrFail($id);
    //     $book->delete();

    //     return response()->json([
    //         'success' => 'Record deleted successfully!'
    //     ]);
    // }

    public function customDelete($book_id){
        $book = Book::where('userCreatedID','=',Auth::user()->id)->findOrFail($book_id);
        $book->deleted_at = Carbon::now()->toDateTimeString();
        $book->totalComments = 0;
        $book->totalBookMarking = 0;
        $book->ratingScore = 0;
        $book ->save();

        Comment::where('identifier_id','=',$book_id)->where('type_id','=','2')->update([
            'deleted_at' => Carbon::now()->toDateTimeString()
        ]);

        $comments = Comment::where('identifier_id','=',$book_id)->where('type_id','=','2')->get();

     
        foreach($comments as $comment){

            $replies = Reply::where('commentID','=',$comment->id)->get();


            foreach ($replies as $reply){

                $temp = Reply::findOrFail($reply->id);
                $temp->deleted_at = Carbon::now()->toDateTimeString();
                $temp ->save();

                
                Notification::where('identifier_id','=',$reply->id)->where('type_id','=','2')->update([
                    'deleted_at' => Carbon::now()->toDateTimeString()
                ]);
            }

            Notification::where('identifier_id','=',$comment->id)->where('type_id','=','1')->update([
                'deleted_at' => Carbon::now()->toDateTimeString()
            ]);
    
        }



      

     

        $follows = Follow::where('identifier_id','=',$book_id)->where('type_id','=','2')->get();

        foreach($follows as $follow){
            $follow->delete();
        }

        $ratings = ratingBook::where('bookID','=',$book_id)->get();
        foreach($ratings as $rating){
            $rating->delete();
        }
    }   
    public function changeBookStatus(Request $request){
        $book = Book::findOrFail($request->id);
        $book->isPublic = $request->isPublic;
        $book ->save();
      
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

    public function ratingBook(Request $request){


        $rating_book_score = ratingBook::where('bookID','=',$request->id)->pluck('score')->toArray();

        $book_rating = ratingBook::create([
            'bookID' => $request -> id,
            'userID' => Auth::user()->id,
            'score' => $request -> score,
            'content' => $request ->content
        ]);
        $book_rating ->save();

        array_push($rating_book_score,$request -> score);

        $rating_book_score = array_filter($rating_book_score, fn($x)=>$x !== '');
        $average = array_sum($rating_book_score)/count($rating_book_score);

        $book = Book::findOrFail($request->id);
        $book->ratingScore = round($average, 1);

        $ratingPersons = ratingBook::where('bookID','=',$request->id)->get();

        $book->save();

        $recommened_book = $this->getRecommendationByRating()[0];

        $item = '';
        if($recommened_book){
            $item = 
            '<div class="d-flex mb-3">'.
                '<div class="flex-grow-1">'.
                    '<div class="d-flex flex-column h-100">'.
                        '<h4>'.$recommened_book->name.'</h4>'.
                    ' <span class="text-muted"><em class="icon ni ni-user-list"></em><span>'.$recommened_book->author.'</span></span>'.

                    ' <span class="text-muted">Lượt đọc: <span>'.$recommened_book->totalReading.'</span><em class="icon ni ni-eye text-success"></em></span>'.
                    ' <span class="text-muted">Đánh giá: <span>'.$recommened_book->ratingScore.'/5</span><em class="icon ni ni-star text-warning"></em></span>'.

                        '<span>'.Str::limit($recommened_book->description,250).'</span>'.
                        '<div class="d-inline">'.
                            '<span class="p-1 badge badge-dim bg-outline-danger">'.$recommened_book->types->name.'</span> '  .   
                    ' </div>'.


                    ' <div class="flex-fill d-flex align-items-end">'.

                        ' <a href="/sach/'.$recommened_book->id.'/'.$recommened_book->slug.'" class="btn btn-danger btn-lg px-4">Đọc ngay</a>'.
                        '</div>'.
                    '</div>'.
            ' </div>'.
                '<div class="item-image">'.
                    '<a class="book-container" href="/sach/'.$recommened_book->id.'/'.$recommened_book->slug.'" target="_blank" rel="noreferrer noopener">'.
                    '<div class="bookNonHover">'.
                        '<img alt="" src="'.$recommened_book->url.'">'.
                    '</div>'.
                ' </a>'.
                '</div>'.
            '</div>';

        }
     
        return response()->json([
            'success' => 'Cảm ơn bạn đã đánh giá!!!!',
            'currentScore' => $book->ratingScore,
            'totalOfRating' =>$ratingPersons->count(),
            'recommened_book' => $item
        ]);
        
       
    }

    public function deleteRatingBook(Request $request){

        $rating = ratingBook::findOrFail($request->rating_id);
        $rating->delete();

        //update new score
        $rating_book_score = ratingBook::where('bookID','=',$request->book_id)->pluck('score')->toArray();

        if(count($rating_book_score) > 0){
            $rating_book_score = array_filter($rating_book_score, fn($x)=>$x !== '');
            $average = array_sum($rating_book_score)/count($rating_book_score);
    
            $book = Book::findOrFail($request->book_id);
            $book->ratingScore = round($average, 1);
    
            $ratingPersons = ratingBook::where('bookID','=',$request->book_id)->get();
    
            $book->save();
        }
        else{
            $book = Book::findOrFail($request->book_id);
            $book->ratingScore = 0;
    
            $ratingPersons = ratingBook::where('bookID','=',$request->book_id)->get();
    
            $book->save();
        }
       

        report::where('identifier_id','=',$request->book_id)->where('type_id','=','10')->update([
            'deleted_at' => Carbon::now()->toDateTimeString()
        ]);


        return response()->json([
            'success' => 'Xóa đánh giá thành công!!!',
            'currentScore' => $book->ratingScore,
            'totalOfRating' =>$ratingPersons->count()
        ]);
    }

 
}
