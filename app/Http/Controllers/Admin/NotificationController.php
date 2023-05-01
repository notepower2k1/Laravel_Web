<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Document;
use App\Models\Follow;
use App\Models\ForumPosts;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    public function changeFollowStatus(Request $request){
        $follow = Follow::findOrFail($request->id);
        $follow->status = 0;
        $follow ->save();

        $url = '';

        if($follow->type_id == 1){
            $url = '/tai-lieu/'. $follow->identifier->id .'/' . $follow->identifier->slug;
        }

        if($follow->type_id == 2){
            $url = '/sach/'. $follow->identifier->id .'/' . $follow->identifier->slug;
        }
        return response()->json([
            'url' => $url
        ]);

    }

    public function changeAllFollowStatus(){
        Follow::where('userID','=',Auth::user()->id)->update([
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
