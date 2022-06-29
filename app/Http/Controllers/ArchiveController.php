<?php

namespace App\Http\Controllers;

use App\Messages;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\View;

class ArchiveController extends Controller
{
    //
    public function index() {
        $messages = Messages::all();

        $data = array(
            "messages" => $messages
        );

        return View::make("messages.archive")->with($data);

    }
}
