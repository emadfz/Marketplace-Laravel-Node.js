<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
use App\Models\FrontPage;

class ContentPage extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'content_pages';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_title', 'description',
        'meta_title', 'meta_keywords', 'meta_description',
        'status', 'slug', 'position',
        'header_front_menu_id', 'header_front_page_id', 'footer_front_menu_id', 'footer_front_page_id',
        'admin_user_id', 'created_at', 'updated_at'];
    public $timestamps = false;

    public function getContentPage($id = '') {
        if (isset($id) && $id != '') {
            return $this->where('id', $id)->first()->toArray();
        }
        return $this->get()->toArray();
    }

    /**
     * Create content page
     * @param array $request
     * @return inserted id
     */
    public function createContentPage($request) {
        //$data = $request->all();
        $data['page_title'] = $request->get('page_title');
        $data['description'] = $request->get('description');
        $data['meta_title'] = $request->get('meta_title');
        $data['meta_keywords'] = $request->get('meta_keywords');
        $data['meta_description'] = $request->get('meta_description');

        $data['slug'] = $request->get('slug');
        $data['header_front_page_id'] = $request->get('header_front_page_id');
        $data['header_front_menu_id'] = $request->get('header_front_menu_id');
        $data['footer_front_page_id'] = $request->get('footer_front_page_id');
        $data['footer_front_menu_id'] = $request->get('footer_front_menu_id');
        $data['status'] = $request->get('status');

        $data['admin_user_id'] = auth()->guard('admin')->user()->id;
        $data['created_at'] = Carbon::now();

        return $this->create($data)->id;
    }

    /**
     * Update content page
     * @param array $request
     * @param int $id
     * @return type
     */
    public function updateContentPage($request, $id) {
        $data['page_title'] = $request->get('page_title');
        $data['description'] = $request->get('description');
        $data['meta_title'] = $request->get('meta_title');
        $data['meta_keywords'] = $request->get('meta_keywords');
        $data['meta_description'] = $request->get('meta_description');

        $data['slug'] = $request->get('slug');
        $data['header_front_page_id'] = $request->get('header_front_page_id');
        $data['header_front_menu_id'] = $request->get('header_front_menu_id');
        $data['footer_front_page_id'] = $request->get('footer_front_page_id');
        $data['footer_front_menu_id'] = $request->get('footer_front_menu_id');
        $data['status'] = $request->get('status');
        $data['updated_at'] = Carbon::now();
        return $this->where('id', $id)->update($data);
    }

    /**
     * Get front menu
     * @param string $type
     * @return array
     */
    public function getFrontMenu($type = "") {
        //$result = \App\FrontMenu::select('id','menu_name')->where('position', '=', $type)->orWhere('position', '=', 'Both')->get()->toArray();
        $result = \App\Models\FrontMenu::select('id', 'menu_name')->where('position', '=', $type)->orWhere('position', '=', 'Both')->get()->pluck('menu_name', 'id');
        return $result;
    }

}
