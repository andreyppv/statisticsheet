<?php

namespace App\Models;

use App\User as BaseUser;
use Carbon\Carbon;

class User extends BaseUser
{
    protected $fillable = ['name', 'email', 'password'];

    private $dataYear = false;

    protected static function boot() {
        parent::boot();

        static::created(function($row) { // after create() method call this
            $row->addSampleData();
        });

        static::deleting(function($row) { // before delete() method call this
            $row->incomes()->delete();
            $row->categories()->delete();
        });
    }

    public function __construct()
    {
        parent::__construct();

        $this->dataYear = date('Y');
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // relations
    /////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function incomes($check = true) {
        if($check) {
            // check income is exist for selected dateYear
            $count = UserIncome::whereUserId($this->id)
                ->where('year', $this->dataYear)
                ->count();
            if($count == 0) {
                $this->createBasicIncomeItems();
            }
        }

        return $this->hasMany(UserIncome::class, 'user_id');
    }

    public function categories($check = true) {
        if($check) {
            // check income is exist for selected dateYear
            $count = ExpenseCategory::whereUserId($this->id)
                ->where('year', $this->dataYear)
                ->count();
            if ($count == 0) {
                $this->createBasicExpenseCategory();
            }
        }

        return $this->hasMany(ExpenseCategory::class, 'user_id');
    }

    public function expenses() {
        return $this->hasManyThrough('App\Models\UserExpense', 'App\Models\ExpenseCategory', 'user_id', 'category_id');
    }

    /**
     * calculate total incomes
     *
     * @return \stdClass
     */
    public function totalIncomes() {
        // init result;
        $result = new \stdClass();
        $fields = report_fields();
        foreach ($fields as $key => $field) {
            $result->$key = 0;
        }

        $rows = $this->incomes()
            ->where('year', $this->dataYear)
            ->get();
        foreach($rows as $row) {
            foreach ($fields as $key => $field) {
                $result->$key += $row->$key;
            }
        }

        return $result;
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

        $rows = $this->expenses()
            ->where('year', $this->dataYear)
            ->get();
        foreach($rows as $row) {
            foreach ($fields as $key => $field) {
                $result->$key += $row->$key;
            }
        }

        return $result;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // setter and getter
    /////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param $year
     * @return $this
     */
    public function setDataYear($year) {
        $this->dataYear = $year;

        return $this;
    }

    public function getDataYear() {
        return $this->dataYear;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // accessory function
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * create mandatory income items
     *
     * @return bool
     */
    public function createBasicIncomeItems() {
        $now = Carbon::now()->format('Y-m-d H:i:s');

        $bulkRows = array(
            array('year' => $this->dataYear, 'user_id' => $this->id, 'name' => 'Wages & Tips', 'hash' => md5(str_random()), 'created_at' => $now, 'updated_at' => $now),
            array('year' => $this->dataYear, 'user_id' => $this->id, 'name' => 'Net Income', 'hash' => md5(str_random()), 'created_at' => $now, 'updated_at' => $now),
            array('year' => $this->dataYear, 'user_id' => $this->id, 'name' => 'Gifts Received', 'hash' => md5(str_random()), 'created_at' => $now, 'updated_at' => $now),
            array('year' => $this->dataYear, 'user_id' => $this->id, 'name' => 'Other', 'hash' => md5(str_random()), 'created_at' => $now, 'updated_at' => $now)
        );

        UserIncome::insert($bulkRows);

        return true;
    }

    /**
     * create first expense category
     *
     * @return mixed
     */
    public function createBasicExpenseCategory($hash = false) {
        $now = Carbon::now()->format('Y-m-d H:i:s');

        return ExpenseCategory::insert([
            'year' => $this->dataYear,
            'user_id' => $this->id,
            'name' => ExpenseCategory::DEFAULT_NAME,
            'hash' => $hash ?: md5(str_random()),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    /**
     * import sample data for new users
     */
    public function addSampleData() {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $sampleData = array(
            'HOME EXPENSES' => array('Mortgage/Rent', 'Electricity', 'Gas/Oil', 'Water/Sewer/Trash', 'Phone',
                'Cable/Satellite', 'Furnishing/Appliances', 'Lawn/Garden', 'Maintenance', 'Improvements', 'Other'),
            'DAILY LIVING'  => array('Groceries', 'Personal Supplies', 'Clothing', 'Cleaning Services',
                'Dining/Eating Out', 'Dry Cleaning', 'Salon/Barber', 'Other'),
            'CHILDREN' => array('Medical', 'Clothing', 'School Tuition', 'School Lunch',
                'School Supplies', 'Babysitting', 'Toys/Games', 'Other'),
            'TRANSPORTATION'=> array('Vehicle Payments', 'Fuel', 'Bus/Taxi/Train fare', 'Repairs', 'Registration/License', 'Other'),
            'CHARITY/GIFTS' => array('Gift Giving', 'Charitable Donations', 'Religious Donations', 'Other'),
            'OBLIGATIONS'   => array('Student Loan', 'Other Loan', 'Credit Card #1', 'Credit Card #2',
                'Alimony/Child Support', 'Federal Taxes', 'State/Local Taxes', 'Legal Fees', 'Other'),
            'ENTERTAINMENT' => array('Videos/DVDs', 'Music', 'Games', 'Rentals', 'Movies/Theater', 'Concerts/Plays',
                'Books', 'Hobbies', 'Film/Photos', 'Sports', 'Outdoor Recreation', 'Toys/Gadgets', 'Other'),
            'PETS'          => array('Food', 'Medical', 'Toys/Supplies', 'Other'),
            'SUBSCRIPTIONS' => array('Netflix', 'Hulu', 'HBO', 'Amazon', 'Other')
        );

        foreach($sampleData as $categoryName => $row) {
            $category = ExpenseCategory::create([
                'year' => $this->dataYear,
                'user_id' => $this->id,
                'name' => $categoryName,
                'hash' => md5(str_random()),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            foreach($row as $itemName) {
                $expense = UserExpense::create([
                    'category_id' => $category->id,
                    'user_id' => $this->id,
                    'name' => $itemName,
                    'hash' => md5(str_random()),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        return true;
    }
}
