<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\bookMark;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    public function changebookMarkStatus(Request $request){
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
        
        $url = '/sach/'. $notification->chapters->books->id .'/' . $notification->chapters->books->slug;
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
