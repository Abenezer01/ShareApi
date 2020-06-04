<?php

namespace App\Http\Controllers;

use App\BookRide;
use App\RideOffer;
use App\RideStatus;
use Illuminate\Http\Request;

class RideHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($userId)
    {
        try {
            $rideStatusId=RideStatus::where('name','Completed')->first()['rideStatusId'];
            $rideBookHistory = BookRide::where('rideConsumerId', $userId)->with('rideOffer.status')->with('rideOffer.user')->whereHas('rideOffer', function ($query) use($rideStatusId) {
                $query->where('rideStatusId', '=', $rideStatusId);
            })->get();
            $rideOfferHistory= RideOffer::where('userId',$userId)->where('rideStatusId', '=', $rideStatusId)->get();
            $rideHistory=['rideBookHistory'=>$rideBookHistory,'rideOfferHistory'=>$rideOfferHistory];
        } catch (\Throwable $th) {
            return response()->json(["Message" => "user don't have ride history"], 200);
        }
        return response()->json($rideHistory, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
