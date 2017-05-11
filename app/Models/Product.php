<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['name',  'description', 'manufacturer', 'price', 'is_return_applicable', 'is_warranty_applicable', 'status','category_id','product_slug'];
    
    public static function boot()
    {
//        parent::boot();
//
//        static::deleting(function($model) {
//            // remove relations to category
//            $model->Files()->detach();
//        });
    }
    
    public function Files() {
        return $this->morphMany('App\Models\Files', 'imageable');
    }    
    public function categories()
    {
        return $this->belongsTo('App\Models\Category','category_id','id');
    }

    public function getCategoryListsAttribute()
    {
        if ($this->categories()->count() < 1) {
            return null;
        }
        return $this->categories->lists('id')->all();
    }

    /**
     * Get path to product photo or give placeholder if its not set
     * @return string
     */
    public function getPhotoPathAttribute()
    {
        if ($this->photo !== '') {
            return url(config('project.product_images_path') . $this->photo);
        } else {
            return 'http://placehold.it/850x618';
        }
    }
    
    public function saveProduct($data,$id=''){                                
        $data['product_slug']=str_slug($data['name']);
        if(isset($id) && !empty($id)){
            $product =$this->where('id', $id)->first();
            $product->update($data);                          
            
            if(isset($photo) && !empty($photo)){                                                        
                if($product->Files->count()>0){
                    $product->Files()->update($photo); 
                }
                $product->Files()->create($photo); 
            }                        
            return $product;
        }                
        $product=$this->create($data);
        if(isset($photo) && !empty($photo)){
            $product->Files()->create($photo);
        }
        return $product;
        //return $this->create($data)->Files()->create($photo);
    }
    public function getProduct($id=''){
        if(isset($id) && !empty($id)){
            return $this->where('id',$id)->with('categories')->first();
        }
        return $this->with('categories')->select('*');
    }
    public function deleteProduct($id){             
       $product=$this->where('id',$id)->first();        
       if($product->Files->count()>0){
         $product->files()->delete();
       }
       $product->delete();
       return true;
    }
        public function getProductByProductConditionId($id){
       return $this->where('product_condition_id',$id)->count();
    }
}