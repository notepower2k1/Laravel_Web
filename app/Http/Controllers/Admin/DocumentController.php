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
use Illuminate\Support\Facades\DB;


class DocumentController extends Controller
{

    function setNameForImage(){
        $now_date = Carbon::now()->toDateTimeString();
        $string = str_replace(' ', '-', $now_date);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);  
    }
    

    public function index()
    {
        
        $documents = Document::where('deleted_at','=',null)->where('status','=',1)->get();
       
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
            'file_document' => 'required|mimetypes:application/pdf',
            'description' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg|max:5048',
            'language' => 'required',
            'author' => 'required'
        ]);


        $slug =  Str::slug($request->name);
    
        $image = $request->file('image'); //image file from frontend
        $document_file = $request->file('file_document');

        $generatedImageName = '';
       
        $generatedImageName = 'image'.$this->setNameForImage().'-'
        .$slug.'.'
        .$request->image->extension();
        
   
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
            'numberOfPages' => $numberOfPages,
            'status' =>1,
            'totalComments'=>0


        ]);
        $document->save();
        // upload image

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
        $document = Document::findOrFail($id);

        return view('admin.document.detail')
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
            'image' => 'mimes:jpg,png,jpeg|max:5048',
            'author' => 'required',
            'isCompleted' => 'required'

        ]);

        $slug =  Str::slug($request->name);

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

     
        $document = Document::findOrFail($id)
                ->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'slug' =>  $slug,
                    'type_id' => intval($request->document_type_id),
                    'image' => $generatedImageName,
                    'isCompleted' => $request->isCompleted,
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
        $document ->save();
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
        
         return view('admin.document.statistics')
            ->with('allYears',$allYears)
            ->with('totalDocumentsInYear',$totalDocumentsInYear->count())
            ->with('totalDocumentsPerDate',$totalDocumentsPerDate)
            ->with('statisticsYear',$year)
            ->with('totalDocumentsPerMonth',$totalDocumentsPerMonth)
            ->with('totalByTypes', $totalByTypes);
            
    }
}
