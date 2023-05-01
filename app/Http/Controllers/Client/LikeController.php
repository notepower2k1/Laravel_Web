<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Reply;
use App\Models\ReplyLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like_comment(Request $request){

        $commentID = $request->commentID;

        $userID = Auth::user()->id;

        $existLike = CommentLike::where('commentID','=',$commentID)->where('userID',$userID)->first();

        $commentOfLike = Comment::findOrFail($commentID);

        $status = 1;
        if($existLike){
            if($existLike->isLike === 1){
                $existLike->isLike = 0;
                $commentOfLike->totalLikes = $commentOfLike->totalLikes - 1;
                $status = 0;
            }
            else{
                $existLike->isLike = 1;
                $commentOfLike->totalLikes = $commentOfLike->totalLikes + 1;
                $status = 1;

            }
            $existLike->save();
            $commentOfLike->save();
        }
        else{
            CommentLike::create([
                'isLike' => 1,
                'commentID' =>  $commentID,
                'userID' => $userID
            ]);
            $commentOfLike->totalLikes = $commentOfLike->totalLikes + 1;
            $commentOfLike->save();
        }

        return response()->json([
            'totalLike' => $commentOfLike->totalLikes,
            'status' => $status
        ]);
        
    }

    public function like_reply(Request $request){

        $replyID = $request->replyID;

        $userID = Auth::user()->id;

        $existLike = ReplyLike::where('replyID','=',$replyID)->where('userID',$userID)->first();

        $ReplyOfLike = Reply::findOrFail($replyID);

        $status = 1;

        if($existLike){
            
            if($existLike->isLike === 1){
                $existLike->isLike = 0;
                $ReplyOfLike->totalLikes = $ReplyOfLike->totalLikes - 1;
                $status = 0;
            }
            else{
                $existLike->isLike = 1;
                $ReplyOfLike->totalLikes = $ReplyOfLike->totalLikes + 1;
                $status = 1;
            }
            $existLike->save();
            $ReplyOfLike->save();

        }
        else{
            ReplyLike::create([
                'isLike' => 1,
                'replyID' =>  $replyID,
                'userID' => $userID
            ]);

            $ReplyOfLike->totalLikes = $ReplyOfLike->totalLikes + 1;
            $ReplyOfLike->save();
        }

        return response()->json([
            'totalLike' => $ReplyOfLike->totalLikes,
            'status' => $status
        ]);
    }

}
