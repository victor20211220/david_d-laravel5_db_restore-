<?php

namespace App\Http\Controllers;

use App\Messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;

class FreeController extends Controller
{
    //

    public function index() {

        if (Auth::check()) {
            $messages = Messages::where('status', 'free')->get();

            return View::make("messages.free")->with("messages", $messages);
        } else {
            return redirect('login');
        }
    }

    public function show($id) {
        if (Auth::check()) {
            $messages = Messages::find($id);

            $data = array(
                "message" => $messages
            );

            return View::make("free.show")->with($data);
        } else {
            return redirect('login');
        }

    }

    public function moveToReview($id) {
        if (Auth::check()) {
            $message = Messages::find($id);
            $message->status = "review";
            $message->save();

            Session::flash('alert-success', 'Successfully updated Contractor');
            return Redirect::to('freeleads');

        } else {
            return redirect('login');
        }
    }
}
