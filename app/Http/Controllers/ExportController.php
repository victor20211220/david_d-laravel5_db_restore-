<?php

namespace App\Http\Controllers;

use App\Areas;
use App\BulkSMS;
use App\Category;
use App\Contractor;
use App\Industry;
use App\Messages;
use App\PreMessage;
use App\Settings;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    //

    public function index() {
        // Show the Export page

        $users = $this->getOperators();

        $data = array(
            "operators" => $users
        );

        return View::make("export.index")->with($data);
    }

    public function message() {
        $date = date("d-F-Y-H-i-s");

        $users = Messages::select('id', 'name', 'email', 'email_alt', 'phone', 'phone_alt', 'area', 'message', 'type', 'operator_name', 'created_at', 'updated_at')->get();
        Excel::create('Messages_'.$date, function($excel) use($users) {
            $excel->sheet('Messages', function($sheet) use($users) {
                $sheet->fromArray($users);
            });
        })->export('xls');

    }

    public function contractor() {
        $date = date("d-F-Y-H-i-s");

        $users = Contractor::select('id', 'name', 'emails', 'phones', 'leads_remaining', 'leads_status', 'area', 'created_at', 'updated_at')->get();
        Excel::create('Contractors_'.$date, function($excel) use($users) {
            $excel->sheet('Contractors', function($sheet) use($users) {
                $sheet->fromArray($users);
            });
        })->export('xls');
    }

    public function getOperators() {
        $users = User::all();

        return $users;

    }

    public function exportOperator() {
        // Export Operator's
        $id = Input::get("contractor");

        $date = date("d-F-Y-H-i-s");

        $users = Messages::select('id', 'name', 'email', 'email_alt', 'phone', 'phone_alt', 'area', 'message', 'type', 'operator_name', 'created_at', 'updated_at')->where('operator_id', $id)->get();
        Excel::create('Contractor_'.$id.'_'.$date, function($excel) use($users) {
            $excel->sheet('Contractors', function($sheet) use($users) {
                $sheet->fromArray($users);
            });
        })->export('xls');
    }

    public function exportContractor() {
        // Export Operator's
        $id = Input::get("contractor_id");
        $name = Input::get("contractor_name");

        if ($id != "") {

            $date = date("d-F-Y-H-i-s");

            $users = Messages::select('id', 'name', 'email', 'email_alt', 'phone', 'phone_alt', 'area', 'message', 'type', 'operator_name', 'created_at', 'updated_at')->where('contractor_id', $id)->get();
            Excel::create('Contractor_' . $id . '_' . $date, function ($excel) use ($users) {
                $excel->sheet('Contractors', function ($sheet) use ($users) {
                    $sheet->fromArray($users);
                });
            })->export('xls');
        } else if ($name != "") {
            $date = date("d-F-Y-H-i-s");

            $users = Messages::select('id', 'name', 'email', 'email_alt', 'phone', 'phone_alt', 'area', 'message', 'type', 'operator_name', 'created_at', 'updated_at')->where('contractor_name', $name)->get();
            Excel::create('Contractor_' . $name . '_' . $date, function ($excel) use ($users) {
                $excel->sheet('Contractors', function ($sheet) use ($users) {
                    $sheet->fromArray($users);
                });
            })->export('xls');
        } else {
            // Error Return
        }
    }

    public function mysql() {
        $date = date("d-F-Y-H-i-s");

        $users = User::all();
        $areas = Areas::all();
        $bulkSMS = BulkSMS::all();
        $category = Category::all();
        $industry = Industry::all();
        $messages = Messages::all();
        $premessages = PreMessage::all();
        $settings = Settings::all();
        Excel::create('Full_Backup_SMS_Portal_'.$date, function($excel) use($users, $areas, $bulkSMS, $category, $industry, $messages, $premessages, $settings) {
            $excel->sheet('Users', function($sheet) use($users) {
                $sheet->fromArray($users);
            });
            $excel->sheet('Areas', function($sheet) use($areas) {
                $sheet->fromArray($areas);
            });
            $excel->sheet('BulkSMS', function($sheet) use($bulkSMS) {
                $sheet->fromArray($bulkSMS);
            });
            $excel->sheet('Category', function($sheet) use($category) {
                $sheet->fromArray($category);
            });
            $excel->sheet('Industry', function($sheet) use($industry) {
                $sheet->fromArray($industry);
            });
            $excel->sheet('Messages-Leads', function($sheet) use($messages) {
                $sheet->fromArray($messages);
            });
            $excel->sheet('Pre-Messages', function($sheet) use($premessages) {
                $sheet->fromArray($premessages);
            });
            $excel->sheet('Settings', function($sheet) use($settings) {
                $sheet->fromArray($settings);
            });
        })->export('xls');
    }
}
