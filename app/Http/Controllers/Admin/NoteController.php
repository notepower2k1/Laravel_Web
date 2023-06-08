<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Document;
use App\Models\ForumPosts;
use App\Models\Note;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function calendar_page(){
        $today = Carbon::now()->toDateString();

        return view('admin.other.calendar')->with('today',$today);
    }
    public function getObject(Request $request){
        $option = $request->type_id;
        $identifier = collect();


        switch ($option) {
            case 1:
                $identifier = Book::where('deleted_at',null)->where('status','=',0)->get(['id','name']);        
                break;
            case 2:
                $identifier = Document::where('deleted_at',null)->where('status','=',0)->get(['id','name']);
                break;
            case 3:
                $identifier = User::where('deleted_at',null)->where('email_verified_at','!=',null)->get(['id','name']);  
        
                break;

            case 4:
                $identifier = Book::whereIn('status',['1','-2'])->get(['id','name']);        

                break;
            case 5:
                $identifier = Document::whereIn('status',['1','-2'])->get(['id','name']);
                break;

            default:
                $identifier = collect();
        }
        
        return response()->json(['res' => $identifier]);
    }

    public function create(Request $request){
        $request->validate([
            'content' => 'required',
            'identifier_id' => 'required',
            'type_id' => 'required',
        ],[
            'identifier_id.required' => 'Ghi chú nên có đối tượng',
            'type_id.required' => 'Ghi chú nên có loại đối tượng',
            'content.required' => 'Ghi chú nên có nội dung',
        ]);
        
        Note::create([
            'content' => $request->content,
            'identifier_id' =>  $request->identifier_id,
            'type_id' => $request->type_id,
        ]);

        return response()->json(['success'=>'Ghi chú thành công']);

    }


    public function delete($id){
        $note = Note::findOrFail($id);
        $note->delete();
        return response()->json([
            'success' => 'Xóa ghi chú thành công!'
        ]);
    }


    public function client_getRejectReason(Request $request) {

        $type_id = $request->type_id;
        $identifier_id = $request->identifier_id;

        $noteList = Note::where('type_id',$type_id)->where('identifier_id',$identifier_id)->get();


        $itemList = array();
        foreach ($noteList as $note){
            $item = 
                '<div class="bq-note-text">'.
                    '<p>'.$note->content.'</p>'.
                '</div>'.
                '<div class="bq-note-meta">'.
                    '<span class="bq-note-added">Thời gian: <span class="date">'. Carbon::parse($note->created_at) .'</span></span>'.
                '</div>';
            array_push($itemList,$item);
        }


        return response()->json(['res'=>$itemList]);
    }
}
