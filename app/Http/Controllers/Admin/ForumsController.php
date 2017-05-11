<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\forumsRequest;
use App\Http\Controllers\Controller;
use App\Models\Forums;
use App\Models\Comments;
use App\Models\EmployeeDepartments;
use App\Models\AdminUser;
use App\Models\ReportAbuses;
use App\Models\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Datatables;
use DB;

class ForumsController extends Controller {

        public $Forums;
        public $EmployeeDepartments;

        public function __construct() {
            $this->Forums = new Forums();
            $this->EmployeeDepartments = new EmployeeDepartments();
        }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request) {
        $page_title = "{trans('form.forums.forum_title')}";
        $page_description = 'Listing of all topics';
        return view('admin.forums.index', compact('page_title', 'page_description'));
    }

    public function datatableList(Request $request) {
        try{

            $forums=$this->Forums->getForums();
            $data = $request->only('filter_from','filter_to','topics_type');

            if( isset($data['topics_type']) && !empty($data['topics_type']) && $data['topics_type']!='all'){            
                if($data['topics_type']=='featured'){                
                    $forums->where('status','Active');
                }            
                if($data['topics_type']=='popular'){                
                    $forums->orderBy('total_comments','desc')->take(20);
                }            
            }

            if( isset($data['filter_from']) && !empty($data['filter_from']) ){
                $forums->where('created_at','>=',$data['filter_from']);
            }

            if( isset($data['filter_to']) && !empty($data['filter_to']) ){            
                $forums->where('created_at','<=',$data['filter_to']);
            }

    //        echo "<PRE>";
    //        print_r($forums);die;
            return Datatables::of($forums)
            ->editcolumn('total_comments',function($forum){

                $total_comments=$forum->total_comments;
                if($total_comments>0){
                    return   '<a href="'.route(config('project.admin_route').'ForumsComments', $forum->id). '" class="" data-toggle="tooltip" data-placement="top" title="Edit">'.$total_comments.'</i></a>';
                }
                return $total_comments;
            })
            ->addColumn('action', function ($forum) {
                return '<a href="' . route(config('project.admin_route').'forums.edit', encrypt($forum->id)) . '" class="" data-toggle="tooltip" data-placement="top" title="Edit">View</i></a>' .
                '&nbsp;&nbsp;<a href="javascript:void(0)" class="deleteCategory" data-toggle="modal" data-placement="top" title="Delete" data-category_delete_remote="' . route(config('project.admin_route').'forums.destroy', encrypt($forum->id)) . '">Unpublished</a>';
            })
            ->addColumn('report_abuse', function ($forum) {
                if($forum->report_abuses->count() >0)
                {
                    return '<a href="'.route('admin.ForumsReportsTopics', $forum->id).'">'.$forum->report_abuses->count().'</a>';
                }else{
                    return '<p>'.$forum->report_abuses->count().'</p>';
                }
            })
            ->make(true);
        }
        catch(\Exception $e){
    // echo $e->getMessage();
        }
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create() {
        $department['all_departmentsnames']=$this->EmployeeDepartments->getEmployeeDepartmentsnames();
        return view('admin.forums.create', compact('department'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(forumsRequest $request) {
        $data = $request->only('topic_name', 'topic_department_id','topic_description');
        $data['admin_users_id']= \Auth::guard('admin')->user()->id;
        $incrementdepartment=$this->EmployeeDepartments->incrementDepartmentTopic($data['topic_department_id']);
        $forums=$this->Forums->saveForum($data);
        \Flash::success(trans('message.forums.add_success'));
        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'redirectUrl' => route(config('project.admin_route').'forums.index'),
                ]);
        } else {
            return redirect()->route(config('project.admin_route').'forums.index');
        }
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id) {

    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id) {
        $id = decrypt($id);
        $department['all_departmentsnames']=$this->EmployeeDepartments->getEmployeeDepartmentsnames();
        $department['department_name']=$this->EmployeeDepartments->getDepartmentwithtopic($id);
        $all_forums=$this->Forums->getForums();
        $forums=$this->Forums->getForums($id);        
        return view('admin.forums.edit', compact('forums', 'all_forums','department'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(forumsRequest $request, $id) {        
        $id = decrypt($id);
        $forums=$this->Forums->getForums($id);        

        $data = $request->only('topic_name', 'topic_department_id');
        $forums=$this->Forums->saveForum($data,$id); 

        \Flash::success(trans('message.forums.update_success'));

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'redirectUrl' => route(config('project.admin_route').'forums.index'),
                ]);
        } else {
            return redirect()->route(config('project.admin_route').'forums.index');
        }
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy($id, Request $request) {
        $id = decrypt($id);
        try {
            $forums=$this->Forums->getForums($id);
            $decrementdepartment=$this->EmployeeDepartments->decrementDepartmentTopic($forums['topic_department_id']);
            $data['status'] = 'Inactive';
            $forums=$this->Forums->saveForum($data,$id); 
    //$this->Forums->deleteForums($id);
            if ($request->ajax()) {
                return response(['msg' => trans('message.forums.delete_success'), 'success' => 1]);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
    return response(['msg' => $ex->errorInfo, 'success' => 0]);//$ex->getMessage()
    }

    }


    public function GetCommentsIndex($id)
    {  
        $topic = Forums::find($id);
        $comments = Forums::find($id)->comments;


        return view('admin.forums.comments' ,compact('id', 'topic'));
    }




    public function CommentDatatable($id)
    {
        try{

            $comments = Comments::with('user')->where('forum_id',$id);

            return Datatables::of($comments)
            ->addColumn('username', function ($comment) {
                return  $comment->user->username;                
            })                

            ->addColumn('reports', function ($comment) use($id) {
                $number = ReportAbuses::where('ref_id',$comment->id)->where('type','comment')->count();
                if ($number >0) {
                    return '<a href="'.route('admin.ForumsCommentReports',['id' => $id, 'comment'=> $comment->id]).'">'.$number.'</a>'  ;     

                }else{
                    return $number   ;     

                }

            })                
            ->make(true);

        }
        catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function GetReportsTopics($id)
    {

        return view('admin.forums.report_topic' ,compact('id'));
    }


    public function ReportTpoicDatatable($id)
    {
        try{

            $reports = ReportAbuses::where('ref_id',$id)->where('type','topic');

            return Datatables::of($reports)
            ->editcolumn('report_value',function($reports){ 

               $values = explode(",",$reports->report_value );  
               $result = [];
               $report_value = array(1=>"Inappropriate Content",2=>"It`s spam or a scam",3=>"It`s annoying or not interesting");
      
            foreach ($values as  $value)  
            {
                    $result [] =  $report_value[$value];                    
            }                 
               $result =  implode(",<br> ",$result);          
                return $result;
            })

            ->make(true);

        }
        catch(\Exception $e){
            return $e->getMessage();
        }
    }


    public function GetCommentReports($id , $comment)
    {
        return view('admin.forums.report_comment' ,compact('id','comment'));
    }


    public function GetCommentReportsDatatable($id, $comment)
    {
        try{

            $reports = ReportAbuses::where('ref_id',$comment)->where('type','comment');
            $report_value = array(1=>"Inappropriate Content",2=>"It`s spam or a scam",3=>"It`s annoying or not interesting");
            return Datatables::of($reports)

            ->editcolumn('report_value',function($reports){ 

               $values = explode(",",$reports->report_value );  
               $result = [];
               $report_value = array(1=>"Inappropriate Content",2=>"It`s spam or a scam",3=>"It`s annoying or not interesting");
      
            foreach ($values as  $value)  
            {
                    $result [] =  @$report_value[$value];                    
            }                 
               $result =  implode(",<br> ",$result);          
                return $result;
            })



            ->make(true);

        }
        catch(\Exception $e){
            return $e->getMessage();
        }
    }

}