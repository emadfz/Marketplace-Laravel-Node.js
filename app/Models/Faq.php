<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Faq extends Model
{
    protected $table = 'faqs';
    protected $fillable = ['faq_topic_id', 'question', 'answer', 'created_at', 'updated_at'];
    public $timestamps  = false;
    
    public function faq_topics()
    {
        return $this->belongsTo('App\Models\FaqTopic','id');
    }
    
    public function createFaq($request){
        $data = [];
        $data['faq_topic_id'] = $request['faq_topic_id'];
        $data['question'] = $request['question'];
        $data['answer'] = $request['answer'];
        $data['created_at'] = Carbon::now();
        return $faqInsertedId = $this->create($data)->id;
    }
    
    public function updateFaq($request, $id){
        $data = [];
        $data['question'] = $request['question'];
        $data['answer'] = $request['answer'];
        $data['updated_at'] = Carbon::now();
        return $this->where('id', $id)->update($data);
    }
    
}
