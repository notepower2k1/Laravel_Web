<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Follow;
use App\Models\Notification;
use App\Models\previewDocumentImages;
use App\Models\Reply;
use App\Models\report;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use ZipArchive;
use SimpleXMLElement;
use Illuminate\Support\Str;

class ClientDocumentController extends Controller
{
    function TimeToText(){
        $now_date = Carbon::now()->toDateTimeString();
        $string = str_replace(' ', '-', $now_date);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);  
    }

 
    

    public function index()
    {
      
        $documents = Document::where('userCreatedID','=',Auth::user()->id)->where('deleted_at','=',null)->where('status','=',1)->get();
       
        return view('client.manage.document.index')->with('documents', $documents);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = DocumentType::all();

        return view('client.manage.document.create')->with('types',$types);
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


        $slug =  Str::slug($request->name).'-'. $this->TimeToText();
    
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
            'isCompleted' => 0,
            'totalDownloading'=>0,
            'numberOfPages' => $numberOfPages,
            'totalComments' => 0,
            'status' =>0,
            "created_at" =>  \Carbon\Carbon::now(), 
            "updated_at" => \Carbon\Carbon::now(),



        ]);
        //upload image

      
        if($image){
            $firebase_storage_path = 'documentImage/';

            $uploadedfileImage = file_get_contents($request->file('image'));

      
            app('firebase.storage')->getBucket()->upload($uploadedfileImage, ['name' => $firebase_storage_path . $generatedImageName]);
            
        }
      
        //upload document
        $firebase_storage_document_path = 'documentFile/';
        $uploadedfile = file_get_contents($request->file('file_document'));
        app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_document_path . $generatedFileName]);


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
        $document = Document::where('id','=',$id)->where('deleted_at','=',null)->firstOrFail();

        return view('client.manage.document.detail')
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
        $document = Document::where('id','=',$id)->where('deleted_at','=',null)->whereIn('status',['-1','1'])->firstOrFail();
        $types = DocumentType::all();


        return view('client.manage.document.edit')
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
        return redirect('/quan-ly/tai-lieu');

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

        Comment::where('identifier_id','=',$document_id)->where('type_id','=','1')->update([
            'deleted_at' => Carbon::now()->toDateTimeString()
        ]);

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


   
        $follows = Follow::where('identifier_id','=',$document_id)->where('type_id','=','1')->get();

        foreach($follows as $follow){
            $follow->delete();
        }
    }   

    public function changeDocumentStatus(Request $request){
        $document = Document::findOrFail($request->id);
        $document->isPublic = $request->isPublic;
        $document ->save();

        
    }
}
