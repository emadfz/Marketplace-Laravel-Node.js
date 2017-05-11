<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Democategory extends Model {

    protected $table = 'democategories';
    //protected $fillable = ['title', 'parent_id', 'description', 'photo', 'status'];
    protected $fillable = ['title', 'parent_id', 'description', 'status'];
    
    //To assign a global scope to a model, you should override a given model's boot method
    public static function boot()
    {
        parent::boot();

        static::deleting(function($model) {
            // remove parent from this category's child
            foreach ($model->childs as $child) {
                $child->parent_id = '';
                $child->save();
            }
            // remove relations to products
            $model->products()->detach();
        });
    }
    
    public function parent(){
        return $this->belongsTo('App\Models\Democategory', 'parent_id');
    }
    
    public function childs(){
        return $this->hasMany('App\Models\Democategory', 'parent_id');
    }
    
    public function products()
    {
        return $this->belongsToMany('App\Models\Demoproduct')->where('status','=','Active');
    }

}
