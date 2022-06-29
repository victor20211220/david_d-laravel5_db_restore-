<?php

namespace App\Http\Controllers;

use App\Messages;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class FollowupController extends Controller
{
    //

    public function index() {
        $lead = DB::select("SELECT * FROM messages WHERE `updated_at` > NOW() - INTERVAL 1 HOUR AND status='sent' ORDER BY id ASC");

        return View::make('followup.index')->with('leads', $lead);
    }

    public function search($time) {
        if ($time == "yesterday") {
            // 1 Hour Ago
            $lead = DB::select("SELECT * FROM messages WHERE `updated_at` > NOW() - INTERVAL 1 DAY AND status='sent' ORDER BY id ASC");
            $num = count($lead);

            if ($num == 0) {
                $data = array(
                    "success"=>true,
                    "data"=>"No leads"
                );
                return json_encode($data);
            } else {
                $result = "";

                foreach ($lead as $item) {
                    $edit = URL::to('followup/' . $item->id . '/show');
                    $result .= '<tr><td>' . $item->id . '.</td><td>' . $item->name . '</td><td>' . $item->industry . '</td><td>' . $item->area . '</td><td>' . $item->message . '</td><td><a class="btn btn-small btn-primary btn-sm" href="' . $edit . '">Follow Up</a></td></tr>';
                }

                $data = array(
                    "success"=>true,
                    "data"=>$result
                );

                return json_encode($data);
            }
        } else {
            // 2 Hours Ago
            $lead = DB::select("SELECT * FROM messages WHERE `updated_at` > NOW() - INTERVAL " . $time . " HOUR AND status='sent' ORDER BY id ASC");
            $num = count($lead);

            if ($num == 0) {
                $data = array(
                    "success"=>true,
                    "data"=>"No leads"
                );
                return json_encode($data);
            } else {

                $result = "";

                foreach ($lead as $item) {
                    $edit = URL::to('followup/' . $item->id . '/show');
                    $result .= '<tr><td>' . $item->id . '.</td><td>' . $item->name . '</td><td>' . $item->industry . '</td><td>' . $item->area . '</td><td>' . $item->message . '</td><td><a class="btn btn-small btn-primary btn-sm" href="' . $edit . '">Follow Up</a></td></tr>';
                }

                $data = array(
                    "success" => true,
                    "data" => $result
                );

                return json_encode($data);
            }
        }
    }

    public function show($id) {
        $lead = Messages::find($id);

        return View::make('followup.show')->with('lead', $lead);
    }

    public function save($id) {
        $lead = Messages::find($id);
        $lead->status = "followedup";
        $lead->save();

        // redirect
        Session::flash('alert-success', 'Successfully followed up lead');
        return Redirect::to('/followup');
    }

    public function moveBack($id) {
        $messages = Messages::find($id);
        $messages->status = "review";
        $messages->save();

        Session::flash('alert-success', 'Successfully moved lead.');
        return Redirect::to('/followup');
    }

}
