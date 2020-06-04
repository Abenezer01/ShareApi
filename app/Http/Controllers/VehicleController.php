<?php

namespace App\Http\Controllers;

use App\Vehicle;
use Illuminate\Http\Request;
use Validator;
use App\EndUser;
use Facade\FlareClient\Http\Response;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return Vehicle::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $validation = Validator::make($request->all(),[
        'brand' => 'required',
        'model' => 'required',
        'year' => 'required',
        'userId' => 'required',
        'plateNo' => 'required|unique:vehicles,plateNo'
      ]);

      if($validation->fails()){
        return $validation->errors()->toJson();
      }
      $request['id']=uniqid('Vehicle-');
      $vehicles=Vehicle::where('userId',$request['userId'])->get();
      if($vehicles->count()==0){
        $request['isActive']=true;
      }else{
        $request['isActive']=false;
      }
      $data=Vehicle::create($request->all());
      return response()->json(['message'=>'vehicle created successfully'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show($userId)
    {
        $vehicles=EndUser::find($userId)->vehicles;
        return response()->json($vehicles, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        //p
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $vehicle=Vehicle::find($id);
        $vehicle->user->vehicles()->update(['isActive'=>false]);
        $vehicle->isActive=true;

        $vehicle->save();
        return response()->json($vehicle->user->vehicles()->get(), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        //
    }
}
