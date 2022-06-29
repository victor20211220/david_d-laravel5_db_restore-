<?php

namespace App\Http\Controllers;

use App\Messages;
use Illuminate\Http\Request;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\preMessageController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use Illuminate\Support\Facades\View;

class MessagesController extends Controller
{
    //

    public function index() {
        if (Auth::check()) {

            $messages = Messages::where('status', 'review')->get();

            $data = array(
                'messages' => $messages
            );

            return View::make('messages.index')->with($data);
        } else {
            return redirect("login");
        }
    }

    public function review($id) {
        if (\Auth::check()) {

            // Get Areas json data
            $areas = new AreasController();
            $industry = new IndustryController();
            $premessage = new preMessageController();
            $messages = Messages::where('id', $id)->get();

            // Get and compile the industry data

            $areaData = $areas->returnAreasJSON();
            $industries = $industry->GetIndustriesJSON();
            $messahe = $premessage->getPreMessagesJSON();

            //echo $areaData;

            $data = array(
                'areasJSON' => $areaData,
                'industry' => $industries,
                'premessage' => $messahe,
                'lead' => $messages
            );

            return View::make('messages.review')->with($data);
        } else {
            return redirect("login");
        }
    }

    public function edit($id) {
        if (Auth::check()) {
            $message = Messages::find($id)->toArray();
            // Get Areas json data
            $areas = new AreasController();
            $industry = new IndustryController();
            $premessage = new preMessageController();
            $messages = Messages::where('id', $id)->get();

            // Get and compile the industry data

            $areaData = $areas->returnAreasJSON();
            $industries = $industry->GetIndustriesJSON();
            $messahe = $premessage->getPreMessagesJSON();

            //echo $areaData;

            $data = array(
                'areasJSON' => $areaData,
                'industry' => $industries,
                'premessage' => $messahe,
                'message' => $message
            );

            return View::make('messages.edit')->with($data);
        } else {
            return redirect("login");
        }
    }

    public function destroy($id) {
        if (Auth::check()) {
            $messages = Messages::find($id);
            $messages->delete();

            Session::flash('message', 'Successfully deleted Message');
            return Redirect::to('messages');
        } else {
            return redirect("login");
        }
    }
}
