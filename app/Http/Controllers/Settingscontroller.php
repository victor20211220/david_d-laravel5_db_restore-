<?php

namespace App\Http\Controllers;

use App\Settings;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class Settingscontroller extends Controller
{
    public function index() {
        if (Auth::check()) {
            $disclosure = $this->getDisclosure();
            $followUpEmail = $this->getFollowupEmail();
            $id = $this->getID();

            $data = array(
                'disclosure' => $disclosure,
                'followup_email' => $followUpEmail,
                "id" => $id
            );

            return View::make('settings.index')->with($data);
        } else {
            return redirect("login");
        }
    }

    public function getDisclosure() {
        if (Auth::check()) {
            $settings = Settings::all()->toArray();
            $json = json_decode($settings[0]["settings"]);

            return $json->disclosure;
        } else {
            return redirect("login");
        }
    }

    public function getFollowupEmail() {
        if (Auth::check()) {
            $settings = Settings::all()->toArray();
            $json = json_decode($settings[0]["settings"]);

            return $json->intervalEmail;
        } else {
            return redirect("login");
        }
    }

    public function getID() {
        if (Auth::check()) {
            $settings = Settings::all()->toArray();
            $json = json_decode($settings[0]["id"]);

            return $json;
        } else {
            return redirect("login");
        }
    }

    public function save() {
        if (Auth::check()) {
            $rules = array(
                'id' => 'required',
                'setting_disclosure' => 'required',
                'followup_email' => 'required'
            );

            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                // If the validation fails then deal with it.
                Session::flash('alert-danger', 'An Error Occured.');
                return Redirect::to('settings')->withErrors($validator)->withInput(Input::except('password'));
            } else {

                $disclosure = Input::get("setting_disclosure");
                $id = Input::get("id");
                $followup_email = Input::get("followup_email");

                $array = array(
                    'disclosure' => $disclosure,
                    'intervalEmail' => $followup_email
                );

                $settings = Settings::find($id);
                $settings->settings = json_encode($array);
                $settings->save();

                // redirect
                Session::flash('alert-success', 'Successfully saved Settings');
                return Redirect::to('settings');

            }
        } else {
            return redirect("login");
        }
    }
}
