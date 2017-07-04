<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserExpense extends Model
{
    const DEFAULT_NAME = 'Edit Name';

    protected $fillable = ['category_id', 'name', 'hash'];
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
    
    public function category() {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }
}
