<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;

class ClientDashboard extends Controller
{
    public function index(){
        $waiting_books = Book::where('userCreatedID','=',Auth::user()->id)->where('deleted_at','=',null)->where('status','!=',1)->get();
        $waiting_documents = Document::where('userCreatedID','=',Auth::user()->id)->where('deleted_at','=',null)->where('status','!=',1)->get();
        
        $high_reading_book = Book::where('userCreatedID','=',Auth::user()->id)->where('deleted_at','=',null)->where('status','=',1)->get()->sortByDesc('totalReading')->first();
        $high_downloading_document = Document::where('userCreatedID','=',Auth::user()->id)->where('deleted_at','=',null)->where('status','=',1)->get()->sortByDesc('totalDownloading')->first();
        
        $name_search = Book::where('userCreatedID','=',Auth::user()->id)->where('deleted_at','=',null)->where('status','=',1)->get(['name','id']);
        $document_search = Document::where('userCreatedID','=',Auth::user()->id)->where('deleted_at','=',null)->where('status','=',1)->get(['name','id']);

        return view('client.manage.manage-homepage')
        ->with('high_reading_book',$high_reading_book)
        ->with('high_downloading_document',$high_downloading_document)
        ->with('name_search',$name_search)
        ->with('document_search',$document_search)
        ->with('documents',$waiting_documents)
        ->with('books', $waiting_books);   

    }

    public function re_verified(Request $request){

        $option = $request->option;

        $item_id = $request->item_id;

        if($option == 1){
            $document = Document::findOrFail($item_id);
            $document->status = 0;
            $document->save();
        }
        if($option == 2){
            $book = Book::findOrFail($item_id);
            $book->status = 0;
            $book->save();
        }

        return response()->json(['message' => 'Gửi xét duyệt lại thành công!!!']);
    }   

    public function searchInfoByName(Request $request){
        $option = $request->option;
        $id = $request->id;
        $item = '';


        if($option == '2'){
            $book = Book::findOrFail($id);

            $language = '';
            if($book->language == 1){
                $language = '<span class="text-success">Tiếng việt</span>';
            }
            else{
                $language = '<span class="text-info">Tiếng anh</span>';
            }

            $item = '<div class="nk-files nk-files-view-group">'.
                       ' <div class="card card-bordered">'.
                           ' <div class="card-inner">'.
                                '<div class="row">'.
                                    '<div class="col-lg-4">'.
                                    
                                          '  <img src="'.$book->url.'" class="w-100" alt="">   '  .                                
                                     
                                    ' </div>'.
                                    ' <div class="col-lg-8">'.
                                       '<div class="product-info mb-5 me-xxl-5">'.
                                           '<h2 class="product-title">'.$book->name.                                             
                                            '</h2>'   .                                                      
                                           ' <p class="product-title">Tác giả: '.$book->author.'</p>'  .        
                                           ' <div class="product-meta">'.
                                              '  <h6 class="title">Ngôn ngữ: '.
                                                  '  '.$language.''.
                                             '   </h6>'.
                                              
                                           ' </div>     '  .                  
                                           ' <div class="product-meta">'.
                                              '  <h6 class="title">Thể loại</h6>  '.                                
                                                '<span class="text-success">'.$book->types->name.'</span>'.
                                            '</div>  '.      
                                            '<div class="product-meta">'.
                                                '<h6 class="title">Số chương</h6>'.
                                                '<span class="text-success">'.$book->numberOfChapter.'</span>'.
                                            '</div>     '.                                  
                                            '<div class="product-meta">'.
                                                '<h6 class="title">Đánh giá</h6>'.
                                                '<span class="text-success">'.$book->ratingScore.'</span>'.
                                            '</div>  '.                     
                                            '<div class="product-meta">'.
                                                '<h6 class="title">Lượt đọc</h6>'.
                                                '<span class="text-success">'.$book->totalReading.'</span>'.
                                            '</div> '.
                                            '<div class="product-meta">'.
                                                '<h6 class="title">Số bình luận</h6>'.
                                                '<span class="text-success">'.$book->totalComments.'</span>'.
                                            '</div>'.
                                            '<div class="product-meta">'.
                                                '<h6 class="title">Lượt theo dõi</h6>'.
                                                '<span class="text-success">'.$book->totalBookMarking.'</span>'.
                                            '</div>'.
                                        '</div>    '.                                
                                   '</div>'.
                                '</div>       '.                                
                            '</div>'.
                        '</div>'.
                      
                    '</div>';

        }
        if($option == '1'){
            $document = Document::findOrFail($id);
            $language = '';

            if($document->language == 1){
                $language = '<span class="text-success">Tiếng việt</span>';
            }
            else{
                $language = '<span class="text-info">Tiếng anh</span>';
            }

            $item = '<div class="nk-files nk-files-view-group">'.
            ' <div class="card card-bordered">'.
                ' <div class="card-inner">'.
                     '<div class="row">'.
                         '<div class="col-lg-4">'.
                         
                               '  <img src="'.$document->url.'" class="w-100" alt="">   '  .                                
                          
                         ' </div>'.
                         ' <div class="col-lg-8">'.
                            '<div class="product-info mb-5 me-xxl-5">'.
                                '<h2 class="product-title">'.$document->name.                                             
                                 '</h2>'   .                                                      
                                ' <p class="product-title">Tác giả: '.$document->author.'</p>'  .        
                                ' <div class="product-meta">'.
                                   '  <h6 class="title">Ngôn ngữ: '.
                                       '  '.$language.''.
                                  '   </h6>'.
                                   
                                ' </div>     '  .                  
                                ' <div class="product-meta">'.
                                   '  <h6 class="title">Thể loại</h6>  '.                                
                                     '<span class="text-success">'.$document->types->name.'</span>'.
                                 '</div>  '.      
                                 '<div class="product-meta">'.
                                     '<h6 class="title">Số trang</h6>'.
                                     '<span class="text-success">'.$document->numberOfPages.'</span>'.
                                 '</div>     '.                                                                             
                                 '<div class="product-meta">'.
                                     '<h6 class="title">Lượt tải</h6>'.
                                     '<span class="text-success">'.$document->totalDownloading.'</span>'.
                                 '</div> '.
                                 '<div class="product-meta">'.
                                     '<h6 class="title">Số bình luận</h6>'.
                                     '<span class="text-success">'.$document->totalComments.'</span>'.
                                 '</div>'.
                                 '<div class="product-meta">'.
                                    '<h6 class="title">File đỉnh kèm</h6>'.
                                    '<a href="'.$document->documentUrl.'">'.
                                                           ' file.'.$document->extension.''.
                                    ' </a>'.
                                '</div>'.
                                '<div class="product-meta">'.
                                    '<h6 class="title">Lượt theo dõi</h6>'.
                                    '<span class="text-success">'.$document->totalDocumentMarking.'</span>'.
                                '</div>'.
                             '</div>    '.                                
                        '</div>'.
                     '</div>       '.                                
                 '</div>'.
             '</div>'.
           
         '</div>';
        }

        return response()->json(['res' => $item]);
    }
}
