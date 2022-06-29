<?php

namespace App\Http\Controllers;

use App\BulkSMS;
use App\Industry;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Settingscontroller;
use App\Http\Controllers\SMSApiController;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class BulkSMSController extends Controller
{
    //

    public function index() {
        if (Auth::check()) {
            // Get Areas json data
            $industry = new IndustryController();

            // Get and compile the industry data
            $industries = $industry->GetIndustriesJSON();

            //echo $areaData;

            $data = array(
                'industry' => $industries,
            );

            return View::make('bulksms.index')->with($data);
        } else {

        }
    }

    public function history() {
        $messages = BulkSMS::all();

        return View::make('bulksms.history')->with('message', $messages);
    }

    public function store() {

        $sms = new SMSApiController();
        $smsTwilio = new Client("ACb955205eb53be8a629175462a7c4f700", "7b5760ea96afaa57ced8d95a832aa386");

        if (Auth::check()) {
            $rules = array(
                'subject' => 'required',
                'message' => 'required',
                'industry' => 'required'
            );

            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                Session::flash('alert-danger', 'An Error Occured.');
                return Redirect::to('/bulk')->withErrors($validator)->withInput(Input::except('message'));
            } else {
                //$message = Input::get("message");
                $industry = Input::get("industry");
                $message = Input::get("message");
                $subject = Input::get("subject");

                // Get the contractors
                foreach ($industry as $industries) {
                    $contractors = DB::select("SELECT id, name, emails, phones FROM contractor WHERE industry LIKE '%" . $industries . "%'");
                    $settings = new Settingscontroller();
                    $disclosure = $settings->getDisclosure();

                    foreach ($contractors as $item) {
                        $emailsAddrsses = explode(",", $item->emails);
                        $phonesNumbers = explode(",", $item->phones);
                        $name = $item->name;

                        $smsBody = date("d F Y H:i:s") . "||" . $name . ",|Subject:" .$subject. "||" . str_replace("**", "|", $message) . "||" . $disclosure . "||Do not reply to this SMS.||Kind Regards,|The Mega Leads team|For all Queries contact Rita: 062 472 0770|rita@megaleads.co.za";
                        $smsBodyTwilio = date("d F Y H:i:s") . "\n\n" . $name . ",\nSubject:" .$subject. "\n\n" . str_replace("**", "\n", $message) . "\n\n" . $disclosure . "\n\nDo not reply to this SMS.||Kind Regards,\nThe Mega Leads team\nFor all Queries contact Rita: 062 472 0770\nrita@megaleads.co.za";

                        $emailData = array(
                            "date" => date("d F Y H:i:s"),
                            "message" => $message,
                        );

                        $view = View::make("email.bulk")->with('data', $emailData);
                        $headers = "From: Mega Leads <no-replay@megaleads.co.za>\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                        $subject = $subject;

                        foreach ($phonesNumbers as $phone) {
                            if ($sms->sendSms($phone, $smsBody) == TRUE) {
                            } else {
                                $smsTwilio->messages->create($phone, array("from" => "+12564149005", "body" => $smsBodyTwilio));
                            }
                        }

                        foreach ($emailsAddrsses as $email) {
                            mail($email, $subject, $view, $headers);
                        }


                    }
                }

                // Save
                $bulksms = new BulkSMS();
                $bulksms->subject = $subject;
                $bulksms->message = $message;
                $bulksms->industry = implode(",", $industry);
                $bulksms->save();

                // redirect
                Session::flash('alert-success', 'Successfully sent messages');
                return Redirect::to('/bulk');
            }

        } else {

        }
    }
}
