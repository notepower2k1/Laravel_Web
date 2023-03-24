<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use ZipArchive;
use SimpleXMLElement;


class DocumentController extends Controller
{

    function setNameForImage(){
        $now_date = Carbon::now()->toDateTimeString();
        $string = str_replace(' ', '-', $now_date);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);  
    }
    

    public function index()
    {
        
        $documents = Document::all();
       
       return view('admin.document.index')->with('documents', $documents);
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
            'file_document' => 'required|mimetypes:application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf',
            'description' => 'required',
            'image' => 'mimes:jpg,png,jpeg|max:5048',
            'language' => 'required',
            'author' => 'required'
        ]);


        $slug =  Str::slug($request->name);
    
        $image = $request->file('image'); //image file from frontend
        $document_file = $request->file('file_document');

        $generatedImageName = '';
        if($image == null){
            if($document_file->extension() == 'pdf'){
                $generatedImageName = 'default_pdf.jpg';
            }
            if($document_file->extension() == 'docx' || $document_file->extension() == 'doc'){
                $generatedImageName = 'default_docx.jpg';
            }
        }
        else{
            $generatedImageName = 'image'.$this->setNameForImage().'-'
            .$slug.'.'
            .$request->image->extension();
        }
   
        $generatedFileName = $this->setNameForImage() . '-' . $slug . '.' . $request->file_document->extension();

        $numberOfPages = 0;

        if($document_file->extension() == 'pdf'){
            $path = $document_file->getContent();
            $numberOfPages = preg_match_all("/\/Page\W/", $path, $dummy);
        }
        
        if($document_file->extension() == 'docx'){
            $path = $document_file;
            $numberOfPages = $this->PageCount_DOCX($path);
        }


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
            'totalDownloading'=>0,
            'numberOfPages' => $numberOfPages

        ]);
        $document->save();
        //upload image

        if($image){
            $firebase_storage_path = 'documentImage/';
            $localfolder = public_path('firebase-temp-uploads') .'/';
            if ($image->move($localfolder, $generatedImageName)) {
            $uploadedfile = fopen($localfolder.$generatedImageName, 'r');
    
            app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $generatedImageName]);
            unlink($localfolder . $generatedImageName);
            }
        }
      
        //upload document
        $firebase_storage_document_path = 'documentFile/';
        $localfolder = public_path('firebase-temp-uploads') .'/';
        if ($document_file->move($localfolder, $generatedFileName)) {
        $uploadedfile = fopen($localfolder.$generatedFileName, 'r');

        app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_document_path . $generatedFileName]);
        unlink($localfolder . $generatedFileName);
        }
        return redirect('/admin/document');    
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
            'file_document' => 'mimetypes:application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'description' => 'required',
            'image' => 'mimes:jpg,png,jpeg|max:5048',
            'author' => 'required',
            'isCompleted' => 'required'

        ]);

        $slug =  Str::slug($request->name);

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

            if (strcmp($request->oldImage,'default_pdf.jpg') == 0 || strcmp($request->oldImage,'default_docx.jpg') == 0 ){
                
            }
            else{
                $OldimageDeleted = app('firebase.storage')->getBucket()->object($firebase_storage_path.$request->oldImage)->delete();
            }
           

            }
        }

        $numberOfPages = 0;
        if($request->file_document == null){
            $generatedFileName = $request->oldFile;
            $numberOfPages = $request->oldNumberOfPages;

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

            if($document_file->extension() == 'pdf'){
                $path = $document_file->getContent();
                $numberOfPages = preg_match_all("/\/Page\W/", $path, $dummy);
            }
            
            if($document_file->extension() == 'docx'){
                $path = $document_file;
                $numberOfPages = $this->PageCount_DOCX($path);
            }
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
                    'extension' => $file_extension,
                    'numberOfPages' => $numberOfPages
                ]);


        return redirect('/admin/document');
       
    }

    function PageCount_DOCX($file) {
        $pageCount = 0;
    
        $zip = new ZipArchive();
    
        if($zip->open($file) === true) {
            if(($index = $zip->locateName('docProps/app.xml')) !== false)  {
                $data = $zip->getFromIndex($index);
                $xml = new SimpleXMLElement($data);
                $pageCount = $xml->Pages;
            }
            $zip->close();
        }
    
        return $pageCount;
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
