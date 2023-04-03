<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\bookMark;
use App\Models\Book;
use App\Models\Document;
use App\Models\ForumPosts;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    public function changeBookMarkStatus(Request $request){
        $bookMark = bookMark::findOrFail($request->id);
        $bookMark->status = 0;
        $bookMark ->save();
        
        $url = '/sach/'. $bookMark->books->id .'/' . $bookMark->books->slug;
        return response()->json([
            'url' => $url
        ]);

    }

    public function changeAllbookMarkStatus(){
        $bookMark = bookMark::where('userID','=',Auth::user()->id)->update([
            'status' => 0
        ]);

        return response()->json([
            'success' => 'Đánh dấu tất cả thông báo thành công!!!'
        ]);
       
    }

    
    public function changeStatus(Request $request){
        $notification = Notification::findOrFail($request->id);
        $notification->status = 0;
        $notification ->save();
        
        $option = $notification->type_id;

        $url = '';
        switch ($option) {
            case 1:
                $url = '/sach/'. $notification->identifier->id .'/' . $notification->identifier->slug;         
                break;
            case 2:
                $url = '/tai-lieu/'. $notification->identifier->id .'/' . $notification->identifier->slug;         
                break;
            case 3:
                $url = '/dien-dan/'. $notification->identifier->forums->slug .'/' . $notification->identifier->slug.'/'. $notification->identifier->id;         
                break;
            case 4:
                $url = '/sach/'. $notification->identifier->id .'/' . $notification->identifier->slug;         
                break;
            case 5:
                $url = '/tai-lieu/'. $notification->identifier->id .'/' . $notification->identifier->slug;         
                break;
            case 6:
                $url = '/dien-dan/'. $notification->identifier->forums->slug .'/' . $notification->identifier->slug.'/'. $notification->identifier->id;         
                break;
            default:
                $url = '';
        }
        
        return response()->json([
            'url' => $url
        ]);

    }

    public function changeAllStatus(){
        $notification = Notification::where('userID','=',Auth::user()->id)->update([
            'status' => 0
        ]);

        return response()->json([
            'success' => 'Đánh dấu tất cả thông báo thành công!!!'
        ]);
       
    }
    
}
