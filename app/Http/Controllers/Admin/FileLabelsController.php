<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\filelabelsRequest;
use App\Http\Controllers\Controller;
use App\Models\FileLabels;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Datatables;
use DB;

class FileLabelsController extends Controller {
    
    public $FileLabels;

    public function __construct() {
        $this->FileLabels = new FileLabels();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $page_title = "{trans('form.file_labels.label_title')}";
        $page_description = 'Labels';
        return view('admin.filelabels.index', compact('page_title', 'page_description'));
    }

    public function datatableList(Request $request) {
        
        $labels=$this->FileLabels->getFileLabels();
        return Datatables::of($labels)
                        ->addColumn('action', function ($label) {
                            return '<a href="' . route(config('project.admin_route').'labels.edit', encrypt($label->id)) . '" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>' .
                                    '&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-xs fa fa-trash-o deleteCategory" data-toggle="modal" data-placement="top" title="Delete" data-category_delete_remote="' . route(config('project.admin_route').'labels.destroy', encrypt($label->id)) . '"></a>';
                        })
                        ->editColumn('label_description', '{!! str_limit($label_description, 40) !!}')
                        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.filelabels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(filelabelsRequest $request) {

        $data = $request->only('label_name', 'label_description');

        $labels=$this->FileLabels->saveLabel($data);        

        \Flash::success(trans('message.file_labels.add_success'));
        if ($request->ajax()) {
            return response()->json([
                        'status' => 'success',
                        'redirectUrl' => route(config('project.admin_route').'fileuploads.index'),
            ]);
        } else {
            return redirect()->route(config('project.admin_route').'labels.index');
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
        $all_labels=$this->FileLabels->getFileLabels();
        $labels=$this->FileLabels->getFileLabels($id);        
        return view('admin.filelabels.edit', compact('labels', 'all_labels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(filelabelsRequest $request, $id) {
        $id = decrypt($id);
        $labels=$this->FileLabels->getFileLabels($id);        
        
        $data = $request->only('label_name', 'label_description');
        $labels=$this->FileLabels->savelabel($data,$id); 

        \Flash::success(trans('message.file_labels.update_success'));

        if ($request->ajax()) {
            return response()->json([
                        'status' => 'success',
                        'redirectUrl' => route(config('project.admin_route').'labels.index'),
            ]);
        } else {
            return redirect()->route(config('project.admin_route').'labels.index');
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
            $this->FileLabels->deleteLabels($id);
            if ($request->ajax()) {
                return response(['msg' => trans('message.file_labels.delete_success'), 'success' => 1]);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return response(['msg' => $ex->errorInfo, 'success' => 0]);//$ex->getMessage()
        }
        
    }

}
