<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Document;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientFollowController extends Controller
{
    public function following(Request $request){

        $type = $request->type_id;

        Follow::create([
            'identifier_id' => $request -> item_id,
            'type_id' => $type,
            'userID' => Auth::user()->id
        ]);

        $totalMarking = 0;

        if($type == 1){
            $document = Document::findOrFail($request -> item_id);
            $document->totalDocumentMarking = $document->totalDocumentMarking + 1;
            $document->save();

            $totalMarking = $document->totalDocumentMarking;
        }
        if($type == 2){
            $book = Book::findOrFail($request -> item_id);
            $book->totalBookMarking = $book->totalBookMarking + 1;
            $book->save();

            $totalMarking = $book->totalBookMarking;

        }

        return response()->json([
            'success' => 'Bạn đã theo dõi thành công!!!',
            'totalBookMarking' => $totalMarking
        ]);
    }

    public function stopFollowing($id){
        $follow = Follow::findOrFail($id);

        if($follow->type_id == 1){
            $document = Document::findOrFail($follow -> identifier_id);
            $document->totalDocumentMarking = $document->totalDocumentMarking - 1;
            $document->save();
        }

        if($follow->type_id == 2){
            $book = Book::findOrFail($follow -> identifier_id);
            $book->totalBookMarking = $book->totalBookMarking - 1;
            $book->save();
        }


        $follow->delete();

     
        
        return response()->json([
            'success' => 'Bỏ theo dõi thành công'
        ]);
    }
}
