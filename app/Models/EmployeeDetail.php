<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeDetail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admin_user_details';

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
    protected $fillable = ['admin_user_id','address_line1', 'address_line2','city_id','state_id','country_id','zipcode','working_hours_from','working_hours_to',
'days_of_week','deductibles','contract_start_date','contract_end_date','secret_question_id', 'secret_answer'];
        
}
