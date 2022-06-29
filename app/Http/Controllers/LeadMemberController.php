<?php

namespace App\Http\Controllers;

use App\Messages;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\SMSApiController;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LeadMemberController extends Controller
{
    //

   public function save($type, $data) {
        $message = new Messages();
        $message->name = $data["name"];
        $message->email = $data["email"];
        $message->email_alt = $data["email_alt"];
        $message->phone = $data["phone"];
        $message->phone_alt = $data["phone_alt"];
        $message->area = $data["area"];
        $message->industry = $data["industry"];
        $message->message = $data["message"];
        $message->numberOfLeads = $data["numberofleads"];
        $message->status = "review";
        $message->type = $type;
        $message->operator_id = $data["operator_id"];
        $message->operator_name = $data["operator_name"];
        $message->contractor_id = $data["contractor_id"];
        $message->contractor_name = $data["contractor_name"];
        $message->save();

        return true;
    }

    public function update($type, $data, $id) {
        $message = Messages::find($id);
        $message->name = $data["name"];
        $message->email = $data["email"];
        $message->email_alt = $data["email_alt"];
        $message->phone = $data["phone"];
        $message->phone_alt = $data["phone_alt"];
        $message->area = $data["area"];
        $message->industry = $data["industry"];
        $message->message = $data["message"];
        $message->numberOfLeads = $data["numberofleads"];
        $message->status = $data["status"];
        $message->type = $type;
        $message->operator_id = $data["operator_id"];
        $message->operator_name = $data["operator_name"];
        $message->contractor_id = $data["contractor_id"];
        $message->contractor_name = $data["contractor_name"];
        $message->save();

        return $message->id;
    }

    public function sentSMS($phoneNumbers, $messages)
    {
        $sms = new SMSApiController();
        $smsTwilio = new Client("ACb955205eb53be8a629175462a7c4f700", "7b5760ea96afaa57ced8d95a832aa386");

        foreach($phoneNumbers as $number) {
            if ($sms->sendSms($number, $messages[0]) == TRUE) {
            } else {
                $smsTwilio->messages->create($number, array("from" => "+12564149005", "body" => $messages[1]));
            }
        }

        return true;

    }

    public function sendEmails($type, $emails, $emailData, $numberofleads)
    {
        if ($type == "call") {
            $view = View::make("email.index")->with('data', $emailData);
        } else {
            $view = View::make("email.copyemail")->with('data', $emailData);
        }

            $headers = "From: Mega Leads <no-replay@megaleads.co.za>\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $subject = "Mega Leads - Number of leads: " . $numberofleads;

            foreach ($emails as $email) {
                mail($email, $subject, $view, $headers);
            }

            return true;
    }
}
