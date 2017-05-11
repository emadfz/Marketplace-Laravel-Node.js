<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AttributeSetCategory extends Model {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'attribute_set_categories';
    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['attribute_set_id', 'attribute_set_categoryid', 'is_deleted','created_at'];    
}
