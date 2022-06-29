<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\PreMessage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

class preMessageController extends Controller
{
    //

    public function index() {
        if (Auth::check()) {
            $premessage = PreMessage::all();

            return View::make('premessage.index')->with('premessage', $premessage);
        } else {
            return redirect("login");
        }
    }

    public function create() {
        if (Auth::check()) {
            return View::make('premessage.create');
        } else {
            return redirect("login");
        }
    }

    public function store() {
        if (Auth::check()) {
            $rules = array(
                'massage_name' => 'required',
                'message' => 'required'
            );

            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                // If the validation fails then deal with it.
                Session::flash('alert-danger', 'An Error Occured.');
                return Redirect::to('premessages/create')->withErrors($validator)->withInput(Input::except('message'));
            } else {

                // Save the message
                $premessage = new PreMessage();
                $premessage->name = Input::get("massage_name");
                $premessage->message = Input::get("message");
                $premessage->save();

                // redirect
                Session::flash('message', 'Successfully created Message');
                return Redirect::to('premessages');

            }
        } else {
            return redirect("login");
        }
    }

    public function getPreMessagesJSON() {
        if (Auth::check()) {
            $messages = PreMessage::all(['id', 'name', 'message'])->toArray();
            return json_encode($messages);
        } else {
            return redirect("login");
        }
    }

    public function destroy($id) {
        if (Auth::check()) {
            $message = PreMessage::find($id);
            $message->delete();

            Session::flash('message', 'Successfully deleted Message');
            return Redirect::to('premessages');
        } else {
            return redirect("login");
        }
    }

    public function edit($id) {
        if (Auth::check()) {
            $message = PreMessage::find($id);

            return View::make('premessage.edit')->with('message', $message);
        } else {
            return redirect("login");
        }
    }

    public function update($id) {
        if (Auth::check()) {
            $rules = array(
                'massage_name' => 'required',
                'message' => 'required'
            );

            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                // If the validation fails then deal with it.
                Session::flash('alert-danger', 'An Error Occured.');
                return Redirect::to('premessages/create')->withErrors($validator)->withInput(Input::except('message'));
            } else {

                // Save the message
                $premessage = PreMessage::find($id);
                $premessage->name = Input::get("massage_name");
                $premessage->message = Input::get("message");
                $premessage->save();

                // redirect
                Session::flash('alert-success', 'Successfully updated Message');
                return Redirect::to('premessages');

            }
        } else {
            return redirect("login");
        }
    }
}
