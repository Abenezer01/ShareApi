<?php

namespace App\Http\Controllers;

use App\BookRide;
use App\RideOffer;
use Illuminate\Http\Request;
use Validator;
use Auth;

class BookRideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validation = Validator::make($request->all(), [
            'rideOfferId' => 'required',
            'rideConsumerId' => 'required',
            'totalPass' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors()->toJson(), 501);
        } else {
        }
        $request['id'] = uniqid('RB-');
        $rideOfferId=$request['rideOfferId'];

        unset($request['rideOfferId']);
        if(RideOffer::find($rideOfferId)->bookRide->count()+$request['totalPass']<=RideOffer::find($rideOfferId)->no_of_seats){
            $bookRide=RideOffer::find($rideOfferId)->bookRide()->create($request->all());
            return response()->json($bookRide, 200);
        }
        return response()->json(['errorMessage'=>'Requestd seats are not available'], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BookRide  $bookRide
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bookRide=BookRide::find($id)->load('rideOffer');
        return response()->json($bookRide, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BookRide  $bookRide
     * @return \Illuminate\Http\Response
     */
    public function edit(BookRide $bookRide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BookRide  $bookRide
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BookRide $bookRide)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BookRide  $bookRide
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookRide $bookRide)
    {
        //
    }
}
