<?php

namespace App\Http\Controllers;

use App\Contractor;
use App\Messages;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\View;

class LeadController extends Controller
{
    //
    public function store() {

        $leadManager = new LeadMemberController();

        // Check if is admin or operator
        if (Auth::check()) {
            // Check admin or operator
            $leadType = Input::get("lead_type");

            if (Auth::user()->user_role == "admin") {
                // If it is a free lead or not
                $settings = new Settingscontroller();
                $disclosure = $settings->getDisclosure();
                $freeLeads = Input::get("free_lead");
                if ($freeLeads == true) {
                    // Is a free lead
                    if ($leadType == 0) {
                        // lead type - Call Lead

                        $rules = array(
                            'lead_name' => 'required',
                            'lead_phone' => 'required',
                            'lead_message' => 'required',
                            'lead_area' => 'required',
                            'lead_industry' => 'required',
                            'contractor_id' => 'required',
                        );

                        $validator = Validator::make(Input::all(), $rules);

                        if ($validator->fails()) {
                            // If the validation fails then deal with it.
                            Session::flash('alert-danger', 'An Error Occured.');
                            return Redirect::to('/')->withErrors($validator)->withInput(Input::except('lead_message'));
                        } else {
                            $name = Input::get("lead_name");
                            $email = Input::get("lead_email");
                            $email_alt = Input::get("lead_email_alt");
                            $phone = Input::get("lead_phone");
                            $phone_alt = Input::get("lead_phone_alt");
                            $messageBody = Input::get("lead_message");
                            $area = Input::get("lead_area");
                            $industry = Input::get("lead_industry");
                            $contractorID = Input::get("contractor_id");

                            $contractor = Contractor::limit(1)->where('id', $contractorID)->get()->toArray();

                            $numberofleads = $contractor[0]["leads_remaining"] - 1;
                            $contractorUpdate = Contractor::find($contractorID);
                            $contractorUpdate->leads_remaining = $numberofleads;
                            $contractorUpdate->last_lead = Carbon::now();
                            $contractorUpdate->save();

                            $phones = explode(',', $contractor[0]["phones"]);
                            $emails = explode(',', $contractor[0]["emails"]);

                            $sendData = array(
                                "name" => $name,
                                "email" => $email,
                                "email_alt" => $email_alt,
                                "phone" => $phone,
                                "phone_alt" => $phone_alt,
                                "area" => $area,
                                "industry" => $industry,
                                "message" => $messageBody,
                                "numberofleads" => $numberofleads,
                                "status" => "sent",
                                "operator_id" => Auth::user()->id,
                                "operator_name" => Auth::user()->name,
                                "contractor_id" => $contractor[0]["id"],
                                "contractor_name" => $contractor[0]["name"]
                            );

                            $message = $leadManager->save("call", $sendData);
                            // redirect
                            Session::flash('alert-success', 'Successfully added lead to system');
                            return Redirect::to('/');

                        }
                    } else {
                        // lead type - Paste Lead
                        // Call Center Lead

                        $rules = array(
                            'lead_message_type' => 'required',
                            'lead_area' => 'required',
                            'lead_industry' => 'required',
                            'contractor_id' => 'required',
                        );

                        $validator = Validator::make(Input::all(), $rules);

                        if ($validator->fails()) {
                            // If the validation fails then deal with it.
                            Session::flash('alert-danger', 'An Error Occured.');
                            return Redirect::to('/')->withErrors($validator)->withInput(Input::except('lead_message'));
                        } else {

                            $messageBody = Input::get("lead_message_type");
                            $area = Input::get("lead_area");
                            $industry = Input::get("lead_industry");
                            $contractorID = Input::get("contractor_id");

                            $contractor2 = Contractor::limit(1)->where('id', $contractorID)->get()->toArray();

                            $phones = explode(',', $contractor2[0]["phones"]);
                            $emails = explode(',', $contractor2[0]["emails"]);

                            $numberofleads = $contractor2[0]["leads_remaining"] - 1;
                            $contractorUpdate = Contractor::find($contractorID);
                            $contractorUpdate->leads_remaining = $numberofleads;
                            $contractorUpdate->last_lead = Carbon::now();
                            $contractorUpdate->save();

                            $sendData = array(
                                "name" => "",
                                "email" => "",
                                "email_alt" => "",
                                "phone" => "",
                                "phone_alt" => "",
                                "area" => $area,
                                "industry" => $industry,
                                "message" => $messageBody,
                                "numberofleads" => $numberofleads,
                                "status" => "sent",
                                "operator_id" => Auth::user()->id,
                                "operator_name" => Auth::user()->name,
                                "contractor_id" => $contractorUpdate[0]["id"],
                                "contractor_name" => $contractorUpdate[0]["name"]
                            );

                            // redirect
                            Session::flash('alert-success', 'Successfully sent lead');
                            return Redirect::to('/');
                        }
                    }
                } else {
                    // -- free lead else
                    if ($leadType == 0) {
                        // lead type - Call Lead
                        $rules = array(
                            'lead_name' => 'required',
                            'lead_phone' => 'required',
                            'lead_message' => 'required',
                            'lead_area' => 'required',
                            'lead_industry' => 'required',
                            'contractor_id' => 'required',
                        );

                        $validator = Validator::make(Input::all(), $rules);

                        if ($validator->fails()) {
                            // If the validation fails then deal with it.
                            Session::flash('alert-danger', 'An Error Occured.');
                            return Redirect::to('/')->withErrors($validator)->withInput(Input::except('lead_message'));
                        } else {
                            $name = Input::get("lead_name");
                            $email = Input::get("lead_email");
                            $email_alt = Input::get("lead_email_alt");
                            $phone = Input::get("lead_phone");
                            $phone_alt = Input::get("lead_phone_alt");
                            $messageBody = Input::get("lead_message");
                            $area = Input::get("lead_area");
                            $industry = Input::get("lead_industry");
                            $contractorID = Input::get("contractor_id");

                            $contractor = Contractor::limit(1)->where('id', $contractorID)->get()->toArray();

                            $numberofleads = $contractor[0]["leads_remaining"] - 1;
                            $contractorUpdate = Contractor::find($contractorID);
                            $contractorUpdate->leads_remaining = $numberofleads;
                            $contractorUpdate->last_lead = Carbon::now();
                            $contractorUpdate->save();

                            $phones = explode(',', $contractor[0]["phones"]);
                            $emails = explode(',', $contractor[0]["emails"]);

                            $sendData = array(
                                "name" => $name,
                                "email" => $email,
                                "email_alt" => $email_alt,
                                "phone" => $phone,
                                "phone_alt" => $phone_alt,
                                "area" => $area,
                                "industry" => $industry,
                                "message" => $messageBody,
                                "numberofleads" => $numberofleads,
                                "status" => "sent",
                                "operator_id" => Auth::user()->id,
                                "operator_name" => Auth::user()->name,
                                "contractor_id" => $contractor[0]["id"],
                                "contractor_name" => $contractor[0]["name"]
                            );

                            $message = $leadManager->save("call", $sendData);

                            $messageID = $message;

                            // Sending SMS's
                            $smsBody = date("d F Y H:i:s") . "||" . $name . ",|Email:" . $email . "|Alt Email:" . $email_alt . "|Phone:" . $phone . "|Alt Phone:" . $phone_alt . "|Area:" . $area . "|Industry:" . $industry . "|Message:|" . $messageBody . "|Leads Remaining:" . $numberofleads . "|Ref: #" . $messageID . "||" . $disclosure . "||Do not reply to this SMS.||Kind Regards,|The Mega Leads team|For all Queries contact Rita: 062 472 0770|rita@megaleads.co.za";
                            $smsBodyTwilio = date("d F Y H:i:s") . "\n\n" . $name . ",\nEmail:" . $email . "\nAlt Email:" . $email_alt . "\nPhone:" . $phone . "\nAlt Phone:" . $phone_alt . "\nArea:" . $area . "\nIndustry:" . $industry . "\nMessage:\n" . $messageBody . "\nLeads Reaming:" . $numberofleads . "\nRef: #" . $messageID . "\n\n" . $disclosure . "\n\nDo not reply to this SMS.||Kind Regards,\nThe Mega Leads team\nFor all Queries contact Rita: 062 472 0770\nrita@megaleads.co.za";

                            $messages = array(
                                $smsBody,
                                $smsBodyTwilio
                            );

                            $leadManager->sentSMS($phones, $messages);

                            // Send Emails
                            $emailData = array(
                                "date" => date("d F Y H:i:s"),
                                "name" => $name,
                                "email" => $email,
                                "email_alt" => $email_alt,
                                "phone" => $phone,
                                "phone_alt" => $phone_alt,
                                "area" => $area,
                                "message" => $messageBody,
                                "category" => $industry,
                                "leads" => $numberofleads,
                            );

                            $leadManager->sendEmails("call", $emails, $emailData, $numberofleads);

                            Session::flash('alert-success', 'Successfully added lead to system');
                            return Redirect::to('/');
                        }
                    } else {
                        // lead type - Paste Lead
                        $rules = array(
                            'lead_message_type' => 'required',
                            'lead_area' => 'required',
                            'lead_industry' => 'required',
                            'contractor_id' => 'required',
                        );

                        $validator = Validator::make(Input::all(), $rules);

                        if ($validator->fails()) {
                            // If the validation fails then deal with it.
                            Session::flash('alert-danger', 'An Error Occured.');
                            return Redirect::to('/')->withErrors($validator)->withInput(Input::except('lead_message'));
                        } else {

                            $messageBody = Input::get("lead_message_type");
                            $area = Input::get("lead_area");
                            $industry = Input::get("lead_industry");
                            $contractorID = Input::get("contractor_id");

                            $contractor2 = Contractor::limit(1)->where('id', $contractorID)->get()->toArray();

                            $phones = explode(',', $contractor2[0]["phones"]);
                            $emails = explode(',', $contractor2[0]["emails"]);

                            $numberofleads = $contractor2[0]["leads_remaining"] - 1;
                            $contractorUpdate = Contractor::find($contractorID);
                            $contractorUpdate->leads_remaining = $numberofleads;
                            $contractorUpdate->last_lead = Carbon::now();
                            $contractorUpdate->save();

                            $sendData = array(
                                "name" => "",
                                "email" => "",
                                "email_alt" => "",
                                "phone" => "",
                                "phone_alt" => "",
                                "area" => $area,
                                "industry" => $industry,
                                "message" => $messageBody,
                                "numberofleads" => $numberofleads,
                                "status" => "sent",
                                "operator_id" => Auth::user()->id,
                                "operator_name" => Auth::user()->name,
                                "contractor_id" => $contractorUpdate[0]["id"],
                                "contractor_name" => $contractorUpdate[0]["name"]
                            );

                            $message = $leadManager->save("copy", $sendData);
                            $messageID = $message;

                            $smsBody1 = date("d F Y H:i:s") . "||" . str_replace("**", "|", $messageBody) . "|Area:" . $area . "|Industry:" . $industry . "|Leads Remaining:" . $numberofleads . "|Ref: #" . $messageID . "||" . $disclosure . "||Do not reply to this SMS.||Kind Regards,|The Mega Leads team|For all Queries contact Rita: 062 472 0770|rita@megaleads.co.za";
                            $smsBodyTwilio1 = date("d F Y H:i:s") . "\n\n" . str_replace("**", "\n", $messageBody) . "\nArea:" . $area . "\nIndustry:" . $industry . "\nLeads Remaining:" . $numberofleads . "\nRef: #" . $messageID . "\n\n" . $disclosure . "\n\nDo not reply to this SMS.\n\nKind Regards,\nThe Mega Leads team\nFor all Queries contact Rita: 062 472 0770\nrita@megaleads.co.za";

                            $messages1 = array(
                                $smsBody1,
                                $smsBodyTwilio1
                            );

                            // Send sms's
                            $leadManager->sentSMS($phones, $messages1);

                            $emailMessageBody = str_replace("**", " ", $messageBody);

                            $emailData2 = array(
                                "date" => date("d F Y H:i:s"),
                                "area" => $area,
                                "message" => $emailMessageBody,
                                "category" => $industry,
                                "leads" => $numberofleads,
                            );

                            $leadManager->sendEmails("copy", $emails, $emailData2, $numberofleads);

                            // redirect
                            Session::flash('alert-success', 'Successfully added lead to system');
                            return Redirect::to('/');
                        }
                    }
                }
            } else {
                // User role else - operator
                if ($leadType == 0) {
                    // lead type - Call Lead
                    $rules = array(
                        'lead_name' => 'required',
                        'lead_email' => 'required',
                        'lead_phone' => 'required',
                        'lead_message' => 'required',
                        'lead_area' => 'required',
                        'lead_industry' => 'required',
                    );

                    $validator = Validator::make(Input::all(), $rules);

                    if ($validator->fails()) {
                        // If the validation fails then deal with it.
                        Session::flash('alert-danger', 'An Error Occured.');
                        return Redirect::to('/')->withErrors($validator)->withInput();
                    } else {

                        $leadType = Input::get("lead_type");
                        $name = Input::get("lead_name");
                        $email = Input::get("lead_email");
                        $email_alt = Input::get("lead_email_alt");
                        $phone = Input::get("lead_phone");
                        $phone_alt = Input::get("lead_phone_alt");
                        $messageBody = Input::get("lead_message");
                        $area = Input::get("lead_area");
                        $industry = Input::get("lead_industry");

                        $sendData = array(
                            "name" => $name,
                            "email" => $email,
                            "email_alt" => $email_alt,
                            "phone" => $phone,
                            "phone_alt" => $phone_alt,
                            "area" => $area,
                            "industry" => $industry,
                            "message" => $messageBody,
                            "numberofleads" => "",
                            "status" => "review",
                            "operator_id" => Auth::user()->id,
                            "operator_name" => Auth::user()->name,
                            "contractor_id" => "",
                            "contractor_name" => ""
                        );

                        $leadManager->save("call", $sendData);

                        // redirect
                        Session::flash('alert-success', 'Successfully added lead to system');
                        return Redirect::to('/');
                    }


                } else {
                    // lead type - Paste Lead
                    $rules = array(
                        'lead_message_type' => 'required',
                        'lead_area' => 'required',
                        'lead_industry' => 'required',
                        'contractor_id' => 'required',
                    );

                    $validator = Validator::make(Input::all(), $rules);

                    if ($validator->fails()) {
                        // If the validation fails then deal with it.
                        Session::flash('alert-danger', 'An Error Occured.');
                        return Redirect::to('/')->withErrors($validator)->withInput(Input::except('lead_message'));
                    } else {

                        $messageBody = Input::get("lead_message_type");
                        $area = Input::get("lead_area");
                        $industry = Input::get("lead_industry");
                        $contractorID = Input::get("contractor_id");

                        $contractor2 = Contractor::limit(1)->where('id', $contractorID)->get()->toArray();

                        $phones = explode(',', $contractor2[0]["phones"]);
                        $emails = explode(',', $contractor2[0]["emails"]);

                        $numberofleads = $contractor2[0]["leads_remaining"] - 1;
                        $contractorUpdate = Contractor::find($contractorID);
                        $contractorUpdate->leads_remaining = $numberofleads;
                        $contractorUpdate->last_lead = Carbon::now();
                        $contractorUpdate->save();

                        $sendData = array(
                            "name" => "",
                            "email" => "",
                            "email_alt" => "",
                            "phone" => "",
                            "phone_alt" => "",
                            "area" => $area,
                            "industry" => $industry,
                            "message" => $messageBody,
                            "numberofleads" => $numberofleads,
                            "status" => "sent",
                            "operator_id" => Auth::user()->id,
                            "operator_name" => Auth::user()->name,
                            "contractor_id" => $contractorUpdate[0]["id"],
                            "contractor_name" => $contractorUpdate[0]["name"]
                        );

                        $message = $leadManager->save("copy", $sendData);
                        $messageID = $message;

                        $smsBody1 = date("d F Y H:i:s") . "||" . str_replace("**", "|", $messageBody) . "|Area:" . $area . "|Industry:" . $industry . "|Leads Remaining:" . $numberofleads . "|Ref: #" . $messageID . "||" . $disclosure . "||Do not reply to this SMS.||Kind Regards,|The Mega Leads team|For all Queries contact Rita: 062 472 0770|rita@megaleads.co.za";
                        $smsBodyTwilio1 = date("d F Y H:i:s") . "\n\n" . str_replace("**", "\n", $messageBody) . "\nArea:" . $area . "\nIndustry:" . $industry . "\nLeads Remaining:" . $numberofleads . "\nRef: #" . $messageID . "\n\n" . $disclosure . "\n\nDo not reply to this SMS.\n\nKind Regards,\nThe Mega Leads team\nFor all Queries contact Rita: 062 472 0770\nrita@megaleads.co.za";

                        $messages1 = array(
                            $smsBody1,
                            $smsBodyTwilio1
                        );

                        // Send sms's
                        $leadManager->sentSMS($phones, $messages1);

                        $emailMessageBody = str_replace("**", " ", $messageBody);

                        $emailData2 = array(
                            "date" => date("d F Y H:i:s"),
                            "area" => $area,
                            "message" => $emailMessageBody,
                            "category" => $industry,
                            "leads" => $numberofleads,
                        );

                        $leadManager->sendEmails("copy", $emails, $emailData2, $numberofleads);

                        // redirect
                        Session::flash('alert-success', 'Successfully added lead to system');
                        return Redirect::to('/');
                    }
                }
            }

        } else {
            return redirect('login');
        }





























    }

