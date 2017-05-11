<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Datatables;
use DB;
use Validator;
use Carbon\Carbon;
use App\Models\Faq;
use App\Models\FaqTopic;

class FaqController extends Controller {

    public $faqTopic;
    public $faq;
    private $setFaqTopicData;

    public function __construct() {
        $this->faqTopic = new FaqTopic();
        $this->faq = new Faq();
        $this->setFaqTopicData = [['topic_name' => '', 'faqs' => [['id' => '', 'faq_topic_id' => '', 'question' => '', 'answer' => '']]]];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $page_title = 'Manage FAQs';
        $page_description = 'FAQ Topics';
        return view('admin.faq.index', compact('page_title', 'page_description'));
    }

    public function datatableList(Request $request) {
        $faqTopics = FaqTopic::select('id', 'topic_name', 'updated_at', 'created_at');

        $hasPermission['updte'] = (checkAuthorize('faq','update_access')) ? TRUE : FALSE;
        $hasPermission['delete'] = (checkAuthorize('faq','delete_access')) ? TRUE : FALSE;
        
        return Datatables::of($faqTopics)
                        ->addColumn('action', function ($faqTopic) use ($hasPermission){
                            $action = '';
                            $action .= $hasPermission['updte'] ? '<a href="' . route(config('project.admin_route') . 'faq.edit', encrypt($faqTopic->id)) . '" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="'.trans('form.edit').'"><i class="glyphicon glyphicon-edit"></i></a>':'';
                            $action .= $hasPermission['delete'] ? '&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-xs fa fa-trash-o deleteFaqTopic" data-toggle="modal" data-placement="top" title="'.trans('form.delete').'" data-faqtopic_delete_remote="' . route('destroyFaqTopic', encrypt($faqTopic->id)) . '"></a>':'';
                            return $action;
                        })
                        ->editColumn('updated_at', function ($faqTopic) {
                            return ($faqTopic->updated_at != "") ? $faqTopic->updated_at : "-";
                        })
                  
                        ->editColumn('topic_name', function ($faqTopic) {
                            return ($faqTopic->topic_name != "") ? '<a href="'.route(config('project.admin_route').'faq.edit', encrypt($faqTopic->id)).'">'.$faqTopic->topic_name.'</a>' : "-";
                        })
                        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $faqTopicData = $this->setFaqTopicData;
        return view('admin.faq.create', compact('id', 'faqTopicData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        
        //$this->insertUpdateOperation($request);
        $faqValidation = [
            'topic_name' => 'required|string|max:255|unique:faq_topics',
            //'topic_name' => 'required|string|max:255|unique:democategories,title,' . $category->id, //Forcing A Unique Rule To Ignore A Given ID
            'faq.*.question' => 'required',
            'faq.*.answer' => 'required',
        ];
        
        $this->validate($request, $faqValidation, ['faq.*.question.required' => trans('validation_custom.faq.faq_que_required'), 'faq.*.answer.required' => trans('validation_custom.faq.faq_ans_required')]);
        //echo "<pre>";print_r($validator->errors());die;
        
        // Start transaction!
        DB::beginTransaction();
        try {
            // Create faq topic
            $faqTopicInsertedId = $this->faqTopic->createFaqTopic($request);

            $faqs = $request->only('faq');
            foreach ($faqs['faq'] AS $k => $questionAnswer) {
                // Create faq using faq topic id
                $questionAnswer['faq_topic_id'] = $faqTopicInsertedId;
                $this->faq->createFaq($questionAnswer);
                unset($questionAnswer['faq_topic_id']);
            }
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            // back to form with errors
            return response()->json(['status' => 'error', 'messages' => ['global_form_message' => trans('message.failure')]]);
        }

        // If we reach here, then data is valid and working. Commit the queries!
        DB::commit();

        \Flash::success(trans('message.faq.add_success'));
        return ($request->ajax()) ?
                response()->json(['status' => 'success', 'redirectUrl' => route(config('project.admin_route') . 'faq.index')]) :
                redirect()->route(config('project.admin_route') . 'faq.index');
        
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $id = decrypt($id);
        $faqTopicData = $this->faqTopic->getFaqTopic($id);

        if(empty($faqTopicData)){
            return redirect()->route(config('project.admin_route') . 'faq.index');
        }
            
        if (empty($faqTopicData[0]['faqs'])) {
            $faqTopicData[0]['faqs'] = $this->setFaqTopicData[0]['faqs'];
        }
        
        return view('admin.faq.edit', compact('id', 'faqTopicData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        
        $id = decrypt($id);
        //$faqTopic = FaqTopic::findOrFail($id, ['id']);
        
        $faqValidation = [
            'topic_name' => 'required|string|max:255|unique:faq_topics,topic_name,' . $id,
            'faq.*.question' => 'required',
            'faq.*.answer' => 'required',
        ];
        
        $this->validate($request, $faqValidation);
        
        // Start transaction!
        DB::beginTransaction();
        try {
                        
            // Create faq topic
            $this->faqTopic->updateFaqTopic($request, $id);

            $faqs = $request->only('faq');
            
            foreach ($faqs['faq'] AS $k => $questionAnswer) {
                //echo "<pre>";print_r($questionAnswer);
                if(isset($questionAnswer['id']) && $questionAnswer['id'] != ""){
                    $this->faq->updateFaq($questionAnswer, decrypt($questionAnswer['id']));
                }else{
                    $questionAnswer['faq_topic_id'] = $id;
                    $this->faq->createFaq($questionAnswer);
                    unset($questionAnswer['faq_topic_id']);
                }
                
            }
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            // back to form with errors
            return response()->json(['status' => 'error', 'messages' => ['global_form_message' => trans('message.failure')]]);
        }

        // If we reach here, then data is valid and working. Commit the queries!
        DB::commit();

        \Flash::success(trans('message.faq.update_success'));
        return ($request->ajax()) ?
                response()->json(['status' => 'success', 'redirectUrl' => route(config('project.admin_route') . 'faq.index')]) :
                redirect()->route(config('project.admin_route') . 'faq.index');
        
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request) {
        $id = decrypt($id);

        try {
            $data = Faq::findOrFail($id)->delete();
            if ($request->ajax()) {
                return response(['msg' => trans('message.faq.delete_success'), 'success' => 1]);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return response(['msg' => $ex->errorInfo, 'success' => 0]);//$ex->getMessage()
            //return response(['msg' => trans('message.failure'), 'success' => 0]);
        }
        
    }
    
    public function destroyFaqTopic($id, Request $request){
        $id = decrypt($id);

        try {
            $data = FaqTopic::findOrFail($id)->delete();
            if ($request->ajax()) {
                return response(['msg' => trans('message.faq.faqtopic_delete_success'), 'success' => 1]);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return response(['msg' => $ex->errorInfo, 'success' => 0]);//$ex->getMessage()
            //return response(['msg' => trans('message.failure'), 'success' => 0]);
        }
    }
    
    protected function insertUpdateOperation($request, $id = NULL) {
        
        if($id != NULL){
            $id = decrypt($id);
            $faqTopic = FaqTopic::findOrFail($id);
        }
        
        $faqValidation = [
            'topic_name' => 'required|string|max:255|unique:faq_topics',
            //'topic_name' => 'required|string|max:255|unique:democategories,title,' . $category->id, //Forcing A Unique Rule To Ignore A Given ID
            'faq.*.question' => 'required',
            'faq.*.answer' => 'required',
        ];
        
        $this->validate($request, $faqValidation);
        //echo "<pre>";print_r($validator->errors());die;
        
        // Start transaction!
        DB::beginTransaction();
        try {
            // Create faq topic
            $faqTopicInsertedId = $this->faqTopic->createFaqTopic($request);

            $faqs = $request->only('faq');
            foreach ($faqs['faq'] AS $k => $questionAnswer) {
                // Create faq using faq topic id
                $questionAnswer['faq_topic_id'] = $faqTopicInsertedId;
                $this->faq->createFaq($questionAnswer);
                unset($questionAnswer['faq_topic_id']);
            }
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            // back to form with errors
            return response()->json(['status' => 'error', 'messages' => ['global_form_message' => trans('message.failure')]]);
        }

        // If we reach here, then data is valid and working. Commit the queries!
        DB::commit();

        \Flash::success(trans('message.faq.add_success'));
        return ($request->ajax()) ?
                response()->json(['status' => 'success', 'redirectUrl' => route(config('project.admin_route') . 'faq.index')]) :
                redirect()->route(config('project.admin_route') . 'faq.index');
    }

}
