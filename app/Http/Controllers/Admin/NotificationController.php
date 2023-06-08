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
use Illuminate\Support\Facades\DB;

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
        $follows =  Follow::where('userID','=',Auth::user()->id)->get();

        foreach($follows as $follow){
            $follow ->status = 0;
            $follow->timestamps = false;
        }

        return response()->json([
            'success' => 'Đánh dấu tất cả thông báo thành công!!!'
        ]);
       
    }

    
    public function changeStatus(Request $request){
        $notification = Notification::findOrFail($request->id);
        // $notification->status = 0;
        // $notification ->save();
        
        $type = $notification->type_id;

        $url = '';

        if($type == 1){
            switch ($notification->identifier->type_id) {
                case 1:
                    $url = '/tai-lieu/'. $notification->identifier->identifier->id .'/' . $notification->identifier->identifier->slug;         
                    break;
                case 2:
                    $url = '/sach/'. $notification->identifier->identifier->id .'/' . $notification->identifier->identifier->slug;         
                    break;
                case 3:
                    $url = '/dien-dan/'. $notification->identifier->identifier->forums->slug .'/' . $notification->identifier->identifier->slug.'/'. $notification->identifier->identifier->id;         
                    break;            
                default:
                    $url = '';
            }

        }
        else if($type == 2){
            switch ($notification->identifier->comments->type_id) {
                case 1:
                    $url = '/tai-lieu/'. $notification->identifier->comments->identifier->id .'/' . $notification->identifier->comments->identifier->slug;         
                    break;
                case 2:
                    $url = '/sach/'. $notification->identifier->comments->identifier->id .'/' . $notification->identifier->comments->identifier->slug;         
                    break;
                case 3:
                    $url = '/dien-dan/'. $notification->identifier->comments->identifier->forums->slug .'/' . $notification->identifier->comments->identifier->slug.'/'. $notification->identifier->comments->identifier->id;         
                    break;            
                default:
                    $url = '';
            }
        }
        else if($type == 4 || $type == 5 || $type == 8 || $type == 9){
            $url = '/quan-ly';         

        }
        else if($type == 6 || $type == 10){
            $url = '/quan-ly/sach';         

        }
        else if($type == 7 || $type == 11){
            $url = '/quan-ly/tai-lieu';         
        }
     
        
        return response()->json([
            'url' => $url
        ]);

    }

    public function changeAllStatus(){
        $notification = Notification::where('receiverID','=',Auth::user()->id)->update([
            'status' => 0
        ]);

        return response()->json([
            'success' => 'Đánh dấu tất cả thông báo thành công!!!'
        ]);
       
    }
    
}
