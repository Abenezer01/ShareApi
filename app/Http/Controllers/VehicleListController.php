<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VehicleListController extends Controller
{
    public function getVehicleData(){
        $json = json_decode(file_get_contents(config('global.baseUrl1').'VehicleList', true));
        return response()->json($json, 200);
    }
}
