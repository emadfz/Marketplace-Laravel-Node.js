<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FaqTopic extends Model
{
    protected $table = 'faq_topics';
    protected $fillable = ['topic_name', 'slug', 'admin_user_id', 'created_at', 'updated_at'];
    public $timestamps  = false;
    
    public function faqs()
    {        
        return $this->hasMany('App\Models\Faq');
    }    
    
    
    public function getFaqTopic($id=''){
        if(isset($id) && $id != ''){
            return $this->with('faqs')->where('id',$id)->get()->toArray();
        }
        return $this->get()->toArray();
    }
    
    public function createFaqTopic($request){
        
        $data = [];
        $data['admin_user_id'] = auth()->guard('admin')->user()->id;
        $data['topic_name'] = $request->get('topic_name');
        $data['slug'] = str_slug($request->get('topic_name'));
        $data['created_at'] = Carbon::now();
        return $faqTopicInsertedId = $this->create($data)->id;
    }
    
    public function updateFaqTopic($request, $id){
        $data = [];
        $data['topic_name'] = $request->get('topic_name');
        $data['updated_at'] = Carbon::now();
        return $this->where('id', $id)->update($data);
    }
}
