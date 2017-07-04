<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends AuthController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('name')->get();

        $params = [
            'users' => $users,
        ];
        return $this->view('admin.users.index', $params);
    }
}
