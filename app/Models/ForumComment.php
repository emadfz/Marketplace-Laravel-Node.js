<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Datatables;
use Carbon\Carbon;

class ForumComment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'forum_comments';

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
    protected $fillable = ['created_at', 'id'];
    

    public function getComment($id,$beforFiveMonth,$currentDate){
        return $this->select('id','forum_id','created_at')->where('forum_id', $id)->whereBetween('created_at', [$beforFiveMonth, $currentDate])->get()->toArray();
    }
}