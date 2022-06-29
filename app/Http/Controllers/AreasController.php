<?php

namespace App\Http\Controllers;

use App\Areas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

class AreasController extends Controller
{
    //

    public function returnAreasJSON() {
        // This will make a multi-dimensional JSON string of all the areas
        //echo "<pre>";
        $areas = Areas::all()->toArray(); // Get all the areas
		$result = [];
        foreach($areas as $row) {
            $province = $row["province"];
            $city = $row["city"];
            $area = $row["area"];
            $result[$province][$city][$area][] = $row['suburb'];
        }

        return json_encode($result);
    }
}
