<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Document;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
   
    public function wait_verification(){
        $books = Book::where('deleted_at','=',null)->where('status','=',0)->get();
        $documents = Document::where('deleted_at','=',null)->where('status','=',0)->get();

        return view('admin.other.wait_verification')
        ->with('documents',$documents)
        ->with('books', $books);   
    }

    public function verification_item(Request $request){

        $itemList = $request->data;

        //0 - document && 1 - Book
        foreach($itemList as $item){

            if($item['option'] == "0"){
                $document = Document::findOrFail($item['id']);
                $document->status = 1;
                $document ->save();
            }
            else if($item['option'] == "1"){
                $book = Book::findOrFail($item['id']);
                $book->status = 1;
                $book ->save();
            }
        }


    }
    public function rejection_item(Request $request){
        $itemList = $request->data;

        //0 - document && 1 - Book
        foreach($itemList as $item){

            if($item['option'] == "0"){
                $document = Document::findOrFail($item['id']);
                $document->status = -1;
                $document ->save();
            }
            else if($item['option'] == "1"){
                $book = Book::findOrFail($item['id']);
                $book->status = -1;
                $book ->save();
            }
        }
    }
    public function index(){
        return view('admin.dashboard');

       
    }
}
