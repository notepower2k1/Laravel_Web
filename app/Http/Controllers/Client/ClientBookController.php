<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\bookMark;
use App\Models\BookType;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ratingBook;
use Kreait\Firebase\Auth\SignInResult\SignInResult;
use Kreait\Firebase\Exception\FirebaseException;
use Google\Cloud\Firestore\FirestoreClient;


class ClientBookController extends Controller
{

    function setNameForImage(){
        $now_date = Carbon::now()->toDateTimeString();
        $string = str_replace(' ', '-', $now_date);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);  
    }
    
  
    
    public function index()
    {
          
        $books = Book::where('userCreatedID','=',Auth::user()->id)->get();
      
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

   
    function slugify($string)
    {
        $replacement = '-';
        $map = array();
        $quotedReplacement = preg_quote($replacement, '/');
        $default = array(
            '/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ|å/' => 'a',
            '/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ|ë/' => 'e',
            '/ì|í|ị|ỉ|ĩ|Ì|Í|Ị|Ỉ|Ĩ|î/' => 'i',
            '/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ|ø/' => 'o',
            '/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ|ů|û/' => 'u',
            '/ỳ|ý|ỵ|ỷ|ỹ|Ỳ|Ý|Ỵ|Ỷ|Ỹ/' => 'y',
            '/đ|Đ/' => 'd',
            '/ç/' => 'c',
            '/ñ/' => 'n',
            '/ä|æ/' => 'ae',
            '/ö/' => 'oe',
            '/ü/' => 'ue',
            '/Ä/' => 'Ae',
            '/Ü/' => 'Ue',
            '/Ö/' => 'Oe',
            '/ß/' => 'ss',
            '/[^\s\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => ' ',
            '/\\s+/' => $replacement,
            sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement) => '',
        );
        //Some URL was encode, decode first
        $title = urldecode($string);
        $map = array_merge($map, $default);
        return strtolower(preg_replace(array_keys($map), array_values($map), $title));
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
            'name' => 'required',
            'author' => 'required',
            'description' => 'required',
            'image' => 'required|image|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
        ]);


        $slug =  $this->slugify($request->name);
    
        $image = $request->file('image'); //image file from frontend

        $generatedImageName = 'image'.$this->setNameForImage().'-'
        .$slug.'.'
        .$request->image->extension();

        $firebase_storage_path = 'bookImage/';
        $localfolder = public_path('firebase-temp-uploads') .'/';
        if ($image->move($localfolder, $generatedImageName)) {
        $uploadedfile = fopen($localfolder.$generatedImageName, 'r');

        app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $generatedImageName]);
        unlink($localfolder . $generatedImageName);
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
            'totalBookMarking'=>0
        ]);
        $book->save();

        return redirect('/quan-ly/sach');

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
            'image' => 'mimes:jpg,png,jpeg|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            'isCompleted' => 'required'
        ]);

        $slug =  $this->slugify($request->name);

        $generatedImageName="";

        if($request->image == null){
            $generatedImageName = $request->oldImage;
        }
        else{
            $image = $request->file('image'); //image file from frontend

            //upload new image
            $generatedImageName = 'image'.$this->setNameForImage().'-'
            .$slug.'.'
            .$request->image->extension();

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
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    public function changeBookStatus(Request $request){
        $book = Book::findOrFail($request->id);
        $book->isPublic = $request->isPublic;
        $book ->save();
      
    }

    public function markBook(Request $request){

        $bookMark = bookMark::create([
            'bookID' => $request -> book_id,
            'userID' => Auth::user()->id
        ]);

        $book = Book::findOrFail($request -> book_id);
        $book->totalBookMarking = $book->totalBookMarking + 1;
        $book->save();

        $bookMark->save();
        return response()->json([
            'success' => 'Bạn đã theo dõi sách thành công!!!',
            'totalBookMarking' => $book->totalBookMarking
        ]);
    }

    public function removeMarkBook($id){
        $book_mark = bookMark::findOrFail($id);

        $book = Book::findOrFail($book_mark -> bookID);
        $book->totalBookMarking = $book->totalBookMarking - 1;
        $book->save();


        $book_mark->delete();

     
        
        return response()->json([
            'success' => 'Bỏ theo dõi sách thành công'
        ]);
    }

    public function ratingBook(Request $request){

        $rating_book_score = ratingBook::where('bookID','=',$request->id)->pluck('score')->toArray();

        $book_rating = ratingBook::create([
            'bookID' => $request -> id,
            'userID' => Auth::user()->id,
            'score' => $request -> score
        ]);
        $book_rating ->save();
        array_push($rating_book_score,$request -> score);
        $rating_book_score = array_filter($rating_book_score, fn($x)=>$x !== '');
        $average = array_sum($rating_book_score)/count($rating_book_score);

        $book = Book::findOrFail($request->id);
        $book->ratingScore = round($average, 2);
    
        $book->save();
        return response()->json([
            'success' => 'Cảm ơn bạn đã đánh giá!!!!',
            'currentScore' => $book->ratingScore
        ]);
        
       
    }
}
