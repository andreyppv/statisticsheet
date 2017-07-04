<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

use App\Models\User;

class AuthController extends Controller
{
    protected $user = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            $this->user= Auth::user();

            // Share user in all view
            View::share('currentUser', $this->user);

            return $next($request);
        });
    }
}
