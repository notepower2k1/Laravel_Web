<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ClientDocumentController extends Controller
{

    function setNameForImage(){
        $now_date = Carbon::now()->toDateTimeString();
        $string = str_replace(' ', '-', $now_date);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);  
    }
    

    public function index()
    {
      
        $documents = Document::where('userCreatedID','=',Auth::user()->id)->get();
       
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
            'file_document' => 'required|mimetypes:application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf',
            'description' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg|max:5048',
            'language' => 'required',
            'author' => 'required'
        ]);


        $slug =  $this->slugify($request->name);
    
        $image = $request->file('image'); //image file from frontend
        $document_file = $request->file('file_document');

        $generatedImageName = 'image'.$this->setNameForImage().'-'
        .$slug.'.'
        .$request->image->extension();
        $generatedFileName = $this->setNameForImage() . '-' . $slug . '.' . $request->file_document->extension();

        $document = Document::create([
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
            'totalDownloading'=>0
        ]);
        $document->save();
        //upload image
        $firebase_storage_path = 'documentImage/';
        $localfolder = public_path('firebase-temp-uploads') .'/';
        if ($image->move($localfolder, $generatedImageName)) {
        $uploadedfile = fopen($localfolder.$generatedImageName, 'r');

        app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $generatedImageName]);
        unlink($localfolder . $generatedImageName);
        }
        //upload document
        $firebase_storage_document_path = 'documentFile/';
        $localfolder = public_path('firebase-temp-uploads') .'/';
        if ($document_file->move($localfolder, $generatedFileName)) {
        $uploadedfile = fopen($localfolder.$generatedFileName, 'r');

        app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_document_path . $generatedFileName]);
        unlink($localfolder . $generatedFileName);
        }
        return redirect('/quan-ly/tai-lieu');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) //like "show details"
    {
        // $book = Book::findOrFail($id);

        // return view('admin.book.detail')
        // ->with('book',$book);
        
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
            'file_document' => 'mimetypes:application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf',
            'description' => 'required',
            'image' => 'mimes:jpg,png,jpeg|max:5048',
            'author' => 'required',
            'isCompleted' => 'required'

        ]);

        $slug =  $this->slugify($request->name);

        $generatedImageName="";

        $generatedFileName="";

        if($request->image == null){
            $generatedImageName = $request->oldImage;
        }
        else{
            $image = $request->file('image'); //image file from frontend

            //upload new image
            $generatedImageName = 'image'.$this->setNameForImage().'-'
            .$slug.'.'
            .$request->image->extension();

            $firebase_storage_path = 'documentImage/';

            $localfolder = public_path('firebase-temp-uploads') .'/';
            if ($image->move($localfolder, $generatedImageName)) {
            $uploadedfile = fopen($localfolder.$generatedImageName, 'r');

            app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $generatedImageName]);
            unlink($localfolder . $generatedImageName);

            //delete old image

            $OldimageDeleted = app('firebase.storage')->getBucket()->object($firebase_storage_path.$request->oldImage)->delete();

            }
        }

        if($request->file_document == null){
            $generatedFileName = $request->oldFile;
        }
        else{
            $document_file = $request->file('file_document');



            $generatedFileName = $this->setNameForImage() . '-' . $slug . '.' . $request->file_document->extension();


            $firebase_storage_document_path = 'documentFile/';
            $localfolder = public_path('firebase-temp-uploads') .'/';
            if ($document_file->move($localfolder, $generatedFileName)) {
            $uploadedfile = fopen($localfolder.$generatedFileName, 'r');
    
            app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_document_path . $generatedFileName]);
            unlink($localfolder . $generatedFileName);
            }


            $oldfileDelete = app('firebase.storage')->getBucket()->object($firebase_storage_document_path.$request->oldFile)->delete();

        }

        $tmp = explode('.', $generatedFileName);

        $file_extension = end($tmp);

        $document = Document::findOrFail($id)
                ->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'slug' =>  $slug,
                    'type_id' => intval($request->document_type_id),
                    'image' => $generatedImageName,
                    'file' => $generatedFileName,
                    'isCompleted' => $request->isCompleted,
                    'extension' => $file_extension
                ]);
        return redirect('/quan-ly/tai-lieu');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        $document->delete();

        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    public function changeDocumentStatus(Request $request){
        $document = Document::findOrFail($request->id);
        $document->isPublic = $request->isPublic;
        $document ->save();

        
    }
}
