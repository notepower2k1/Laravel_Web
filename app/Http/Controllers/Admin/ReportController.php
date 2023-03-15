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
}
