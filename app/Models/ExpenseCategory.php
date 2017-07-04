<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    const DEFAULT_NAME = 'New Category';

    protected $fillable = ['year', 'user_id', 'name', 'hash'];

    protected static function boot() {
        parent::boot();

        static::deleting(function($row) { // before delete() method call this
            $row->expenses()->delete();
        });
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // relations
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function expenses() {
        return $this->hasMany(UserExpense::class, 'category_id');
    }

    /**
     * calculate total expenses
     *
     * @return \stdClass
     */
    public function totalExpenses() {
        // init result;
        $result = new \stdClass();
        $fields = report_fields();
        foreach ($fields as $key => $field) {
            $result->$key = 0;
        }

        if($this->expenses) {
            foreach($this->expenses as $row) {
                foreach ($fields as $key => $field) {
                    $result->$key += $row->$key;
                }
            }
        }

        return $result;
    }
}
