<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Democategory;
//use App\DataTables\CategoriesDataTable;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Datatables;
use DB;

class LevelsController extends Controller {

    public function __construct() {
        //$this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        /* $q = $request->get('q');
          $categories = Democategory::where('title', 'LIKE', '%' . $q . '%')->orderBy('id', 'desc')->paginate(10);
          return view('admin.categories.index', compact('categories', 'q'));
         */
        $page_title = 'Levels';
        $page_description = 'Listing of all Levels';
        return view('admin.levels.index', compact('page_title', 'page_description'));
    }

    public function datatableList(Request $request) {
        $categories = DB::table('level_modules')
                ->select([ 'level_modules.id','level_modules.module_id','level_modules.read_access', 'level_modules.create_access', 'level_modules.update_access', 'level_modules.delete_access',])
                ->where([['level_modules.status', '=', '1']]);
        return Datatables::of($categories)
                        ->addColumn('action', function ($category) {
                            return '<a href="' . route(config('project.admin_route').'categories.edit', encrypt($category->id)) . '" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>' .
                                    '&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-danger btn-xs fa fa-trash-o deleteCategory" data-toggle="modal" data-placement="top" title="Delete" data-category_delete_remote="' . route(config('project.admin_route').'categories.destroy', encrypt($category->id)) . '"></a>';
                        })
                        //'<button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete User" data-message="Are you sure you want to delete this user ?"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
                        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $all_categories = Democategory::pluck('title', 'id')->all();
        //$all_categories = Democategory::pluck('title', 'id')->where('status' ,'=', 'Active')->all();not working
        return view('admin.categories.create', compact('all_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required|string|max:255|unique:democategories',
            'description' => 'required|string',
            'parent_id' => 'exists:categories,id',
            'status' => 'required',
            'photo' => 'mimes:jpeg,png|max:1024'//'dimensions:min_width=100,min_height=200
            //'video' => 'mimetypes:video/avi,video/mpeg,video/quicktime'
        ]);

        $data = $request->only('title', 'description', 'parent_id', 'status');

        # ref link https://laravel.com/docs/5.2/requests#files
        if ($request->hasFile('photo')) {
            if ($request->file('photo')->isValid()) {
                $uploaded_file_info = $this->savePhoto($request->file('photo'));

                $data['photo'] = $uploaded_file_info['filename'];
            }
        }

        // Democategory::create($request->all());
        Democategory::create($data);

        \Flash::success(trans('message.category.add_success'));
        if ($request->ajax()) {
            return response()->json([
                        'status' => 'success',
                        'redirectUrl' => route(config('project.admin_route').'categories.index'),
            ]);
        } else {
            return redirect()->route(config('project.admin_route').'categories.index');
        }
    }

    /**
     * Move uploaded photo to public/uploads folder
     * @param  UploadedFile $photo
     * @return string
     */
    protected function savePhoto(UploadedFile $photo) {
        $fileName = time() . str_random(25) . '.' . $photo->guessClientExtension();

        // uploads path
        $destinationPath = public_path() . config('project.category_images_path');
        $photo->move($destinationPath, $fileName);

        $uploaded_file_info['destination_path'] = $destinationPath;
        $uploaded_file_info['filename'] = $fileName;
        $uploaded_file_info['original_filename'] = $photo->getClientOriginalName();
        $uploaded_file_info['extension'] = $photo->getClientOriginalExtension();
        return $uploaded_file_info;
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
        $all_categories = Democategory::pluck('title', 'id')->all();
        $category = Democategory::findOrFail($id);
        return view('admin.categories.edit', compact('category', 'all_categories'));
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
        $category = Democategory::findOrFail($id);
        //https://laravel.com/docs/5.2/validation#rule-timezone
        $this->validate($request, [
            'title' => 'required|string|max:255|unique:democategories,title,' . $category->id, //Forcing A Unique Rule To Ignore A Given ID
            'description' => 'required|string',
            'parent_id' => 'exists:categories,id',
            'status' => 'required',
            'photo' => 'mimes:jpeg,png|max:1024'//'dimensions:min_width=100,min_height=200
        ]);

        $data = $request->only('title', 'description', 'parent_id', 'status');

        if ($request->hasFile('photo')) {
            if ($request->file('photo')->isValid()) {
                $uploaded_file_info = $this->savePhoto($request->file('photo'));
                $data['photo'] = $uploaded_file_info['filename'];
            }

            // delete old photo
        }


        //$category->update($request->all());
        $category->update($data);

        \Flash::success(trans('message.category.update_success'));

        if ($request->ajax()) {
            return response()->json([
                        'status' => 'success',
                        'redirectUrl' => route(config('project.admin_route').'categories.index'),
            ]);
        } else {
            return redirect()->route(config('project.admin_route').'categories.index');
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
            $data = Democategory::findOrFail($id)->delete();
            if ($request->ajax()) {
                return response(['msg' => trans('message.category.delete_success'), 'success' => 1]);
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return response(['msg' => $ex->errorInfo, 'success' => 0]);//$ex->getMessage()
            //return response(['msg' => trans('message.failure'), 'success' => 0]);
        }
        
    }

}
