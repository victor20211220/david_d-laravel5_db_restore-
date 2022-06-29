<?php

namespace App\Http\Controllers;

use App\Contractor;
use App\Http\Requests;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		/*
		 *  // add user
		$user = User::create(['name'=>'admin', 'email' => 'admin@gmail.com', 'password' => bcrypt("a")]);
		dd($user);
		*/
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::check()) {

            // Get Areas json data
            $areas = new AreasController();
            $industry = new IndustryController();
            $premessage = new preMessageController();

            // Get and compile the industry data

            $areaData = $areas->returnAreasJSON();
            $industries = $industry->GetIndustriesJSON();
            $messahe = $premessage->getPreMessagesJSON();

            //echo $areaData;

            $data = array(
                'areasJSON' => $areaData,
                'industry' => $industries,
                'premessage' => $messahe
            );

            return \View::make('home')->with($data);
        } else {
            return redirect("login");
        }
    }

    public function findContractors($industry, $location) {

        if (Auth::check()) {

            $contractors = DB::select("SELECT id, name, leads_remaining, overallArea, industry, last_lead FROM contractor WHERE area LIKE '%" . $location . "%' AND industry LIKE '%" . $industry . "%' AND leads_status = '0'");

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
<td><button class="btn btn-default btn-xs" type="button"><span class="glyphicon glyphicon-eye-open"></span></button></td>
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
                    "errorMessage" => "No contractors for: " . $industry,
                );
                return json_encode($responseArray);
            }

            return json_encode($responseArray);

            //print_r($contractors);
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

    public function findLeadsYesterday() {
        $contractors = DB::select("SELECT id, name, updated_at FROM contractor WHERE area LIKE '%Gauteng,Johannesburg West,Roodepoort,Wilro Park%' AND industry LIKE '%Building%' AND leads_status = '0'");
        foreach($contractors as $item) {
            echo $this->get_day_name($item->updated_at);
        }
        print_r($contractors);
    }

    public function areasFetch() {
        $areas = new AreasController();
        $result = $areas->returnAreasJSON();
        return $result;
    }
}
