<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
	//

	public function index()
	{
		if (Auth::check()) {
			$users = User::all();

			return View::make('users.index')->with('users', $users);
		} else {
			return redirect("login");
		}
	}

	public function register()
	{
		if (Auth::check()) {
			return View::make('users.create');
		} else {
			return redirect("login");
		}
	}

	public function store()
	{
		if (Auth::check()) {
			$rules = array(
				'user_name' => 'required',
				'user_email' => 'required',
				'user_password' => 'required',
				'user_role' => 'required',
			);

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails()) {
				// If the validation fails then deal with it.
				Session::flash('alert-danger', 'Processing Error Occured.');
				return Redirect::to('users/register')->withErrors($validator)->withInput(Input::except('user_name'));
			} else {
				$user = new User();
				$user->name = Input::get("user_name");
				$user->email = Input::get("user_email");
				$user->password = Hash::make(Input::get("user_password"));
				$user->user_role = Input::get("user_role");
				$user->save();

				// redirect
				Session::flash('alert-success', 'Successfully created new user.');
				return Redirect::to('users');
			}
		} else {
			return redirect("login");
		}
	}

	public function destroy($id)
	{
		if (Auth::check()) {
			$user = User::find($id);
			$user->delete();

			// redirect
			Session::flash('alert-success', 'Successfully deleted user.');
			return Redirect::to('users');
		} else {
			return redirect("login");
		}
	}
}
