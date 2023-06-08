<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminMail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Models\BookComment;
use App\Models\BookCommentReply;
use App\Models\Comment;
use App\Models\DocumentComment;
use App\Models\DocumentCommentReply;
use App\Models\Document;
use App\Models\ForumPosts;
use App\Models\loginHistory;
use App\Models\Note;
use App\Models\PostComment;
use App\Models\PostCommentReply;
use App\Models\readingHistory;
use App\Models\Reply;
use App\Models\ReplyLike;
use App\Models\report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
   
       $users = User::where('deleted_at','=',null)->where('id','!=',Auth::user()->id)->get();
   
       return view('admin.user.index')->with('users', $users);
    }

    public function changeUserStatus(Request $request){
        $user = User::findOrFail($request->id);

        $message = '';
        switch($request->status){
            case 0:
                $user->status = 1;
                $message = 'Thành viên đã được mở khóa tài khoản';

                Book::where('userCreatedID','=',$user->id)->update([
                    'isPublic' => 1
                ]);

                Document::where('userCreatedID','=',$user->id)->update([
                    'isPublic' => 1
                ]);

                ForumPosts::where('userCreatedID','=',$user->id)->update([
                    'deleted_at' => null
                ]);

                
                Comment::where('userID','=',$user->id)->update([
                    'deleted_at' => null
                ]);

                Reply::where('userID','=',$user->id)->update([
                    'deleted_at' => null
                ]);

            
             



                $totalComments = Comment::where('userID','=',$user->id)->where('deleted_at','=',null)->get();
     
                foreach ($totalComments as $comment){

                    if($comment->type_id == 1){
                        $allRepliesOfComment = Reply::where('commentID','=',$comment->id)->where('deleted_at','=',null)->get();
                        $total = $allRepliesOfComment->count();

                        if($total){
                            $document = Document::findOrFail($comment->identifier_id);
                            $document->totalComments = $document->totalComments + ($total + 1);
                            $document->timestamps = false;
          
                            $document ->save();
                        }
                        else{
                            $document = Document::findOrFail($comment->identifier_id);
                            $document->totalComments = $document->totalComments + 1;
                            $document->timestamps = false;
          
                            $document ->save();
                        }
                
                    }
                    else if($comment->type_id == 2){
                       
                        $allRepliesOfComment = Reply::where('commentID','=',$comment->id)->where('deleted_at','=',null)->get();
                        $total = $allRepliesOfComment->count();

                        if($total){
                            $book = Book::findOrFail($comment->identifier_id);
                            $book->totalComments = $book->totalComments + ($total + 1);
                            $book->timestamps = false;
          
                            $book ->save();
                        }
                        else{
                            $book = Book::findOrFail($comment->identifier_id);
                            $book->totalComments = $book->totalComments + 1;
                            $book->timestamps = false;
          
                            $book ->save();
                        }
                    }
                    else if ($comment->type_id == 3){
                      
                        $allRepliesOfComment = Reply::where('commentID','=',$comment->id)->where('deleted_at','=',null)->get();
                        $total = $allRepliesOfComment->count();


                        if($total){
                                $post = ForumPosts::findOrFail($comment->identifier_id);
                                $post->totalComments = $post->totalComments + ($total + 1);
                                $post->timestamps = false;

                                $post ->save();
                        }
                        else{
                                $post = ForumPosts::findOrFail($comment->identifier_id);
                                $post->totalComments = $post->totalComments + 1;
                                $post->timestamps = false;
                                $post ->save();
                        }
                    }
                }

                break;
            case 1:
                $user->status = 0;
                $message = 'Khóa tài khoản thành viên thành công';

                Book::where('userCreatedID','=',$user->id)->update([
                    'isPublic' => 0
                ]);
                
                Document::where('userCreatedID','=',$user->id)->update([
                    'isPublic' => 0
                ]);

                ForumPosts::where('userCreatedID','=',$user->id)->update([
                    'deleted_at' => Carbon::now()
                ]);

                
                Comment::where('userID','=',$user->id)->update([
                    'deleted_at' => Carbon::now()
                ]);
    

                Reply::where('userID','=',$user->id)->update([
                    'deleted_at' => Carbon::now()
                ]);

                report::where('identifier_id','=',$user->id)->where('type_id','=','5')->update([
                    'deleted_at' => Carbon::now()->toDateTimeString()
                ]);
                
                $totalComments = Comment::where('userID','=',$user->id)->where('deleted_at','!=',null)->get();
     
                foreach ($totalComments as $comment){

                    if($comment->type_id == 1){
                        $allRepliesOfComment = Reply::where('commentID','=',$comment->id)->where('deleted_at','!=',null)->get();
                        $total = $allRepliesOfComment->count();

                        if($total){
                            $document = Document::findOrFail($comment->identifier_id);
                            $document->totalComments = $document->totalComments - ($total + 1);
                            $document->timestamps = false;
          
                            $document ->save();
                        }
                        else{
                            $document = Document::findOrFail($comment->identifier_id);
                            $document->totalComments = $document->totalComments - 1;
                            $document->timestamps = false;
          
                            $document ->save();
                        }
                
                    }
                    else if($comment->type_id == 2){
                       
                        $allRepliesOfComment = Reply::where('commentID','=',$comment->id)->where('deleted_at','!=',null)->get();
                        $total = $allRepliesOfComment->count();

                        if($total){
                            $book = Book::findOrFail($comment->identifier_id);
                            $book->totalComments = $book->totalComments - ($total + 1);
                            $book->timestamps = false;
          
                            $book ->save();
                        }
                        else{
                            $book = Book::findOrFail($comment->identifier_id);
                            $book->totalComments = $book->totalComments - 1;
                            $book->timestamps = false;
          
                            $book ->save();
                        }
                    }
                    else if ($comment->type_id == 3){
                      
                        $allRepliesOfComment = Reply::where('commentID','=',$comment->id)->where('deleted_at','!=',null)->get();
                        $total = $allRepliesOfComment->count();


                        if($total){
                                $post = ForumPosts::findOrFail($comment->identifier_id);
                                $post->totalComments = $post->totalComments - ($total + 1);
                                $post->timestamps = false;

                                $post ->save();
                        }
                        else{
                                $post = ForumPosts::findOrFail($comment->identifier_id);
                                $post->totalComments = $post->totalComments - 1;
                                $post->timestamps = false;
                                $post ->save();
                        }
                    }
                }

                
                $mailData = [
                    'title' => 'Xin chào '. $user->profile->displayName . '!!!',
                    'body' =>  'Tài khoản của bạn '. $user->name.' đã tạm thời bị khóa bởi quản trị viên vì nghi ngờ vi phạm chính sách của trang web.
                    Bạn có thể liên hệ với quản trị viên qua mail này để giải đáp các thắc mắc của mình.',
                    'content' => 'Xin cảm ơn!!!',
                ];
                

                Mail::to($user->email)->send(new AdminMail($mailData));  
                

                break;
            default:
                $message = 'Xảy ra lỗi';
        }
        $user ->save();

        return response()->json([
            'message' => $message,
            'status' => $user->status,
        ]);
    }

    public function detail($id) {
        $user = User::findOrFail($id);
        $books = Book::where('userCreatedID','=',$id)->get();
        $documents = Document::where('userCreatedID','=',$id)->get();
        $posts = ForumPosts::where('userCreatedID','=',$id)->get();
        $comments = Comment::where('userID','=',$id)->get();
        $notes = Note::where('type_id','=',3)->where('identifier_id','=',$id)->get();

        $reading_histories = readingHistory::where('userID','=',$id)->get();
        $login_histories = loginHistory::where('userID','=',$id)->get();
        return view('admin.user.detail')
        ->with('reading_histories',$reading_histories)
        ->with('login_histories',$login_histories)
        ->with('notes',$notes)
        ->with('books',$books)
        ->with('documents',$documents)
        ->with('posts',$posts)
        ->with('comments',$comments)
        ->with('user', $user);

    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'password' => [ 'required',
            'min:6',
            'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            ],
        ],[
            'password.required' => 'Bạn không thể để trống mật khẩu',
            'password.min' => 'Mật khẩu quá ngắn',
            'password.regex' =>'Mật khẩu phải có chữ viết hoa, số và không có ký tự đặc biệt'
        ]);
       
        $user = User::findOrFail($id)
        ->update([
                'password' => Hash::make($request->password),
        ]);

        return back();
    }

    public function deleteUser(Request $request){
        $user = User::findOrFail($request->id);
        $user->deleted_at = Carbon::now()->toDateTimeString();
        $user->save();

        Book::where('userCreatedID','=',$request->id)->update([
            'deleted_at' => null
        ]);

        Document::where('userCreatedID','=',$request->id)->update([
            'deleted_at' => null
        ]);

        ForumPosts::where('userCreatedID','=',$request->id)->update([
            'deleted_at' => null
        ]);

        
        Comment::where('userID','=',$request->id)->update([
            'deleted_at' => null
        ]);
        
        report::where('identifier_id','=',$request->id)->where('type_id','=','5')->update([
            'status' => 0
        ]);

        return response()->json([
            'message' => 'Xóa thành viên thành công'
        ]); 

      
    }
    public function statistics_user_page($year = null){
        DB::statement("SET SQL_MODE=''");
            
        $allYears = DB::select("SELECT distinct year(users.email_verified_at) as 'year' from users
        where users.email_verified_at is not null ");

        $totalByTypes = DB::select("SELECT Count(users.id) as 'total', users.status as 'status'
        from users 
        where users.deleted_at is null and users.email_verified_at is not null

        GROUP by users.status");

        
        if($year == null){

            $year = Carbon::now()->year;
        }
        $totalUsersPerMonth = DB::select("SELECT 
            SUM(IF(month = 'Jan', total, 0)) AS 'Tháng 1', 
            SUM(IF(month = 'Feb', total, 0)) AS 'Tháng 2', 
            SUM(IF(month = 'Mar', total, 0)) AS 'Tháng 3', 
            SUM(IF(month = 'Apr', total, 0)) AS 'Tháng 4', 
            SUM(IF(month = 'May', total, 0)) AS 'Tháng 5', 
            SUM(IF(month = 'Jun', total, 0)) AS 'Tháng 6', 
            SUM(IF(month = 'Jul', total, 0)) AS 'Tháng 7', 
            SUM(IF(month = 'Aug', total, 0)) AS 'Tháng 8', 
            SUM(IF(month = 'Sep', total, 0)) AS 'Tháng 9', 
            SUM(IF(month = 'Oct', total, 0)) AS 'Tháng 10', 
            SUM(IF(month = 'Nov', total, 0)) AS 'Tháng 11', 
            SUM(IF(month = 'Dec', total, 0)) AS 'Tháng 12' 
            FROM ( 
                SELECT DATE_FORMAT(users.email_verified_at, '%b') AS month, 
                COUNT(users.id) as total FROM users 
                WHERE Year(users.email_verified_at) = $year  and users.deleted_at is null
                GROUP BY DATE_FORMAT(users.email_verified_at, '%m-%Y')
        ) as sub");
        
        $totalUsersInYear = User::whereYear('email_verified_at', '=', $year)->where('deleted_at','=',null)->get();

        $totalUsersPerDate = DB::select("SELECT Count(users.id) as 'total', DATE(users.email_verified_at) as 'date'
        from users 
        WHERE YEAR(users.email_verified_at) = $year and users.deleted_at is null
        GROUP by  DATE(users.email_verified_at)");
        

        $totalLoginsPerYear = DB::select("SELECT HOUR(login_histories.created_at) as 'hour',COUNT(login_histories.id) as 'total'
        FROM login_histories WHERE Year(login_histories.created_at) = $year
        GROUP BY HOUR(login_histories.created_at)
        ORDER BY HOUR(login_histories.created_at)");

        $month = Carbon::now()->month;

        $totalLoginsPerMonth = DB::select("SELECT HOUR(login_histories.created_at) as 'hour',COUNT(login_histories.id) as 'total'
        FROM login_histories WHERE Year(login_histories.created_at) = $year and Month(login_histories.created_at) = $month
        GROUP BY HOUR(login_histories.created_at)
        ORDER BY HOUR(login_histories.created_at)");

        return view('admin.user.statistics')
        ->with('totalLoginsPerYear',$totalLoginsPerYear)
        ->with('totalLoginsPerMonth',$totalLoginsPerMonth)
        ->with('allYears',$allYears)
        ->with('totalUsersInYear',$totalUsersInYear->count())
        ->with('totalUsersPerDate',$totalUsersPerDate)
        ->with('statisticsYear',$year)
        ->with('totalUsersPerMonth',$totalUsersPerMonth)
        ->with('totalByTypes', $totalByTypes);
            
    }

    public function getLoginHistoryPerMonth(Request $request){

        $year = $request->year;
        $month = $request->month;

        $totalLoginsPerMonth = DB::select("SELECT HOUR(login_histories.created_at) as 'hour',COUNT(login_histories.id) as 'total'
        FROM login_histories WHERE Year(login_histories.created_at) = $year and Month(login_histories.created_at) = $month
        GROUP BY HOUR(login_histories.created_at)
        ORDER BY HOUR(login_histories.created_at)");

        return response()->json([
            'res' => $totalLoginsPerMonth,
        ]); 
    }


    public function decodeDate($date){
        
        $temp = substr_replace($date,"-",4,0);
        $temp = substr_replace($temp,"-",7,0);
        return $temp;
    }


    public function getFilterValue($fromDate,$toDate){

        
        $start_date = new Carbon($this->decodeDate($fromDate));
        $end_date = new Carbon($this->decodeDate($toDate));

        $users = User::whereBetween('created_at', [$start_date, $end_date])->get();
        
        return view('admin.user.index')
        ->with('fromDate',$start_date->format('m/d/Y'))
        ->with('toDate',$end_date->format('m/d/Y'))
        ->with('users', $users);


    }
}
