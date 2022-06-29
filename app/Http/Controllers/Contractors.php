<?php

namespace App\Http\Controllers;

use App\Contractor;
use App\Industry;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class Contractors extends Controller
{
    //

    public function index() {

        if (Auth::check()) {

            $contractor = Contractor::all();

            return View::make('contractors.index')->with('contractor', $contractor);
        } else {
            return redirect("login");
        }

    }

    public function create() {
        if (Auth::check()) {
            // Get Areas json data
            $areas = new AreasController();
            $industry = new IndustryController();

            // Get and compile the industry data

            $areaData = $areas->returnAreasJSON();
            $industries = $industry->GetIndustriesJSON();

            //echo $areaData;

            $data = array(
                'areasJSON' => $areaData,
                'industry' => $industries
            );

            return View::make('contractors.create')->with($data);

        } else {
            return redirect("login");
        }
    }

    public function store() {
        if (Auth::check()) {
            $rules = array(
                'contractor_name' => 'required',
                'contractor_email' => 'required',
                'contractor_phone' => 'required',
                'contractor_area' => 'required',
                'contractor_overall_area' => 'required',
                'contractor_industries' => 'required',
                'contractor_leads' => 'required'
            );

            // Validate
            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                // If the validation fails then deal with it.
                Session::flash('alert-danger', 'An Error Occured.');
                return Redirect::to('contractors/create')->withErrors($validator)->withInput(Input::except('password'));
            } else {
                // Get inputs

                $overallArea = Input::get("contractor_overall_area");

                $contractor = new Contractor();
                $contractor->name = Input::get("contractor_name");
                $contractor->emails = rtrim(implode(",", Input::get("contractor_email")), ",");
                $contractor->phones = rtrim(implode(",", Input::get("contractor_phone")), ",");
                $contractor->area = Input::get("contractor_area");
                $contractor->overallArea = $overallArea;
                $contractor->industry = implode(",", Input::get("contractor_industries"));
                $contractor->leads_remaining = Input::get("contractor_leads");
                $contractor->leads_status = Input::get("contractor_lead_status");
                $carbon = Carbon::now();
                $contractor->last_lead = $carbon->yesterday();
                $contractor->save();

                // redirect
                Session::flash('alert-success', 'Successfully created Contractor');
                return Redirect::to('contractors');

            }
        } else {
            return redirect("login");
        }
    }

    public function edit($id) {
        if (Auth::check()) {
            // Get Areas json data
            $areas = new AreasController();
            $industry = new IndustryController();

            // Get and compile the industry data

            $areaData = $areas->returnAreasJSON();
            $industries = $industry->GetIndustriesJSON();
            $contractor = Contractor::find($id);

            //echo $areaData;

            $data = array(
                'areasJSON' => $areaData,
                'industry' => $industries,
                'contractor' => $contractor
            );

            return View::make('contractors.edit')->with($data);
        } else {
            return redirect("login");
        }
    }

    public function update($id) {
        if (Auth::check()) {
            $rules = array(
                'contractor_name' => 'required',
                'contractor_email' => 'required',
                'contractor_phone' => 'required',
                'contractor_area' => 'required',
                'contractor_overall_area' => 'required',
                'contractor_industries' => 'required',
                'contractor_leads' => 'required'
            );

            // Validate
            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                // If the validation fails then deal with it.
                Session::flash('alert-danger', 'An Error Occured.');
                return Redirect::to('contractors/' . $id . '/edit')->withErrors($validator)->withInput(Input::except('password'));
            } else {
                // Get inputs

                $contractor = Contractor::find($id);
                $contractor->name = Input::get("contractor_name");
                $contractor->emails = rtrim(implode(",", Input::get("contractor_email")), ",");
                $contractor->phones = rtrim(implode(",", Input::get("contractor_phone")), ",");
                $contractor->area = Input::get("contractor_area");
                $contractor->overallArea = Input::get("contractor_overall_area");
                $contractor->industry = implode(",", Input::get("contractor_industries"));
                $contractor->leads_remaining = Input::get("contractor_leads");
                $contractor->leads_status = Input::get("contractor_lead_status");
                $contractor->save();

                // redirect
                Session::flash('alert-success', 'Successfully updated Contractor');
                return Redirect::to('contractors');

            }
        } else {
            return redirect("login");
        }
    }

    public function search($string, $column) {

        if (Auth::check()) {

            $contractors = DB::select("SELECT id, name, leads_remaining, overallArea, industry, last_lead FROM contractor WHERE ".$column." LIKE '%" . $string . "%'");

            $count = count($contractors);
            //echo $count;

            if ($count > 0) {
                $result = "";
                foreach ($contractors as $item) {

                    $areas = explode("/", $item->overallArea);
                    $leadToday = $this->getTimeStampDay(Carbon::parse($item->last_lead));
                    $resultAreas = "";
                    foreach($areas as $area) {
                        $resultAreas .= "<p>".rtrim($area, "/")."</p>";
                    }

                    $industries = explode(",", $item->industry);
                    $resultIndustries = "";
                    foreach($industries as $value) {
                        $resultIndustries .= "<p>".rtrim($value, ",")."</p>";
                    }

                    $result .= '<tr data-toggle="collapse" data-target="#demo'.$item->id.'" class="accordion-toggle">
<td><input type="radio" name="contractor_id" value="' . $item->id . '" /></td>
<td>' . $item->id . '.</td>
<td>' . $item->name . '</td>
<td>'.$leadToday.'</td>
<td>'.$item->leads_remaining.'</td>
<td><button type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
</tr>
<tr>
    <td colspan="12" class="hiddenRow"><div class="accordian-body collapse" id="demo'.$item->id.'">
        <table class="table table-striped">
            <thead>
                <th>Areas</th>
                <th>Industries</th>
            </thead>
                <td>'.$resultAreas.'</td>
                <td>'.$resultIndustries.'</td>
            <tbody>
            </tbody>
        </table>
    </td>
</tr>';
                }

                $responseArray = array(
                    "success" => true,
                    "data" => $result,
                );
                return json_encode($responseArray);
            } else {
                $responseArray = array(
                    "success" => false,
                    "errorMessage" => "No contractors found",
                );
                return json_encode($responseArray);
            }

            return json_encode($responseArray);

            //print_r($contractors);
        } else {
            return redirect("login");
        }

    }

    public function delete($id) {
        if (Auth::check()) {
            $contractor = Contractor::find($id);
            $contractor->delete();

            // redirect
            Session::flash('alert-success', 'Successfully deleted Contractor');
            return Redirect::to('contractors');
        } else {
            return redirect("login");
        }
    }

    public function getTimeStampDay($timestamp) {
        $dt = Carbon::now();
        $diff = $dt->diffInDays($timestamp);

        if ($diff == 0) {
            return '<span class="glyphicon glyphicon-ok" style="color:green;" aria-hidden="true"></span>';
        } else {
            return '<span class="glyphicon glyphicon-remove" style="color:red;" aria-hidden="true"></span>';
        }
    }
}
