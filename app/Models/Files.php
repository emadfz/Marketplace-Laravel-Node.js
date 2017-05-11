<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Files extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'files';

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
    protected $fillable = array(
        'path',
        'imageable_id',
        'imageable_type',
        'file_type',
    );
    
    public function imageable()
    {
      return $this->morphTo();
    }
    
    public function deletevalues($id)
    {
        return DB::table('files')->where('imageable_id', $id)->delete();
    }    
    public static function getFileById($id){
        return self::where('id',$id)->first();
    }
}
