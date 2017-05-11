<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Datatables;
use DB;
use Carbon\Carbon;
use App\Models\ContentPage;

class ContentPageController extends Controller {

    public $contentPage;
    public $status;
    public $headerMenu;
    public $footerMenu;

    public function __construct() {
        $this->contentPage = new ContentPage();
        $this->frontPage = new \App\Models\FrontPage();

        $this->status = ['' => trans("form.select_status"), 'Published' => 'Published', 'Draft' => 'Draft'];
        $this->headerMenu = $this->contentPage->getFrontMenu("Header");
        $this->footerMenu = $this->contentPage->getFrontMenu("Footer");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {




        $page_title = 'Manage Content Pages';
        $page_description = 'Content Pages';
        return view('admin.content_page.index', compact('page_title', 'page_description'));
    }

    public function datatableList(Request $request) {
   
        //DB::enableQueryLog();

        $contentPages = ContentPage::select('content_pages.id', 'content_pages.page_title', 'header_front_menu_id', 'footer_front_menu_id', DB::raw('(CASE WHEN content_pages.header_front_menu_id > 0 THEN "Yes" ELSE "No" END) AS header_position'), DB::raw('(CASE WHEN content_pages.footer_front_menu_id > 0 THEN "Yes" ELSE "No" END) AS footer_position'), 'content_pages.status', 'content_pages.created_at', 'content_pages.updated_at');
        //dd(DB::getQueryLog());
        

        
        $hasPermission['update'] = (checkAuthorize('content_pages','update_access')) ? TRUE : FALSE;
        $hasPermission['delete'] = (checkAuthorize('content_pages','delete_access')) ? TRUE : FALSE;
        
        return Datatables::of($contentPages)
                         ->editColumn('page_title', function ($contentPage) {
                            return '<a data-toggle="modal" href="content/'.$contentPage->id.'" data-target="#advertisement_detail_modal">'.$contentPage->page_title.'</a>';
                                })   
                        ->addColumn('action', function ($contentPage) use ($hasPermission){
                            $action = '';
                            $action .= ($hasPermission['update']) ? '<a href="' . route(config('project.admin_route') . 'content_pages.edit', encrypt($contentPage->id)) . '" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>' : '';
                            $action .= ($hasPermission['delete']) ? '&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-xs fa fa-trash-o deleteContentPage" data-toggle="modal" data-placement="top" title="Delete" data-contentpage_delete_remote="' . route(config('project.admin_route') . 'content_pages.destroy', encrypt($contentPage->id)) . '"></a>' : '';
                            return $action;
                        })
                        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $status = $this->status;
        $headerMenu = $this->headerMenu;
        $footerMenu = $this->footerMenu;
        /* $headerMenu = collect($this->contentPage->getFrontMenu("Header"));
          $headerPlucked = $headerMenu->pluck('menu_name', 'id');
          $headerMenu = $headerPlucked->all(); */

        return view('admin.content_page.create', compact('status', 'headerMenu', 'footerMenu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            
            'page_title'        => 'required|max:50|unique:content_pages',
            'position_footer'   => 'required',
            'description'       => 'required',
            'meta_title'        => 'required|max:50',
            'meta_keywords'     => 'required|max:200',
            'meta_description'  => 'required|max:160',
            'status'            => 'required',
  
        ]);

        if ($request->get('position_header') != 'on' && $request->get('position_footer') != 'on') {
            \Flash::error(trans("validation_custom.content_page.check_atleast_one_page_position"));
            return redirect()->back()->withInput();
        }

        // Start transaction!
        DB::beginTransaction();
        try {
            $frontFooterPageId = $frontHeaderPageId = 0;
            if ($request->get('position_header') == 'on') {
                //$this->frontPage = new \App\FrontPage();
                $requestData['page_name']          = $request->get('page_title');
                $requestData['page_relative_path'] = str_slug($request->get('page_title'));
                $requestData['front_menu_id']      = $request->get('header_front_menu_id');
                $requestData['status']             = 1;
                $requestData['position']           = 'Header';
                $requestData['created_at']         = Carbon::now();
                $frontHeaderPageId                 = $this->frontPage->createFrontPage($requestData);
            }

            if ($request->get('position_footer') == 'on') {
                $requestData = [];
                //$this->frontPage = new \App\FrontPage();
                $requestData['page_name']          = $request->get('page_title');
                $requestData['page_relative_path'] = str_slug($request->get('page_title'));
                $requestData['front_menu_id']      = $request->get('footer_front_menu_id');
                $requestData['status']             = 1;
                $requestData['position']           = 'Footer';
                $requestData['created_at']         = Carbon::now();
                $frontFooterPageId = $this->frontPage->createFrontPage($requestData);
            }

            $request->merge(['header_front_page_id' => $frontHeaderPageId,
                'header_front_menu_id' => $frontHeaderPageId != 0 ? $request->get('header_front_menu_id') : 0,
                'footer_front_page_id' => $frontFooterPageId,
                'footer_front_menu_id' => $frontFooterPageId != 0 ? $request->get('footer_front_menu_id') : 0,
                'slug' => str_slug($request->get('page_title'))
            ]);

            $this->contentPage->createContentPage($request);
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            \Flash::error(trans('message.failure'));
            return redirect()->route(config('project.admin_route') . 'content_pages.index');
        }

        // If we reach here, then data is valid and working. Commit the queries!
        DB::commit();

        \Flash::success(trans('message.content_page.add_success'));
        return ($request->ajax()) ?
                response()->json(['status' => 'success', 'redirectUrl' => route(config('project.admin_route') . 'content_pages.index')]) :
                redirect()->route(config('project.admin_route') . 'content_pages.index');
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
        $status = $this->status;
        $headerMenu = $this->headerMenu;
        $footerMenu = $this->footerMenu;

        $contentPageData = $this->contentPage->getContentPage($id);

        if (empty($contentPageData)) {
            return redirect()->route(config('project.admin_route') . 'content_pages.index');
        }

        return view('admin.content_page.edit', compact('status', 'contentPageData', 'headerMenu', 'footerMenu'));
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

        $this->validate($request, [
            'page_title'       => 'required|max:50|unique:content_pages,page_title,' . $id,
            'description'      => 'required',
            'meta_title'       => 'max:50',
            'meta_keywords'    => 'max:200',
            'meta_description' => 'max:160',
            'status'           => 'required',
        ]);

        if ($request->get('position_header') != 'on' && $request->get('position_footer') != 'on') {
            \Flash::error(trans("validation_custom.content_page.check_atleast_one_page_position"));
            return redirect()->back()->withInput();
        }

        $requestFields = $request->except(['_method', '_token']);


        // Start transaction!
        DB::beginTransaction();
        try {


            $frontFooterPageId = $request->get('footer_front_page_id');

            if ($request->get('position_footer') == 'on') {
                $requestData = [];
                //$this->frontPage = new \App\FrontPage();
                $requestData['page_name'] = $request->get('page_title');
                $requestData['page_relative_path'] = str_slug($request->get('page_title'));
                $requestData['front_menu_id'] = $request->get('footer_front_menu_id');
                $requestData['status'] = 1;
                $requestData['position'] = 'Footer';

                //$this->frontPage->createOrUpdateFrontPage($requestData, $frontFooterPageId);

                if ($frontFooterPageId == 0) {
                    $frontFooterPageId = $this->frontPage->createFrontPage($requestData);
                } else {
                    $this->frontPage->updateFrontPage($requestData, $frontFooterPageId);
                }
            } else if ($frontFooterPageId != 0) {
                //$this->frontPage = new \App\FrontPage();
                $this->frontPage->deleteFrontPage($frontFooterPageId);
            }


            $frontHeaderPageId = $request->get('header_front_page_id');

            if ($request->get('position_header') == 'on') {
                //$this->frontPage = new \App\FrontPage();
                $requestData['page_name'] = $request->get('page_title');
                $requestData['page_relative_path'] = str_slug($request->get('page_title'));
                $requestData['front_menu_id'] = $request->get('header_front_menu_id');
                $requestData['status'] = 1;
                $requestData['position'] = 'Header';

                //$this->frontPage->createOrUpdateFrontPage($requestData, $frontHeaderPageId);

                if ($frontHeaderPageId == 0) {
                    $frontHeaderPageId = $this->frontPage->createFrontPage($requestData);
                } else {
                    $this->frontPage->updateFrontPage($requestData, $frontHeaderPageId);
                }
            } else if ($frontHeaderPageId != 0) {
                //$this->frontPage = new \App\FrontPage();
                $this->frontPage->deleteFrontPage($frontHeaderPageId);
            }

            $request->merge([
                'header_front_page_id' => $request->get('position_header') == 'on' ? $frontHeaderPageId : 0,
                'header_front_menu_id' => $frontHeaderPageId != 0 && $request->get('position_header') == 'on' ? $request->get('header_front_menu_id') : 0,
                'footer_front_page_id' => $request->get('position_footer') == 'on' ? $frontFooterPageId : 0,
                'footer_front_menu_id' => $frontFooterPageId != 0 && $request->get('position_footer') == 'on' ? $request->get('footer_front_menu_id') : 0,
                'slug' => str_slug($request->get('page_title'))
            ]);

            $this->contentPage->updateContentPage($request, $id);
        } catch (\Exception $e) {

            // Rollback transaction
            DB::rollBack();
            \Flash::error(trans('message.failure'));
            return redirect()->route(config('project.admin_route') . 'content_pages.index');
        }

        // If we reach here, then data is valid and working. Commit the queries!
        DB::commit();

        \Flash::success(trans('message.content_page.update_success'));
        return ($request->ajax()) ?
                response()->json(['status' => 'success', 'redirectUrl' => route(config('project.admin_route') . 'content_pages.index')]) :
                redirect()->route(config('project.admin_route') . 'content_pages.index');
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

            // Remove front pages
            $contentPageData = $this->contentPage->getContentPage($id);
            //echo "<pre>";print_r($contentPageData);die;
            if ($contentPageData['header_front_page_id'] != 0) {
                $this->frontPage->deleteFrontPage($contentPageData['header_front_page_id']);
            }

            if ($contentPageData['footer_front_page_id'] != 0) {
                $this->frontPage->deleteFrontPage($contentPageData['footer_front_page_id']);
            }

            // remove content page
            $data = ContentPage::findOrFail($id)->delete();
            if ($request->ajax()) {
                return response(['msg' => trans('message.content_page.delete_success'), 'success' => 1]);
            }
            //} catch (\Illuminate\Database\QueryException $ex) {
        } catch (\Exception $ex) {
            return response(['msg' => $ex->getMessage(), 'success' => 0]); //$ex->getMessage()
            //return response(['msg' => trans('message.failure'), 'success' => 0]);
        }
    }
    public function getPost($id){
            $page= ContentPage::find($id);
            return view('admin.content_page.details', compact('page'));
    }
    public function preview(Request $request){                 
        return  file_get_contents(getenv('FRONT_APP_URL').'/page-preview');                 
    }
}