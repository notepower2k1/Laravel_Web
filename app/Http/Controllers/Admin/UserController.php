<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Models\BookComment;
use App\Models\BookCommentReply;
use App\Models\DocumentComment;
use App\Models\DocumentCommentReply;
use App\Models\Document;
use App\Models\ForumPosts;
use App\Models\PostComment;
use App\Models\PostCommentReply;
use Illuminate\Support\Facades\Auth;

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
                $message = 'Khóa tài khoản thành viên thành công';

                Book::where('userCreatedID','=',$user->id)->update([
                    'deleted_at' => Carbon::now()
                ]);

                Document::where('userCreatedID','=',$user->id)->update([
                    'deleted_at' => Carbon::now()
                ]);

                ForumPosts::where('userCreatedID','=',$user->id)->update([
                    'deleted_at' => Carbon::now()
                ]);

                
                BookComment::where('userID','=',$user->id)->update([
                    'deleted_at' => Carbon::now()
                ]);

                
                BookCommentReply::where('userID','=',$user->id)->update([
                    'deleted_at' => Carbon::now()
                ]);

                
                DocumentComment::where('userID','=',$user->id)->update([
                    'deleted_at' => Carbon::now()
                ]);

                
                DocumentCommentReply::where('userID','=',$user->id)->update([
                    'deleted_at' => Carbon::now()
                ]);

                PostComment::where('userID','=',$user->id)->update([
                    'deleted_at' => Carbon::now()
                ]);

                
                PostCommentReply::where('userID','=',$user->id)->update([
                    'deleted_at' => Carbon::now()
                ]);

                break;
            case 1:
                $user->status = 0;
                $message = 'Thành viên đã được mở khóa tài khoản';
                Book::where('userCreatedID','=',$user->id)->update([
                    'deleted_at' => null
                ]);

                Document::where('userCreatedID','=',$user->id)->update([
                    'deleted_at' => null
                ]);

                ForumPosts::where('userCreatedID','=',$user->id)->update([
                    'deleted_at' => null
                ]);

                
                BookComment::where('userID','=',$user->id)->update([
                    'deleted_at' => null
                ]);

                
                BookCommentReply::where('userID','=',$user->id)->update([
                    'deleted_at' => null
                ]);

                
                DocumentComment::where('userID','=',$user->id)->update([
                    'deleted_at' => null
                ]);

                
                DocumentCommentReply::where('userID','=',$user->id)->update([
                    'deleted_at' => null
                ]);

                PostComment::where('userID','=',$user->id)->update([
                    'deleted_at' => null
                ]);

                
                PostCommentReply::where('userID','=',$user->id)->update([
                    'deleted_at' => Carbon::now()
                ]);
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


    
    public function update(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8'],
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
}
