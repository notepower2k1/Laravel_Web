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

        return view('client.manage.manage-homepage')
        ->with('high_downloading_document',$high_downloading_document)
        ->with('high_reading_book',$high_reading_book)
        ->with('documents',$waiting_books)
        ->with('books', $waiting_documents);   

      
    }

}
