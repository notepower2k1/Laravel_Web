<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\bookMark;
use App\Models\BookType;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ratingBook;
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
        $localfolder = public_path('firebase-temp-uploads') .'/';

        if ($image->move($localfolder, $generatedImageName)) {
        $uploadedfile = fopen($localfolder.$generatedImageName, 'r');

        app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $generatedImageName]);
        unlink($localfolder . $generatedImageName);
        }

        $firebase_storage_path_2 = 'bookFile/';
        if ($file_book->move($localfolder, $generatedFileName)) {
        $uploadedfile = fopen($localfolder.$generatedFileName, 'r');
        
        app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path_2 . $generatedFileName]);
        unlink($localfolder . $generatedFileName);
        }



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
        $book = Book::findOrFail($id);

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
        $book = Book::findOrFail($id);
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

            $localfolder = public_path('firebase-temp-uploads') .'/';
            if ($image->move($localfolder, $generatedImageName)) {
            $uploadedfile = fopen($localfolder.$generatedImageName, 'r');

            app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $generatedImageName]);
            unlink($localfolder . $generatedImageName);

            //delete old image

            $imageDeleted = app('firebase.storage')->getBucket()->object($firebase_storage_path.$request->oldImage)->delete();

            }
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
        $book = Book::findOrFail($book_id);
        $book->deleted_at = Carbon::now()->toDateTimeString();
        $book ->save();
    }   
    public function changeBookStatus(Request $request){
        $book = Book::findOrFail($request->id);
        $book->isPublic = $request->isPublic;
        $book ->save();
      
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
        $book->ratingScore = round($average, 2);

        $ratingPersons = ratingBook::where('bookID','=',$request->id)->get();

        $book->save();
        return response()->json([
            'success' => 'Cảm ơn bạn đã đánh giá!!!!',
            'currentScore' => $book->ratingScore,
            'totalOfRating' =>$ratingPersons->count()
        ]);
        
       
    }

    public function deleteRatingBook(Request $request){

        $rating = ratingBook::findOrFail($request->rating_id);
        $rating->delete();

        //update new score
        $rating_book_score = ratingBook::where('bookID','=',$request->book_id)->pluck('score')->toArray();

        $rating_book_score = array_filter($rating_book_score, fn($x)=>$x !== '');
        $average = array_sum($rating_book_score)/count($rating_book_score);

        $book = Book::findOrFail($request->book_id);
        $book->ratingScore = round($average, 2);

        $ratingPersons = ratingBook::where('bookID','=',$request->book_id)->get();

        $book->save();
       


        return response()->json([
            'success' => 'Xóa đánh giá thành công!!!',
            'currentScore' => $book->ratingScore,
            'totalOfRating' =>$ratingPersons->count()
        ]);
    }

    public function changeFollowStatus(Request $request){
        $follow = Follow::findOrFail($request->id);
        $follow->status = 0;
        $follow ->save();


        return response()->json([
            'success' => 'Đánh dấu thành công!!!',      
        ]);
      
    }
}
