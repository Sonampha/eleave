<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtRecord extends Model
{
    /**
     * @return object
     */
    public function otReason(){
        /**
         *  return department which belongs to an employee.
         *  first parameter is the model and second is a
         *  foreign key.
         */
        return $this->belongsTo('App\OtReason','ot_reason_id');
    }
}
