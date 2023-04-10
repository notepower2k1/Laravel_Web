<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\report;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\Document;
use App\Models\ForumPosts;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function index()
    {
       $reports = report::latest('created_at')->get();
       return view('admin.report.index')->with('reports', $reports);

    }

    public function report_wait_page()
    {
       $reports = report::where('status','=',0)->orderBy('created_at', 'desc')->get();
   
       return view('admin.report.report_wait')->with('reports', $reports);
    }

    public function report_done_page()
    {
        $reports = report::where('status','=',1)->orderBy('created_at', 'desc')->get();
   
        return view('admin.report.report_wait')->with('reports', $reports);
    }
    public function detail(Request $request) //like "show details"
    {
        $report = report::findOrFail($request->id);
        
        $type = $report->type_id;
        $item = collect();
        $subItem = collect();
        $itemUser = collect();
        switch ($type) {
            case 1:
                $item = Book::findOrFail($report->identifier_id);
                $subItem = $item->types;
                $itemUser = $item->users;
                break;
            case 2:
                $item = Chapter::findOrFail($report->identifier_id);
                $subItem = $item->books;
                break;
            case 3:
                $item = Document::findOrFail($report->identifier_id);
                $subItem = $item->types;
                $itemUser = $item->users;
                break;
            case 4:
                $item = ForumPosts::findOrFail($report->identifier_id);
                $subItem = $item->forum;
                $itemUser = $item->user;
                break;
            case 5:
                $item = User::findOrFail($report->identifier_id);
                $subItem = $item->profile;
                break;
            default:
                $item = null;
        }

        $reportUser = $report->users;
        $avatar = $reportUser->profile->url;
        return response()->json([
            'report_detail' => $report,
            'item' => $item,
            'subItem' => $subItem,
            'itemUser' => $itemUser,
            'reportUser' => $reportUser,
            'avatar' => $avatar
        ]);
        
    }

    
    public function changeReportStatus(Request $request){
        $report = report::findOrFail($request->id);
        $report->status = $request->status;
        $report ->save();

        
    }

    public function statistics_report_page($year = null){
        DB::statement("SET SQL_MODE=''");
            
        $allYears = DB::select("SELECT distinct year(reports.created_at) as 'year'
        from reports");

        $totalByTypes = DB::select("SELECT Count(reports.id) as 'total', report_types.name as 'status'
        from reports join report_types on reports.type_id = report_types.id 
        where reports.status = 1
        and reports.deleted_at is null

        GROUP by report_types.name");

        
        if($year == null){

            $year = Carbon::now()->year;
        }
        $totalReportsPerMonth = DB::select("SELECT 
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
                SELECT DATE_FORMAT(reports.created_at, '%b') AS month, 
                COUNT(reports.id) as total FROM reports 
                WHERE Year(reports.created_at) = $year  and reports.deleted_at is null and 
                reports.status = 1

                GROUP BY DATE_FORMAT(reports.created_at, '%m-%Y')
        ) as sub");
        
        $totalReportsInYear = Report::whereYear('created_at', '=', $year)->where('status','=',1)->where('deleted_at','=',null)->get();

        $totalReportsPerDate = DB::select("SELECT Count(reports.id) as 'total', DATE(reports.created_at) as 'date'
        from reports 
        WHERE YEAR(reports.created_at) = $year and reports.deleted_at is null and
        reports.status = 1
        GROUP by DATE(reports.created_at)");
        
         return view('admin.report.statistics')
            ->with('allYears',$allYears)
            ->with('totalReportsInYear',$totalReportsInYear->count())
            ->with('totalReportsPerDate',$totalReportsPerDate)
            ->with('statisticsYear',$year)
            ->with('totalReportsPerMonth',$totalReportsPerMonth)
            ->with('totalByTypes', $totalByTypes);
            
    }   
}
