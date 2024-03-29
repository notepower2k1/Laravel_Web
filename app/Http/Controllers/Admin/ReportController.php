<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\report;
use App\Models\Book;

use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Document;

use App\Models\ForumPosts;
use App\Models\ratingBook;
use App\Models\Reply;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function index()
    {
       $reports = report::where('status','=',1)->latest('created_at')->get();
       return view('admin.report.index')->with('reports', $reports);

    }

    public function report_done_page()
    {
        $reports = report::where('status','=',0)->orderBy('created_at', 'desc')->get();
   
        return view('admin.report.report_done')->with('reports', $reports);
    }

    public function detail(Request $request) //like "show details"
    {
        $report = report::findOrFail($request->id);
        
        $type = $report->type_id;
        $item = collect();
        $content = '';
        $title = '';
        $itemUrl = '';
        switch ($type) {
            case 1:
                $item = Book::findOrFail($report->identifier_id);
                $createTime = new Carbon($item->created_at);
                $createTime = $createTime->toDateTimeString();   

                $updateTime = new Carbon($item->updated_at);
                $updateTime = $updateTime->toDateTimeString();   

                $language = $item->language==1?'Tiếng việt':'Tiếng anh';
                $content =  
                    '<div class="d-flex flex-row">'.
                        '<div class="col-3 me-3">'.
                            '<img src="'.$item->url.'" alt="" style="width:400px;height:225px">'.
                        '</div>'.
                        '<div class="col-9">'.
                            '<ul class="link-list">'.
                            '<li><strong>Tên sách</strong>: '.$item->name.'</li>'.
                            '<li><strong>Thể loại</strong>: '.$item->types->name.'</li>'.
                            '<li><strong>Tác giả</strong>: '.$item->author.'</li>'.
                            '<li><strong>Ngôn ngữ</strong>: '.$language.'</li>'.
                            '<li><strong>Người thêm</strong>: '.$item->users->profile->displayName.' </li>'.
                            '<li><strong>Ngày thêm</strong>: '. $createTime . '</li>'.
                            '<li><strong>Lần cập nhật cuối</strong>: '. $updateTime . '</li>'.
                            '</ul>'.
                        '</div>'.
                    '</div>';     
                $title = 'Báo cáo về sách' .'('.$report->created_at.')';
                $itemUrl = '/admin/book/detail'.'/'.$item->id.'/'.Carbon::now()->year;
                break;
            case 2:
                $item = Chapter::findOrFail($report->identifier_id);
                
                $createTime = new Carbon($item->created_at);
                $createTime = $createTime->toDateTimeString();   

                $updateTime = new Carbon($item->updated_at);
                $updateTime = $updateTime->toDateTimeString();   

                $content =
                '<div class="d-flex flex-row">'.
                    '<div class="col-3 me-3">'.
                        '<img src="'.$item->books->url.'" alt="" style="width:400px;height:225px">'.
                    '</div>'.
                    '<div class="col-9">'.
                        '<ul class="link-list">'.
                        '<li><strong>Tên sách</strong>: '.$item->books->name.'</li>'.
                        '<li><strong>Thể loại</strong>: '.$item->books->types->name.'</li>'.
                        '<li><strong>Tác giả</strong>: '.$item->books->author.'</li>'.
                        '<li><strong>Người thêm</strong>: '.$item->books->users->profile->displayName.' </li>'.
                        '<li class="divider"></li>'.
                        '<li><strong>Chương số</strong>: '.$item->code.'</li>'.
                        '<li><strong>Tên chương</strong>: '.$item->name.'</li>'.
                        '<li><strong>Ngày thêm</strong>: '. $createTime . '</li>'.
                        '<li><strong>Lần cập nhật cuối</strong>: '. $updateTime . '</li>'.
                        '</ul>'.
                    '</div>'.
                '</div>';     
                $title = 'Báo cáo về chương'  .'('.$report->created_at.')';
                $itemUrl = '/admin/book/chapter/'.$item->books->id;

                break;
            case 3:
                $item = Document::findOrFail($report->identifier_id);
           
                $createTime = new Carbon($item->created_at);
                $createTime = $createTime->toDateTimeString();   

                $updateTime = new Carbon($item->updated_at);
                $updateTime = $updateTime->toDateTimeString();   

                $language = $item->language==1?'Tiếng việt':'Tiếng anh';

                $content =
                '<div class="d-flex flex-row">'.
                    '<div class="col-3 me-3">'.
                        '<img src="'.$item->url.'" alt="" style="width:400px;height:225px">'.
                    '</div>'.
                    '<div class="col-9">'.
                        '<ul class="link-list">'.
                        '<li><strong>Tên tài liệu</strong>: '.$item->name.'</li>'.
                        '<li><strong>Thể loại</strong>: '.$item->types->name.'</li>'.
                        '<li><strong>Tác giả</strong>: '.$item->author.'</li>'.
                        '<li><strong>Ngôn ngữ</strong>: '.$language.'</li>'.
                        '<li><strong>Người thêm</strong>: '.$item->users->profile->displayName.' </li>'.
                        '<li><strong>Ngày thêm</strong>: '. $createTime . '</li>'.
                        '<li><strong>Lần cập nhật cuối</strong>: '. $updateTime . '</li>'.
                        '</ul>'.
                    '</div>'.
                '</div>';     
                $title = 'Báo cáo về tài liệu' .'('.$report->created_at.')';
                $itemUrl = '/admin/document/detail'.'/'.$item->id.'/'.Carbon::now()->year;

                break;
            case 4:
                $item = ForumPosts::findOrFail($report->identifier_id);
                
                $createTime = new Carbon($item->created_at);
                $createTime = $createTime->toDateTimeString();   

                $updateTime = new Carbon($item->updated_at);
                $updateTime = $updateTime->toDateTimeString();  
                
                $image = $item->firstImage ? $item->firstImage: 'https://raw.githubusercontent.com/notepower2k1/MyImage/main/banner/post_no_Image.png';
                
                $content =
                '<div class="d-flex flex-row">'.
                    '<div class="col-3 me-3">'.
                        '<img src="'.$image.'" alt="" style="width:400px;height:225px">'.
                    '</div>'.
                '<div class="col-9">'.
                    '<ul class="link-list">'.
                        '<li><strong>Diễn đàn</strong>: '.$item->forums->name.'</li>'.
                        '<li class="divider"></li>'.
                        '<li><strong>Chủ đề bài viết</strong>: '.$item->topic.'</li>'.
                        '<li><strong>Người thêm</strong>: '.$item->users->profile->displayName.' </li>'.
                        '<li><strong>Ngày thêm</strong>: '. $createTime . '</li>'.
                        '<li><strong>Lần cập nhật cuối</strong>: '. $updateTime . '</li>'.
                    '</ul>'.
                '<div>';
                $title = 'Báo cáo về bài viết' .'('.$report->created_at.')';
                $itemUrl = '/admin/forum/post'.'/'.$item->id.'/'.Carbon::now()->year.'/detail';

                break;
            case 5:
                $item = User::findOrFail($report->identifier_id);
                $temp = new Carbon($item->created_at);

                $time = $temp->toDateTimeString();   
                $content =
                '<div class="d-flex flex-row">'.
                    '<div class="col-3 me-3">'.
                        '<img src="'.$item->profile->url.'" alt="" style="width:400px;height:225px">'.
                    '</div>'.
                    '<div class="col-9">'.
                        '<ul class="link-list">'.
                        '<li><strong>Tài khoản</strong>: '.$item->name.'</li>'.
                        '<li><strong>Biệt danh</strong>: '.$item->profile->displayName.'</li>'.
                        '<li><strong>Email</strong>: '.$item->email.'</li>'.
                        '<li><strong>Ngày tham gia</strong>: '.$time.'</li>'.
                        '<li><strong>Lần đăng nhập cuối</strong>: '.$item->lastLogin.'</li>'.
                        '</ul>'.
                    '</div>'.
                '</div>';     
                $title = 'Báo cáo về người dùng' .'('.$report->created_at.')';
                $itemUrl = '/admin'.'/user'.'/'.$item->id;

                break;
            case 6:
                $item = Comment::findOrFail($report->identifier_id);
                $createTime = new Carbon($item->created_at);
                $createTime = $createTime->toDateTimeString();   

                $updateTime = new Carbon($item->updated_at);
                $updateTime = $updateTime->toDateTimeString();  

                if($item->type_id == 1){
                    $document = Document::findOrFail($item->identifier_id);
                    $content =
                    '<div class="d-flex flex-row">'.
                        '<div class="col-3 me-3">'.
                            '<img src="'.$document->url.'" alt="" style="width:400px;height:225px">'.
                        '</div>'.
                        '<div class="col-9">'.
                            '<ul class="link-list">'.
                                '<li><strong>Tên tài liệu</strong>: '.$document->name.'</li>'.
                                '<li><strong>Thể loại</strong>: '.$document->types->name.'</li>'.
                                '<li><strong>Tác giả</strong>: '.$document->author.'</li>'.
                                '<li><strong>Người thêm</strong>: '.$document->users->profile->displayName.' </li>'.
                                '<li class="divider"></li>'.
                                '<li><strong>Nội dung bình luận</strong>: '.$item->content.'</li>'.
                                '<li><strong>Người thêm</strong>:'.$item->users->profile->displayName.' </li>'.
                                '<li><strong>Ngày thêm</strong>: '. $createTime . '</li>'.
                                '<li><strong>Lần cập nhật cuối</strong>: '. $updateTime . '</li>'.
                            '</ul>'.
                        '</div>'.
                    '</div>';     
                    $title = 'Báo cáo về bình luận của tài liệu' .'('.$report->created_at.')';
                    $itemUrl = '/tai-lieu/'.$document->id.'/'.$document->slug;
                }
                else if($item->type_id == 2){
                    $book = Book::findOrFail($item->identifier_id);
                    $content =
                    '<div class="d-flex flex-row">'.
                        '<div class="col-3 me-3">'.
                            '<img src="'.$book->url.'" alt="" style="width:400px;height:225px">'.
                        '</div>'.
                        '<div class="col-9">'.
                            '<ul class="link-list">'.
                            '<li><strong>Tên sách</strong>: '.$book->name.'</li>'.
                            '<li><strong>Thể loại</strong>: '.$book->types->name.'</li>'.
                            '<li><strong>Tác giả</strong>: '.$book->author.'</li>'.
                            '<li><strong>Người thêm</strong>: '.$book->users->profile->displayName.' </li>'.
                            '<li class="divider"></li>'.
                            '<li><strong>Nội dung bình luận</strong>: '.$item->content.'</li>'.
                            '<li><strong>Người thêm</strong>:'.$item->users->profile->displayName.' </li>'.
                            '<li><strong>Ngày thêm</strong>: '. $createTime . '</li>'.
                            '<li><strong>Lần cập nhật cuối</strong>: '. $updateTime . '</li>'.
                            '</ul>'.
                        '</div>'.
                    '</div>';     
                 
                    $title = 'Báo cáo về bình luận của sách' .'('.$report->created_at.')';
                    $itemUrl = '/sach/'.$book->id.'/'.$book->slug;

                }
                else if ($item->type_id == 3){
                    $post = ForumPosts::findOrFail($item->identifier_id);
                    $image = $post->firstImage ? $post->firstImage: 'https://raw.githubusercontent.com/notepower2k1/MyImage/main/banner/post_no_Image.png';
                
                    $content =
                    '<div class="d-flex flex-row">'.
                        '<div class="col-3 me-3">'.
                            '<img src="'.$image.'" alt="" style="width:400px;height:225px">'.
                        '</div>'.
                    '<div class="col-9">'.
                        '<ul class="link-list">'.
                            '<li><strong>Diễn đàn</strong>: '.$post->forums->name.'</li>'.
                            '<li class="divider"></li>'.
                            '<li><strong>Chủ đề bài viết</strong>: '.$post->topic.'</li>'.
                            '<li><strong>Người thêm</strong>: '.$post->users->profile->displayName.' </li>'.
                            '<li><strong>Ngày thêm</strong>: '. $createTime . '</li>'.
                            '<li><strong>Lần cập nhật cuối</strong>: '. $updateTime . '</li>'.
                        '</ul>'.
                    '<div>';

                    $title = 'Báo cáo về bình luận bài viết' .'('.$report->created_at.')';
                    $itemUrl = '/dien-dan/'.$post->forums->slug.'/'.$post->slug.'/'.$post->id;
                }
                break;

            case 7:
                $item = Reply::findOrFail($report->identifier_id);
                $comment = Comment::findOrFail($item->commentID);
                $itemUrl = '';
                $object = '';
                switch ($comment->type_id) {
                    case 1:
                        $document = Document::findOrFail($comment->identifier_id);
                        $itemUrl = '/tai-lieu/'.$document->id.'/'.$document->slug;
                        $object =
                        '<li><strong>Tên tài liệu</strong>: '.$document->name.'</li>'.
                        '<li><strong>Thể loại</strong>: '.$document->types->name.'</li>'.
                        '<li><strong>Tác giả</strong>: '.$document->author.'</li>'.
                        '<li><strong>Người thêm</strong>: '.$document->users->profile->displayName.' </li>';
                        break;
                    case 2:
                        $book = Book::findOrFail($comment->identifier_id);
                        $itemUrl = '/sach/'.$book->id.'/'.$book->slug;

                        $object =
                        '<li><strong>Tên sách</strong>: '.$book->name.'</li>'.
                        '<li><strong>Thể loại</strong>: '.$book->types->name.'</li>'.
                        '<li><strong>Tác giả</strong>: '.$book->author.'</li>'.
                        '<li><strong>Người thêm</strong>: '.$book->users->profile->displayName.' </li>';
                        break;
                    case 3:
                        $post = ForumPosts::findOrFail($comment->identifier_id);
                        $itemUrl = '/dien-dan/'.$post->forums->slug.'/'.$post->slug;

                        $object =
                        '<li><strong>Diễn đàn</strong>: '.$post->forums->name.'</li>'.
                        '<li class="divider"></li>'.
                        '<li><strong>Chủ đề bài viết</strong>: '.$post->topic.'</li>'.
                        '<li><strong>Người thêm</strong>: '.$post->users->profile->displayName.' </li>';

                        break;
                    default:
                        $itemUrl = '';
                    }

                $createTime = new Carbon($item->created_at);
                $createTime = $createTime->toDateTimeString();   

                $updateTime = new Carbon($item->updated_at);
                $updateTime = $updateTime->toDateTimeString();  
                $content =
                '<ul class="link-list">'.
                    $object.
                    '<li class="divider"></li>'.
                    '<li><strong>Bình luận của</strong>: '.$comment->users->name.'</li>'.
                    '<li><strong>Nội dung</strong>: '.$comment->content.'</li>'.
                    '<li class="divider"></li>'.
                    '<li><strong>Phản hồi của</strong>: '.$item->users->name.'</li>'.
                    '<li><strong>Nội dung</strong>: '.$item->content.'</li>'.
                    '<li><strong>Ngày thêm</strong>: '. $createTime . '</li>'.
                    '<li><strong>Lần cập nhật cuối</strong>: '. $updateTime . '</li>'.
                '</ul>';
                $title = 'Báo cáo về phản hồi của bình luận' .'('.$report->created_at.')';
                break;          
                
            case 8:
                $item = ratingBook::findOrFail($report->identifier_id);
                $book = Book::findOrFail($item->bookID);

                $createTime = new Carbon($item->created_at);
                $createTime = $createTime->toDateTimeString();   

                $updateTime = new Carbon($item->updated_at);
                $updateTime = $updateTime->toDateTimeString();  
                $content =
                '<div class="d-flex flex-row">'.
                    '<div class="col-3 me-3">'.
                        '<img src="'.$book->url.'" alt="" style="width:400px;height:225px">'.
                    '</div>'.
                    '<div class="col-9">'.
                        '<ul class="link-list">'.
                        '<li><strong>Tên sách</strong>: '.$book->name.'</li>'.
                        '<li><strong>Thể loại</strong>: '.$book->types->name.'</li>'.
                        '<li><strong>Tác giả</strong>: '.$book->author.'</li>'.
                        '<li><strong>Người thêm</strong>: '.$book->users->profile->displayName.' </li>'.
                        '<li class="divider"></li>'.
                        '<li><strong>Nội dung đánh giá</strong>: '.$item->content.'</li>'.
                        '<li><strong>Số điểm đánh giá</strong>: '.$item->score.'</li>'.
                        '<li><strong>Người thêm</strong>:'.$item->users->profile->displayName.' </li>'.
                        '<li><strong>Ngày thêm</strong>: '. $createTime . '</li>'.
                        '<li><strong>Lần cập nhật cuối</strong>: '. $updateTime . '</li>'.
                        '</ul>'.
                    '</div>'.
                '</div>';     
                
                $title = 'Báo cáo về đánh giá của sách' .'('.$report->created_at.')';
                $itemUrl = '/sach/'.$book->id.'/'.$book->slug;

                
               

          
                break;          
            default:
                $item = null;
        }

        $temp = new Carbon($report->created_at);

        $time = $temp->toDateTimeString();   

        $userContent =
        '<div class="d-flex flex-row">'.
            '<div class="col-4">'.
                '<img src="'.$report->users->profile->url.'" alt="" style="width:256px;height:256px">'.
            '</div>'.
            '<div class="col-8">'.
                '<ul class="link-list">'.
                '<li style="font-size:20px"><strong>Tài khoản</strong>: '.$report->users->name.'</li>'.
                '<li style="font-size:20px"><strong>Biệt danh</strong>: '.$report->users->profile->displayName.'</li>'.
                '<li style="font-size:20px"><strong>Email</strong>: '.$report->users->email.'</li>'.
                '<li style="font-size:20px"><strong>Ngày tham gia</strong>: '.$time.'</li>'.
                '<li style="font-size:20px"><strong>Lần đăng nhập cuối</strong>: '.$report->users->lastLogin.'</li>'.
                '</ul>'.
            '</div>'.
        '</div>';     

        $userUrl = '/thanh-vien/'.$report->users->id;

        $description = $report->description;
        $reason = $report->reasons->name;

        return response()->json([
            'content' => $content,
            'userContent' => $userContent,
            'description' =>$description,
            'reason' => $reason,
            'title' => $title,
            'itemUrl' => $itemUrl,
            'userUrl' =>$userUrl
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
        where reports.status = 0
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
                reports.status = 0

                GROUP BY DATE_FORMAT(reports.created_at, '%m-%Y')
        ) as sub");
        
        $totalReportsInYear = Report::whereYear('created_at', '=', $year)->where('status','=',0)->where('deleted_at','=',null)->get();

        $totalReportsPerDate = DB::select("SELECT Count(reports.id) as 'total', DATE(reports.created_at) as 'date'
        from reports 
        WHERE YEAR(reports.created_at) = $year and reports.deleted_at is null and
        reports.status = 0
        GROUP by DATE(reports.created_at)");
        
         return view('admin.report.statistics')
            ->with('allYears',$allYears)
            ->with('totalReportsInYear',$totalReportsInYear->count())
            ->with('totalReportsPerDate',$totalReportsPerDate)
            ->with('statisticsYear',$year)
            ->with('totalReportsPerMonth',$totalReportsPerMonth)
            ->with('totalByTypes', $totalByTypes);
            
    } 
    
    public function decodeDate($date){
        
        $temp = substr_replace($date,"-",4,0);
        $temp = substr_replace($temp,"-",7,0);
        return $temp;
    }


    public function getFilterValue($fromDate,$toDate){

        
        $start_date = new Carbon($this->decodeDate($fromDate));
        $end_date = new Carbon($this->decodeDate($toDate));

        $reports = Report::whereBetween('created_at', [$start_date, $end_date])->where('status','=',1)->get();
        
        return view('admin.report.index')
        ->with('fromDate',$start_date->format('m/d/Y'))
        ->with('toDate',$end_date->format('m/d/Y'))
        ->with('reports', $reports);


    }

    public function getFilterValueDone ($fromDate,$toDate){
        $start_date = new Carbon($this->decodeDate($fromDate));
        $end_date = new Carbon($this->decodeDate($toDate));

        $reports = Report::whereBetween('updated_at', [$start_date, $end_date])->where('status','=',0)->get();
        
        return view('admin.report.report_done')
        ->with('fromDate',$start_date->format('m/d/Y'))
        ->with('toDate',$end_date->format('m/d/Y'))
        ->with('reports', $reports);
    }
}
