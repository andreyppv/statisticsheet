<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

use App\Models\Admin;

class AuthController extends Controller
{
    protected $user = null;
    protected $menu = 'dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');

        $this->middleware(function ($request, $next) {
            $this->user= Auth::guard('admin')->user();

            // Share user in all view
            View::share('currentAdmin', $this->user);

            return $next($request);
        });
    }

    protected function view($view, $data=array()) {
        $data['menu'] = $this->menu;

        return view($view, $data);
    }
}
