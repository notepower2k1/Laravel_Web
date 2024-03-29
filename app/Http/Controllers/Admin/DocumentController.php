<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\downloadingHistory;
use App\Models\Follow;
use App\Models\Note;
use App\Models\Notification;
use App\Models\previewDocumentImages;
use App\Models\Reply;
use App\Models\report;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use ZipArchive;
use SimpleXMLElement;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class DocumentController extends Controller
{

    function TimeToText(){
        $now_date = Carbon::now()->toDateTimeString();
        $string = str_replace(' ', '-', $now_date);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);  
    }
    

    public function index()
    {
        
        $documents = Document::where('deleted_at','=',null)->whereIn('status',['1','-2'])->get();
       
       return view('admin.document.index')->with('documents', $documents);
    }
    public function deletedItem(){
        $documents = Document::where('deleted_at','!=',null)->where('status','=',1)->get();
       
       return view('admin.document.deleted')->with('documents', $documents);
    }

    public function recoveryItem(Request $request){

        $itemList = $request->data;

        //0 - document && 1 - Book
        foreach($itemList as $item){
            $document = Document::findOrFail($item);
            $document->deleted_at = null;
            $document->timestamps = false;
            $document ->save(); 

        
        }


    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = DocumentType::all();

        return view('admin.document.create')->with('types',$types);
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
            'file_document' => 'required|mimetypes:application/pdf',
            'description' => 'required',
            'image' => 'image|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            'language' => 'required',
            'author' => 'required',
            'isCompleted' => 'required',
        ],[
            'name.required' => 'Bạn cần phải nhập tên tài liệu',
            'author.required' => 'Bạn cần phải nhập tên tác giả',
            'description.required' => 'Bạn cần phải nhập mô tả tài liệu',
            'image.image' => 'Bạn nên đưa đúng định dạng ảnh bìa',
            'image.max' => 'Dung lượng ảnh quá lớn',
            'image.dimensions' => 'Kích thước ảnh nhỏ nhất là 100x100 và lớn nhất là 2000x2000',
            'file_document.required' => 'Tài liệu phải có file đính kèm',
            'file_document.mimetypes' => 'Tài liệu đình kèm nên là file .pdf',
            'isCompleted.required' => 'Tài liệu phải có tình trạng'
        ]);

    

        $slug =  Str::slug($request->name) .'-'. $this->TimeToText();
            
        $previewImagefiles = $request->file('previewImages');
        $image = $request->file('image'); //image file from frontend
        $document_file = $request->file('file_document');

       
        $generatedImageName = $slug.$image->hashName();
        $generatedFileName = $slug.$document_file->hashName();


        $numberOfPages = 0;

        if($document_file->extension() == 'pdf'){
            $path = $document_file->getContent();
            $numberOfPages = preg_match_all("/\/Page\W/", $path, $dummy);
        }
        
        if($document_file->extension() == 'docx'){
            $path = $document_file;
            $numberOfPages = $this->PageCount_DOCX($path);
        }


        $document_id = Document::insertGetId([
            'name' => $request->name,
            'description' => $request->description,
            'isPublic' => 0,
            'slug' =>  $slug,
            'type_id' => intval($request->document_type_id),
            'image' => $generatedImageName,
            'userCreatedID' => Auth::user()->id,
            'language' => $request -> language,
            'file' => $generatedFileName,
            'author' => $request -> author,
            'extension' =>  $request->file_document->extension(),
            'isCompleted' => $request -> isCompleted,
            'totalDownloading'=>0,
            'numberOfPages' => $numberOfPages,
            'status' =>1,
            'totalComments'=>0,
            "created_at" =>  \Carbon\Carbon::now(), 
            "updated_at" => \Carbon\Carbon::now(),
        ]);
        // upload image

        if($image){
            $firebase_storage_path = 'documentImage/';

            $uploadedfileImage = file_get_contents($request->file('image'));

            app('firebase.storage')->getBucket()->upload($uploadedfileImage, ['name' => $firebase_storage_path . $generatedImageName]);
            
        }
      
        //upload document
        $firebase_storage_document_path = 'documentFile/';
        $uploadedfile = file_get_contents($request->file('file_document'));
        app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_document_path . $generatedFileName]);
       

        //upload previewImage

        $firebase_storage_preview_path = 'documentPreviewImage/';
        foreach ($previewImagefiles as $previewImage){
            $generatedPreviewName =  $slug.$previewImage->hashName();          
            $image = previewDocumentImages::create([
                'image' => $generatedPreviewName,
                'documentID' => $document_id
            ]);
            $uploadedfilePreview = file_get_contents($previewImage);
            app('firebase.storage')->getBucket()->upload($uploadedfilePreview, ['name' => $firebase_storage_preview_path . $generatedPreviewName]);
          
        }
      

        return redirect('/admin/document');    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$year=null) //like "show details"
    {   
        DB::statement("SET SQL_MODE=''");
        $notes = Note::whereIn('type_id',['2','5'])->where('identifier_id','=',$id)->get();

        $allYears = DB::select("SELECT distinct year(documents.created_at) as 'year'
        from documents");

        $totalDownloadingPerMonth =  DB::select("SELECT 
        SUM(IF(month = 'Jan', total, 0)) AS 'Tháng 1', 
        SUM(IF(month = 'Feb', total, 0)) AS 'Tháng 2', 
        SUM(IF(month = 'Mar', total, 0)) AS 'Tháng 3', 
        SUM(IF(month = 'Apr', total, 0)) AS 'Tháng 4', 
        SUM(IF(month = 'May', total, 0)) AS 'Tháng 5', 
        SUM(IF(month = 'Jun', total, 0)) AS 'Tháng 6', 
        SUM(IF(month = 'Jul', total, 0)) AS 'Tháng 7', 
        SUM(IF(month = 'Aug', total, 0)) AS 'Tháng 8', 
        SUM(IF(month = 'Sep', total, 0)) AS 'Tháng 9', 
        SUM(IF(month = 'Oct', total, 0)) AS 'Tháng 10', 
        SUM(IF(month = 'Nov', total, 0)) AS 'Tháng 11', 
        SUM(IF(month = 'Dec', total, 0)) AS 'Tháng 12' 
        FROM ( 
            SELECT SUM(downloading_histories.total) as 'total' , DATE_FORMAT(downloading_histories.created_at, '%b') AS month
            FROM downloading_histories 
            WHERE downloading_histories.documentID = $id and YEAR(downloading_histories.created_at) = $year
            GROUP by downloading_histories.documentID,DATE_FORMAT(downloading_histories.created_at, '%m-%Y')
        ) as sub");


        $totalDownloadingInYear = downloadingHistory::where('documentID','=',$id)->whereYear('created_at', '=', $year)->sum('total');


        $totalDownloadingPerDate = DB::select("SELECT SUM(downloading_histories.total) as 'total', DATE(downloading_histories.created_at) as 'date'
        from downloading_histories 
        WHERE downloading_histories.documentID = $id and YEAR(downloading_histories.created_at) = $year
        GROUP by downloading_histories.documentID,DATE(downloading_histories.created_at)");

        $document = Document::findOrFail($id);

        $downloadHistory = downloadingHistory::where('documentID','=',$id)->get();

        $previewImages = previewDocumentImages::where('documentID','=',$id)->get();



        $comments = Comment::where('type_id','=',1)->where('identifier_id','=',$id)->whereYear('created_at', '=', $year)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->get();

        

        $totalCommentsPerMonth =  DB::select("SELECT 
              SUM(IF(month = 'Jan', total, 0)) AS 'Tháng 1', 
              SUM(IF(month = 'Feb', total, 0)) AS 'Tháng 2', 
              SUM(IF(month = 'Mar', total, 0)) AS 'Tháng 3', 
              SUM(IF(month = 'Apr', total, 0)) AS 'Tháng 4', 
              SUM(IF(month = 'May', total, 0)) AS 'Tháng 5', 
              SUM(IF(month = 'Jun', total, 0)) AS 'Tháng 6', 
              SUM(IF(month = 'Jul', total, 0)) AS 'Tháng 7', 
              SUM(IF(month = 'Aug', total, 0)) AS 'Tháng 8', 
              SUM(IF(month = 'Sep', total, 0)) AS 'Tháng 9', 
              SUM(IF(month = 'Oct', total, 0)) AS 'Tháng 10', 
              SUM(IF(month = 'Nov', total, 0)) AS 'Tháng 11', 
              SUM(IF(month = 'Dec', total, 0)) AS 'Tháng 12' 
              FROM ( 
                  SELECT COUNT(comments.id) as 'total' ,DATE_FORMAT(comments.created_at, '%b') AS month
                  FROM comments 
                  WHERE comments.type_id = 1 and comments.identifier_id = $id and YEAR(comments.created_at) = $year and comments.deleted_at is null
                  GROUP by DATE_FORMAT(comments.created_at, '%m-%Y')
        ) as sub");


        $totalRepliesPerMonth =  DB::select("SELECT 
        SUM(IF(month = 'Jan', total, 0)) AS 'Tháng 1', 
        SUM(IF(month = 'Feb', total, 0)) AS 'Tháng 2', 
        SUM(IF(month = 'Mar', total, 0)) AS 'Tháng 3', 
        SUM(IF(month = 'Apr', total, 0)) AS 'Tháng 4', 
        SUM(IF(month = 'May', total, 0)) AS 'Tháng 5', 
        SUM(IF(month = 'Jun', total, 0)) AS 'Tháng 6', 
        SUM(IF(month = 'Jul', total, 0)) AS 'Tháng 7', 
        SUM(IF(month = 'Aug', total, 0)) AS 'Tháng 8', 
        SUM(IF(month = 'Sep', total, 0)) AS 'Tháng 9', 
        SUM(IF(month = 'Oct', total, 0)) AS 'Tháng 10', 
        SUM(IF(month = 'Nov', total, 0)) AS 'Tháng 11', 
        SUM(IF(month = 'Dec', total, 0)) AS 'Tháng 12' 
        FROM ( 
            SELECT COUNT(replies.id) as 'total' ,DATE_FORMAT(replies.created_at, '%b') AS month
            FROM replies 
            WHERE YEAR(replies.created_at) = $year and replies.deleted_at is null and replies.commentID in (SELECT DISTINCT id from comments where comments.type_id = 1 and comments.identifier_id = $id)
            GROUP by DATE_FORMAT(replies.created_at, '%m-%Y')
        ) as sub");


        $totalCommentsInYear = Comment::where('identifier_id','=',$id)->where('type_id','=',1)->whereYear('created_at', '=', $year)->count();

        $totalRepliesInYear = DB::select("SELECT count(replies.id) as 'total'
        from replies 
        WHERE YEAR(replies.created_at) = $year and replies.deleted_at is null and replies.commentID in (select DISTINCT id from comments 
        where comments.type_id = 1 and comments.identifier_id = $id)");


        $totalCommentsPerDate = DB::select("SELECT  COUNT(comments.id) as 'total', DATE(comments.created_at) as 'date'
        from comments 
        WHERE comments.type_id = 1 and comments.identifier_id = $id and YEAR(comments.created_at) = $year and comments.deleted_at is null
        GROUP by DATE(comments.created_at)");
        

        $totalRepliesPerDate = DB::select("SELECT  COUNT(replies.id) as 'total', DATE(replies.created_at) as 'date'
        from replies 
        WHERE YEAR(replies.created_at) = $year and replies.deleted_at is null and replies.commentID in (SELECT DISTINCT id from comments where comments.type_id = 1 and comments.identifier_id = $id)
        GROUP by DATE(replies.created_at)");
        

        return view('admin.document.detail')
        ->with('comments',$comments)

        ->with('notes',$notes)
        ->with('totalDownloadingInYear',$totalDownloadingInYear)
        ->with('totalDownloadingPerDate',$totalDownloadingPerDate)
        ->with('totalDownloadingPerMonth',$totalDownloadingPerMonth)

        ->with('totalCommentsPerMonth',$totalCommentsPerMonth)
        ->with('totalCommentsPerDate',$totalCommentsPerDate)
        ->with('totalCommentsInYear',$totalCommentsInYear)

        ->with('totalRepliesInYear',$totalRepliesInYear[0])
        ->with('totalRepliesPerMonth',$totalRepliesPerMonth)
        ->with('totalRepliesPerDate',$totalRepliesPerDate)

        ->with('allYears',$allYears)
        ->with('statisticsYear',$year)
        ->with('downloadHistory',$downloadHistory)
        ->with('previewImages',$previewImages)
        ->with('document',$document);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $document = Document::findOrFail($id);
        $types = DocumentType::all();


        return view('admin.document.edit')
        ->with('document',$document)
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
            'description' => 'required',
            'image' => 'image|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            'author' => 'required',
            'isCompleted' => 'required'

        ],[
            'name.required' => 'Bạn cần phải nhập tên tài liệu',
            'author.required' => 'Bạn cần phải nhập tên tác giả',
            'description.required' => 'Bạn cần phải nhập mô tả tài liệu',
            'image.image' => 'Bạn nên đưa đúng định dạng ảnh bìa',
            'image.max' => 'Dung lượng ảnh quá lớn',
            'image.dimensions' => 'Kích thước ảnh nhỏ nhất là 100x100 và lớn nhất là 2000x2000',
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


            $firebase_storage_path = 'documentImage/';

            $uploadedfileImage = file_get_contents($request->file('image'));

      
            app('firebase.storage')->getBucket()->upload($uploadedfileImage, ['name' => $firebase_storage_path . $generatedImageName]);

            //delete old image

            
            $OldimageDeleted = app('firebase.storage')->getBucket()->object($firebase_storage_path.$request->oldImage)->delete();
 
            
        }

     
        $document = Document::findOrFail($id)
                ->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'slug' =>  $slug,
                    'type_id' => intval($request->document_type_id),
                    'image' => $generatedImageName,
                    'isCompleted' => $request->isCompleted,
                ]);

        Follow::where('type_id','=',1)->where('identifier_id','=',$request->id)->where('isDone','=',1)->update([
            'status' => 1
        ]);
        
        return redirect('/admin/document');
       
    }

  

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $document = Document::findOrFail($id);
    //     $document->delete();

    //     return response()->json([
    //         'success' => 'Record deleted successfully!'
    //     ]);
    // }

    public function customDelete($document_id){
        $document = Document::findOrFail($document_id);
        $document->deleted_at = Carbon::now()->toDateTimeString();
        $document->totalComments = 0;
        $document->totalDocumentMarking = 0;
        $document ->save();

     

        $comments = Comment::where('identifier_id','=',$document_id)->where('type_id','=','1')->get();

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

        Comment::where('identifier_id','=',$document_id)->where('type_id','=','1')->update([
            'deleted_at' => Carbon::now()->toDateTimeString()
        ]);
        
        $follows = Follow::where('identifier_id','=',$document_id)->where('type_id','=','1')->get();

        foreach($follows as $follow){
            $follow->delete();
        }

        report::where('identifier_id','=',$document_id)->where('type_id','=','3')->update([
            'status' => 0
        ]);
    }   


    public function changeDocumentStatus(Request $request){
        $document = Document::findOrFail($request->id);
        $document->isPublic = $request->isPublic;
        $document ->save();

        
    }

    public function statistics_document_page($year = null){
        DB::statement("SET SQL_MODE=''");
            
        $allYears = DB::select("SELECT distinct year(documents.created_at) as 'year'
        from documents");

        $totalByTypes = DB::select("SELECT Count(documents.id) as 'total', document_types.name 
        from documents join document_types on documents.type_id = document_types.id 
        where documents.deleted_at is null
        GROUP by document_types.name");

        
        if($year == null){

            $year = Carbon::now()->year;
        }
        $totalDocumentsPerMonth = DB::select("SELECT 
            SUM(IF(month = 'Jan', total, 0)) AS 'Tháng 1', 
            SUM(IF(month = 'Feb', total, 0)) AS 'Tháng 2', 
            SUM(IF(month = 'Mar', total, 0)) AS 'Tháng 3', 
            SUM(IF(month = 'Apr', total, 0)) AS 'Tháng 4', 
            SUM(IF(month = 'May', total, 0)) AS 'Tháng 5', 
            SUM(IF(month = 'Jun', total, 0)) AS 'Tháng 6', 
            SUM(IF(month = 'Jul', total, 0)) AS 'Tháng 7', 
            SUM(IF(month = 'Aug', total, 0)) AS 'Tháng 8', 
            SUM(IF(month = 'Sep', total, 0)) AS 'Tháng 9', 
            SUM(IF(month = 'Oct', total, 0)) AS 'Tháng 10', 
            SUM(IF(month = 'Nov', total, 0)) AS 'Tháng 11', 
            SUM(IF(month = 'Dec', total, 0)) AS 'Tháng 12' 
            FROM ( 
                SELECT DATE_FORMAT(documents.created_at, '%b') AS month, 
                COUNT(documents.id) as total FROM documents 
                WHERE Year(documents.created_at) = $year  and documents.deleted_at is null

                GROUP BY DATE_FORMAT(documents.created_at, '%m-%Y')
        ) as sub");
        
        $totalDocumentsInYear = Document::whereYear('created_at', '=', $year)->where('deleted_at','=',null)->get();

        $totalDocumentsPerDate = DB::select("SELECT Count(documents.id) as 'total', DATE(documents.created_at) as 'date'
        from documents 
        WHERE YEAR(documents.created_at) = $year and documents.deleted_at is null
        GROUP by  DATE(documents.created_at)");
        
        $totalDownloadingPerMonth =  DB::select("SELECT 
        SUM(IF(month = 'Jan', total, 0)) AS 'Tháng 1', 
        SUM(IF(month = 'Feb', total, 0)) AS 'Tháng 2', 
        SUM(IF(month = 'Mar', total, 0)) AS 'Tháng 3', 
        SUM(IF(month = 'Apr', total, 0)) AS 'Tháng 4', 
        SUM(IF(month = 'May', total, 0)) AS 'Tháng 5', 
        SUM(IF(month = 'Jun', total, 0)) AS 'Tháng 6', 
        SUM(IF(month = 'Jul', total, 0)) AS 'Tháng 7', 
        SUM(IF(month = 'Aug', total, 0)) AS 'Tháng 8', 
        SUM(IF(month = 'Sep', total, 0)) AS 'Tháng 9', 
        SUM(IF(month = 'Oct', total, 0)) AS 'Tháng 10', 
        SUM(IF(month = 'Nov', total, 0)) AS 'Tháng 11', 
        SUM(IF(month = 'Dec', total, 0)) AS 'Tháng 12' 
        FROM ( 
            SELECT DATE_FORMAT(downloading_histories.created_at, '%b') AS month, 
            SUM(downloading_histories.total) as total FROM downloading_histories 
            WHERE Year(downloading_histories.created_at) = $year
            GROUP BY DATE_FORMAT(downloading_histories.created_at, '%m-%Y')
        ) as sub");

        
        $totalDownloadingInYear = downloadingHistory::whereYear('created_at', '=', $year)->sum('total');


        $totalDownloadingPerDate = DB::select("SELECT SUM(downloading_histories.total) as 'total', DATE(downloading_histories.created_at) as 'date'
        from downloading_histories 
        WHERE YEAR(downloading_histories.created_at) = $year
        GROUP by DATE(downloading_histories.created_at)");

        $totalDocuments = Document::where('deleted_at',null)->get()->count();

         return view('admin.document.statistics')
            ->with('totalDocuments',$totalDocuments)
            ->with('allYears',$allYears)
            ->with('totalDocumentsInYear',$totalDocumentsInYear->count())
            ->with('totalDownloadingInYear',$totalDownloadingInYear)
            ->with('totalDocumentsPerDate',$totalDocumentsPerDate)
            ->with('statisticsYear',$year)
            ->with('totalDocumentsPerMonth',$totalDocumentsPerMonth)
            ->with('totalDownloadingPerMonth',$totalDownloadingPerMonth)
            ->with('totalDownloadingPerDate',$totalDownloadingPerDate)
            ->with('totalByTypes', $totalByTypes);
            
    }

    public function decodeDate($date){
        
        $temp = substr_replace($date,"-",4,0);
        $temp = substr_replace($temp,"-",7,0);
        return $temp;
    }


    public function getFilterValue($fromDate,$toDate){

        
        $start_date = new Carbon($this->decodeDate($fromDate));
        $end_date = new Carbon($this->decodeDate($toDate));

        $documents = Document::whereBetween('created_at', [$start_date, $end_date])->where('deleted_at','=',null)->where('status','=',1)->get();
        
        return view('admin.document.index')
        ->with('fromDate',$start_date->format('m/d/Y'))
        ->with('toDate',$end_date->format('m/d/Y'))
        ->with('documents', $documents);


    }

    public function getFilterValueDeleted($fromDate,$toDate){

        
        $start_date = new Carbon($this->decodeDate($fromDate));
        $end_date = new Carbon($this->decodeDate($toDate));

        $documents = Document::whereBetween('deleted_at', [$start_date, $end_date])->where('deleted_at','!=',null)->where('status','=',1)->get();
        
        return view('admin.document.deleted')
        ->with('fromDate',$start_date->format('m/d/Y'))
        ->with('toDate',$end_date->format('m/d/Y'))
        ->with('documents', $documents);


    }

    public function lockDocument($id){
        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $document = Document::findOrFail($id);
        $status = $document->status;

        if($status == -2){
            $document->status = 1;
        

            Notification::create([
                'identifier_id'=>$id,
                'type_id'=> 11, 
                'senderID' => 1,
                'receiverID'=>$document->users->id,
                'status'=>1
            ]);


            $receiverID = $document->users->id;
            
            $pusher->trigger('private_notify_'.$receiverID, 'send-notify', $receiverID);
        }
        else{
            $document->status = -2;

            $comments = Comment::where('identifier_id','=',$id)->where('type_id','=','1')->get();

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
    
            Comment::where('identifier_id','=',$id)->where('type_id','=','1')->update([
                'deleted_at' => Carbon::now()->toDateTimeString()
            ]);
            
            report::where('identifier_id','=',$id)->where('type_id','=','3')->update([
                'status' => 0
            ]);

            Notification::create([
                'identifier_id'=>$id,
                'type_id'=> 9, 
                'senderID' => 1,
                'receiverID'=>$document->users->id,
                'status'=>1
            ]);

            $receiverID = $document->users->id;
            
            $pusher->trigger('private_notify_'.$receiverID, 'send-notify', $receiverID);
        }

        $document->save();

        return response()->json([
            'status' => $document->status,
        ]);
    }
}
