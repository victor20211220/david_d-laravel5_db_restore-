<?php

namespace App\Http\Controllers;

use App\Messages;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Khill\Lavacharts\Lavacharts;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\IndustryController;

class StatsController extends Controller
{
    //

    public function index() {

        return View::make('stats');

    }

    public function search($from, $to) {

        $query = DB::select("SELECT industry, area, status FROM messages WHERE `updated_at` BETWEEN '$from' AND '$to'");
        //$query2 = DB::select("SELECT industry, province, COUNT(CASE WHEN Status ='free' THEN 1 ELSE NULL END) as free_count, COUNT(CASE WHEN Status !='free' THEN 1 ELSE NULL END) as other_count FROM messages WHERE DAY(updated_at) = DAY(CURDATE()) ".$locationMySQL." ".$industryMySQL." GROUP BY province");


        //echo json_encode($query);

        $result = array();

        foreach($query as $item) {
            if(empty($result[explode(",", $item->area)[0]][explode("+", $item->industry)[0]][explode("+", $item->industry)[1]])){
                $result[explode(",", $item->area)[0]][explode("+", $item->industry)[0]][explode("+", $item->industry)[1]] = array(
                    "sold" => 0,
                    "free" => 0
                );
            }
            switch($item->status){
                case('free'):
                    $result[explode(",", $item->area)[0]][explode("+", $item->industry)[0]][explode("+", $item->industry)[1]]['free']++;
                    break;
                case('sent' || 'review' || 'followup' || 'followedup'):
                    $result[explode(",", $item->area)[0]][explode("+", $item->industry)[0]][explode("+", $item->industry)[1]]['sold']++;
                    break;
            }
        }

        //echo $areaData;

        $data = array(
            "data" => $result,
        );

        $layout = View::make('stats.layout')->with($data);

        return $layout;

    }
}
