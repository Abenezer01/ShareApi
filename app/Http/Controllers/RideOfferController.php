<?php

namespace App\Http\Controllers;

use App\RideOffer;
use App\RideStatus;
use App\status;
use App\Vehicle;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Auth;
class RideOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->updaeRideSatus();
        $rideOffers=RideOffer::with('passengers')->with('status')->whereHas('status', function ($query){
            $query->where('name', '=','New');
          })->get();
        return response()->json($rideOffers, 200);
    }
    public function updaeRideSatus(){
        $rideStatusExpired=RideStatus::where('name','Expired')->first()['id'];
        $rideOffers=RideOffer::with('passengers')->with('status')->whereHas('status', function ($query){
            $query->where('name', '=','New');
          })->get();
          foreach ($rideOffers as $ride) {
           if($ride->isExpired==true){
                $ride->update(['rideStatusId'=>$rideStatusExpired]);
           }
       }
   }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $request['date'] = Carbon::parse($request['date'])->format('Y-m-d H:i:s');
        $request['time'] = Carbon::parse($request['time'])->format('H:i:s');
        $validation = Validator::make($request->all(),[
            'pickup' => 'required',
            'destination' => 'required',
            'no_of_seats' => 'required|numeric',
            'userId' => 'required',
            'date'=>'required|date',
            'time'=>'required',
            'price'=>'required',
            'originLong'=>'required',
            'originLat'=>'required',
            'destinationLong'=>'required',
            'destinationLat'=>'required'
          ]);

          if($validation->fails()){
              return response()->json($validation->errors()->toJson(), 501);
          }else{

          }


          try {
            $vehicles=Vehicle::where('userId',$request['userId']);
            try {
                $vehicle=$vehicles->where('isActive',true)->first();
            } catch (\Throwable $th) {
                $vehicle=$vehicle->first();
                $vehicle->isActive=true;
            }
            $request['vehicleId']=$vehicle['id'];
          } catch (\Throwable $th) {
              return response()->json(['message'=>"please Add a vehilce "], 500);

          }
          $request['id']=uniqid('Ride_Offer-');
          request()->merge(['rideStatusId' => RideStatus::where('name','New')->first()->id]);
          $data=RideOffer::create($request->all());
          return response()->json($data, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RideOffer  $rideOffer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rideOffers=RideOffer::where('id',$id)->with('vehicle')->with('passengers')->with('bookRide')->first();
        return response()->json($rideOffers, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RideOffer  $rideOffer
     * @return \Illuminate\Http\Response
     */
    public function edit(RideOffer $rideOffer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RideOffer  $rideOffer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RideOffer $rideOffer)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RideOffer  $rideOffer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Auth::user()->rideOffer()->where('id',$id)->delete();
    }
    public function changeStatus(Request $request,$id){
        $rideStatus=RideStatus::where('name',$request->name)->first();
        $rideOffer=Auth::user()->rideOffer()->where('id',$id)->update(['rideStatusId'=>$rideStatus->id]);
        return response()->json($rideOffer, 200);
    }
    public function getRideOfferHistory($userId)
    {
        try {
            $rideHistory = RideOffer::where('userId', $userId)->get();
        } catch (\Throwable $th) {
            return response()->json(["Message" => "user don't have ride history"], 200);
        }
        return response()->json($rideHistory, 200);
    }
}
