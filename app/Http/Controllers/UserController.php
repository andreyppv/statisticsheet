<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends AuthController
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

    public function profile()
    {
        return view('user.profile');
    }

    public function update(Request $request) {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $this->user->name = $request->get('name');
        $this->user->save();

        $request->session()->flash('alert-success', 'Profile was updated successfully!');

        return redirect(route('user.profile'));
    }
}
