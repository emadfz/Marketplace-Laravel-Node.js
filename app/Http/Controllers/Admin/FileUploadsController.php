<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\fileuploadRequest;
use App\Http\Controllers\Controller;
use App\Models\FileUploads;
use App\Models\FileLabels;
use App\Models\Category;
use App\Models\Files;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Datatables;
use DB;

class FileUploadsController extends Controller {
    
    public $FileUploads;
    public $FileLabels;
    public $Category;
    public $Files;

    public function __construct() {
        $this->FileUploads = new FileUploads();
        $this->FileLabels = new FileLabels();
        $this->Category = new Category();
        $this->Files = new Files();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $page_title = "{trans('form.file_uploads.file_upload_title')}";
        $page_description = 'Listing of all topics';
        $label['all_labels']=$this->FileLabels->getFileLabelssnames();
        return view('admin.file_uploads.index', compact('page_title', 'page_description','label'));
    }

    public function datatableList(Request $request) {
        
        $fileuploads=$this->FileUploads->getFileUploads();
        return Datatables::of($fileuploads)
                        ->addColumn('action', function ($fileupload) {
                            return '<a href="' . route(config('project.admin_route').'fileuploads.edit', encrypt($fileupload->id)) . '" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>' .
                                    '&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-xs fa fa-trash-o deleteCategory" data-toggle="modal" data-placement="top" title="Delete" data-category_delete_remote="' . route(config('project.admin_route').'fileuploads.destroy', encrypt($fileupload->id)) . '"></a>';
                        })
                        ->addColumn('file_preview', function ($fileupload) {
                            return generateDocumentAnchorpreview(@$fileupload->Files[0]->path);
                        })
                        

                        ->make(true);                
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $label['all_labels']=$this->FileLabels->getFileLabelssnames();
        $label['all_categories']=$this->Category->getNestedData();
        unset($label['all_categories'][0]);
        return view('admin.file_uploads.create', compact('label'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(fileuploadRequest $request) {
        $data = $request->only('file_labels_id', 'category_id', 'file_name');   
//        $incrementdepartment=$this->EmployeeDepartments->incrementDepartmentTopic($data['topic_department_id']);
               
        \Flash::success(trans('message.file_uploads.add_success'));
        if ($request->ajax()) {
            if ($request->hasFile('image')) {                    
                    $data['image'] = uploadImage($request->file('image'),true);                                        
                }
                 $fileuploads=$this->FileUploads->saveFileUploads($data);
            return response()->json([
                        'status' => 'success',
                        'redirectUrl' => route(config('project.admin_route').'fileuploads.index'),
            ]);
        } else {
            return redirect()->route(config('project.admin_route').'fileuploads.index');
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
        $label['all_labels']=$this->FileLabels->getFileLabelssnames();
        $label['all_categories']=$this->Category->getNestedData();        
        unset($label['all_categories'][0]);
                $all_fileuploads=$this->FileUploads->getFileUploads();
        $fileuploads=$this->FileUploads->getFileUploads($id);        
        return view('admin.file_uploads.edit', compact('fileuploads', 'all_fileuploads', 'label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(fileuploadRequest $request, $id) {        
        $id = decrypt($id);
        $fileuploads=$this->FileUploads->getFileUploads($id);        

        $data = $request->only('file_labels_id', 'category_id', 'file_name');
        if ($request->hasFile('image')) {
                    if (isset($request->old_image) && !empty($request->old_image)) {
                        $data['image'] = uploadImage($request->file('image'),true,$request->old_image);
                    }
                    else{
                        $data['image'] = uploadImage($request->file('image'),true);
                    }

                    
                }
        unset($data['old_image']);
        $fileuploads=$this->FileUploads->saveFileUploads($data,$id); 

        \Flash::success(trans('message.file_uploads.update_success'));

        if ($request->ajax()) {
            return response()->json([
                        'status' => 'success',
                        'redirectUrl' => route(config('project.admin_route').'fileuploads.index'),
            ]);
        } else {
            return redirect()->route(config('project.admin_route').'fileuploads.index');
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
            $fileuploads=$this->FileUploads->getFileUploads($id);
          //  $decrementdepartment=$this->EmployeeDepartments->decrementDepartmentTopic($forums['topic_department_id']);
            //$data['status'] = 'Inactive';
            //$fileuploads=$this->FileUploads->saveFileUploads($data,$id); 
            $this->FileUploads->deletefileupload($id);
            if ($request->ajax()) {
                return response(['msg' => trans('message.file_uploads.delete_success'), 'success' => 1]);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return response(['msg' => $ex->errorInfo, 'success' => 0]);//$ex->getMessage()
        }
        
    }

}
