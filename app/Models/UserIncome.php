<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserIncome extends Model
{
    protected $fillable = ['user_id', 'year', 'name', 'hash'];
    protected $appends = array('total', 'avg');

    public function getTotalAttribute() {
        $fields = report_fields(false);
        $sum = 0;
        foreach($fields as $key => $field) {
            $sum += $this->$key;
        }

        return $sum;
    }

    public function getAvgAttribute() {
        return $this->total / 12;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // relations
    /////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}