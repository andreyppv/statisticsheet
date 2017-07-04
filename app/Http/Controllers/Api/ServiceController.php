<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;

use App\Models\ExpenseCategory;
use App\Models\UserExpense;
use App\Models\UserIncome;

class ServiceController extends AuthController
{
    /**
     * add expense category for user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCategory(Request $request)
    {
        $this->validate($request, [
            'hash' => 'required'
        ]);

        $this->user->createBasicExpenseCategory($request->get('hash'));

        return response()->json(['result' => 'success']);
    }

    /**
     * update expense category
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCategory(Request $request)
    {
        $this->validate($request, [
            'hash' => 'required',
            'name' => 'required'
        ]);

        $row = ExpenseCategory::whereHash($request->get('hash'))->first();
        if($row) {
            $row->name = $request->get('name');
            $row->save();

            return response()->json(['result' => 'success']);
        } else {
            return response()->json(['result' => 'fail']);
        }
    }

    /**
     * delete expense category
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeCategory(Request $request)
    {
        $this->validate($request, [
            'hash' => 'required'
        ]);

        $row = ExpenseCategory::whereHash($request->get('hash'))->first();
        if($row) {
            $row->delete();

            return response()->json(['result' => 'success']);
        } else {
            return response()->json(['result' => 'fail']);
        }
    }

    /**
     * add expense item
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addItem(Request $request)
    {
        $this->validate($request, [
            'hash' => 'required',
            'type' => 'required',
            'category_hash' => 'required'
        ]);

        $result = 'success';
        if($request->get('type') == 'income') {
            $row = new UserIncome;
            $row->name = UserExpense::DEFAULT_NAME;
            $row->hash = $request->get('hash');
            $row->save();
        } else {
            $row = new UserExpense;

            $category = ExpenseCategory::whereHash($request->get('category_hash'))->first();
            if($category) {
                $row->category_id = $category->id;
                $row->name = UserExpense::DEFAULT_NAME;
                $row->hash = $request->get('hash');
                $row->save();
            } else {
                $result = 'fail';
            }
        }

        return response()->json(['result' => $result]);
    }

    /**
     * update expense item's name
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateItem(Request $request)
    {
        $this->validate($request, [
            'hash' => 'required',
            'name' => 'required'
        ]);

        $result = 'fail';
        if($request->get('type') == 'income') {
            $row = UserIncome::whereHash($request->get('hash'))->first();
        } else {
            $row = UserExpense::whereHash($request->get('hash'))->first();
        }

        if($row) {
            $row->name = $request->get('name');
            $row->update();

            $result = 'success';
        }

        return response()->json(['result' => $result]);
    }

    /**
     * remove expense item
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeItem(Request $request)
    {
        $this->validate($request, [
            'hash' => 'required'
        ]);

        $result = 'fail';
        if($request->get('type') == 'income') {
            $row = UserIncome::whereHash($request->get('hash'))->first();
        } else {
            $row = UserExpense::whereHash($request->get('hash'))->first();
        }

        if($row) {
            $row->delete();

            $result = 'success';
        }

        return response()->json(['result' => $result]);
    }

    /**
     * udate expense month value
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateItemMonth(Request $request)
    {
        $this->validate($request, [
            'hash' => 'required',
            'type' => 'required',
            'key' => 'required',
            'value' => 'required'
        ]);

        $result = 'fail';
        if($request->get('type') == 'income') {
            $row = UserIncome::whereHash($request->get('hash'))->first();
        } else {
            $row = UserExpense::whereHash($request->get('hash'))->first();
        }

        if($row) {
            $key = $request->get('key');
            $row->$key = $request->get('value');
            $row->update();

            $result = 'success';
        }

        return response()->json(['result' => $result]);
    }
}