    public function review($id) {

        $leadManger = new LeadMemberController();

        if (Auth::check()) {

        $leadType = Input::get("lead_type");
        $sms = new SMSApiController();
        $smsTwilio = new Client("ACb955205eb53be8a629175462a7c4f700", "7b5760ea96afaa57ced8d95a832aa386");

        $settings = new Settingscontroller();
        $disclosure = $settings->getDisclosure();

        $free_lead = Input::get("free_lead");

        if ($free_lead == false) {
            if ($leadType == 0) {

                $rules = array(
                    'lead_type' => 'required',
                    'lead_name' => 'required',
                    'lead_phone' => 'required',
                    'lead_message' => 'required',
                    'lead_area' => 'required',
                    'lead_industry' => 'required',
                    'contractor_id' => 'required',
                );

                $validator = Validator::make(Input::all(), $rules);

                if ($validator->fails()) {
                    // If the validation fails then deal with it.
                    Session::flash('alert-danger', 'An Error Occured.');
                    return Redirect::to('/messages')->withErrors($validator)->withInput(Input::except('lead_message'));
                } else {

                    $leadType = Input::get("lead_type");
                    $name = Input::get("lead_name");
                    $email = Input::get("lead_email");
                    $email_alt = Input::get("lead_email_alt");
                    $phone = Input::get("lead_phone");
                    $phone_alt = Input::get("lead_phone_alt");
                    $messageBody = Input::get("lead_message");
                    $area = Input::get("lead_area");
                    $industry = Input::get("lead_industry");
                    $contractorID = Input::get("contractor_id");

                    $contractor = Contractor::limit(1)->where('id', $contractorID)->get()->toArray();

                    $phones = explode(',', $contractor[0]["phones"]);
                    $emails = explode(',', $contractor[0]["emails"]);

                    $numberofleads = $contractor[0]["leads_remaining"] - 1;
                    $contractorUpdate = Contractor::find($contractorID);
                    $contractorUpdate->leads_remaining = $numberofleads;
                    $contractorUpdate->last_lead = Carbon::now();
                    $contractorUpdate->save();

                    $sendData = array(
                        "name" => $name,
                        "email" => $email,
                        "email_alt" => $email_alt,
                        "phone" => $phone,
                        "phone_alt" => $phone_alt,
                        "area" => $area,
                        "industry" => $industry,
                        "message" => $messageBody,
                        "numberofleads" => $numberofleads,
                        "status" => "sent",
                        "operator_id" => Auth::user()->id,
                        "operator_name" => Auth::user()->name,
                        "contractor_id" => $contractor[0]["id"],
                        "contractor_name" => $contractor[0]["name"]
                    );

                    $message = $leadManger->update("call", $sendData, $id);

                    $smsBody = date("d F Y H:i:s") . "||" . $name . ",|Email:" . $email . "|Alt Email:" . $email_alt . "|Phone:" . $phone . "|Alt Phone:" . $phone_alt . "|Area:" . $area . "|Industry:" . $industry . "|Message:|" . $messageBody . "|Leads Remaining:" . $numberofleads . "|Ref: #" . $id . "||" . $disclosure . "||Do not reply to this SMS.||Kind Regards,|The Mega Leads team|For all Queries contact Rita: 062 472 0770|rita@megaleads.co.za";
                    $smsBodyTwilio = date("d F Y H:i:s") . "\n\n" . $name . ",\nEmail:" . $email . "\nAlt Email:" . $email_alt . "\nPhone:" . $phone . "\nAlt Phone:" . $phone_alt . "\nArea:" . $area . "\nIndustry:" . $industry . "\nMessage:\n" . $messageBody . "\nLeads Remaining:" . $numberofleads . "\nRef: #" . $id . "\n\n" . $disclosure . "\n\nDo not reply to this SMS.\n\nKind Regards,\nThe Mega Leads team\nFor all Queries contact Rita: 062 472 0770\nrita@megaleads.co.za";

                    $smsBodys = array(
                        $smsBody,
                        $smsBodyTwilio
                    );

                    $leadManger->sentSMS($phones, $smsBodys);

                    $emailMessage = str_replace("|", " ", $messageBody);

                    $emailData = array(
                        "date" => date("d F Y H:i:s"),
                        "name" => $name,
                        "email" => $email,
                        "email_alt" => $email_alt,
                        "phone" => $phone,
                        "phone_alt" => $phone_alt,
                        "area" => $area,
                        "message" => $emailMessage,
                        "category" => $industry,
                        "leads" => $numberofleads,
                    );

                    $leadManger->sendEmails("call", $emails, $emailData, $numberofleads);

                    // redirect
                    Session::flash('alert-success', 'Successfully sent lead');
                    return Redirect::to('/messages');
                }
            } else {

                // Copy & Paste

                $rules = array(
                    'lead_message' => 'required',
                    'lead_area' => 'required',
                    'lead_industry' => 'required',
                    'contractor_id' => 'required',
                );

                $validator = Validator::make(Input::all(), $rules);

                if ($validator->fails()) {
                    // If the validation fails then deal with it.
                    Session::flash('alert-danger', 'An Error Occured.');
                    return Redirect::to('/messages')->withErrors($validator)->withInput(Input::except('lead_message'));
                } else {

                    $messageBody = Input::get("lead_message");
                    $area = Input::get("lead_area");
                    $industry = Input::get("lead_industry");
                    $contractorID = Input::get("contractor_id");

                    $contractor = Contractor::limit(1)->where('id', $contractorID)->get()->toArray();

                    $phones = explode(',', $contractor[0]["phones"]);
                    $emails = explode(',', $contractor[0]["emails"]);

                    $numberofleads = $contractor[0]["leads_remaining"] - 1;
                    $contractorUpdate = Contractor::find($contractorID);
                    $contractorUpdate->leads_remaining = $numberofleads;
                    $contractorUpdate->last_lead = Carbon::now();
                    $contractorUpdate->save();

                    $sendData = array(
                        "name" => "",
                        "email" => "",
                        "email_alt" => "",
                        "phone" => "",
                        "phone_alt" => "",
                        "area" => $area,
                        "industry" => $industry,
                        "message" => $messageBody,
                        "numberofleads" => $numberofleads,
                        "status" => "sent",
                        "operator_id" => Auth::user()->id,
                        "operator_name" => Auth::user()->name,
                        "contractor_id" => $contractor[0]["id"],
                        "contractor_name" => $contractor[0]["name"]
                    );

                    $leadManger->update("copy", $sendData, $id);

                    $smsBody1 = date("d F Y H:i:s") . "||" . str_replace("**", "|", $messageBody) . "|Area:" . $area . "|Industry:" . $industry . "|Leads Remaining:" . $numberofleads . "|Ref: #" . $id . "||" . $disclosure . "||Do not reply to this SMS.||Kind Regards,|The Mega Leads team|For all Queries contact Rita: 062 472 0770|rita@megaleads.co.za";
                    $smsBodyTwilio1 = date("d F Y H:i:s") . "\n\n" . str_replace("**", "\n", $messageBody) . "\nArea:" . $area . "\nIndustry:" . $industry . "\nLeads Remaining:" . $numberofleads . "\nRef: #" . $id . "\n\n" . $disclosure . "\n\nDo not reply to this SMS.\n\nKind Regards,\nThe Mega Leads team\nFor all Queries contact Rita: 062 472 0770\nrita@megaleads.co.za";

                    $smsBodys = array(
                        $smsBody1,
                        $smsBodyTwilio1
                    );

                    $leadManger->sentSMS($phones, $smsBodys);

                    $emailMessageBody = str_replace("**", " ", $messageBody);

                    $emailData2 = array(
                        "date" => date("d F Y H:i:s"),
                        "area" => $area,
                        "message" => $emailMessageBody,
                        "category" => $industry,
                        "leads" => Input::get("number_of_leads"),
                    );

                    $leadManger->sendEmails("copy", $emails, $emailData2, $numberofleads);

                    // redirect
                    Session::flash('alert-success', 'Successfully sent lead');
                    return Redirect::to('/messages');
                }
            }
        } else {



            if ($leadType == 0) {

                $rules = array(
                    'lead_type' => 'required',
                    'lead_name' => 'required',
                    'lead_phone' => 'required',
                    'lead_message' => 'required',
                    'lead_area' => 'required',
                    'lead_industry' => 'required',
                );

                $validator = Validator::make(Input::all(), $rules);

                if ($validator->fails()) {
                    // If the validation fails then deal with it.
                    Session::flash('alert-danger', 'An Error Occured.');
                    return Redirect::to('/messages')->withErrors($validator)->withInput(Input::except('lead_message'));
                } else {

                    $leadType = Input::get("lead_type");
                    $name = Input::get("lead_name");
                    $email = Input::get("lead_email");
                    $email_alt = Input::get("lead_email_alt");
                    $phone = Input::get("lead_phone");
                    $phone_alt = Input::get("lead_phone_alt");
                    $messageBody = Input::get("lead_message");
                    $area = Input::get("lead_area");
                    $industry = Input::get("lead_industry");

                    $sendData = array(
                        "name" => $name,
                        "email" => $email,
                        "email_alt" => $email_alt,
                        "phone" => $phone,
                        "phone_alt" => $phone_alt,
                        "area" => $area,
                        "industry" => $industry,
                        "message" => $messageBody,
                        "numberofleads" => "",
                        "status" => "free",
                        "operator_id" => Auth::user()->id,
                        "operator_name" => Auth::user()->name,
                        "contractor_id" => "",
                        "contractor_name" => ""
                    );

                    $message = $leadManger->update("call", $sendData, $id);

                    // redirect
                    Session::flash('alert-success', 'Successfully sent lead');
                    return Redirect::to('/messages');
                }
            } else {

                // Copy & Paste

                $rules = array(
                    'lead_message' => 'required',
                    'lead_area' => 'required',
                    'lead_industry' => 'required',
                );

                $validator = Validator::make(Input::all(), $rules);

                if ($validator->fails()) {
                    // If the validation fails then deal with it.
                    Session::flash('alert-danger', 'An Error Occured.');
                    return Redirect::to('/messages')->withErrors($validator)->withInput(Input::except('lead_message'));
                } else {

                    $messageBody = Input::get("lead_message");
                    $area = Input::get("lead_area");
                    $industry = Input::get("lead_industry");

                    $sendData = array(
                        "name" => "",
                        "email" => "",
                        "email_alt" => "",
                        "phone" => "",
                        "phone_alt" => "",
                        "area" => $area,
                        "industry" => $industry,
                        "message" => $messageBody,
                        "numberofleads" => "",
                        "status" => "free",
                        "operator_id" => Auth::user()->id,
                        "operator_name" => Auth::user()->name,
                        "contractor_id" => "",
                        "contractor_name" => ""
                    );

                    $leadManger->update("copy", $sendData, $id);

                    // redirect
                    Session::flash('alert-success', 'Successfully sent lead');
                    return Redirect::to('/messages');
                }
            }



        }

        } else {
            return redirect("login");
        }
    }
}
