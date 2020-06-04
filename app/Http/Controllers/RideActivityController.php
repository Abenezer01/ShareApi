<?php

namespace App\Http\Controllers;
use App\BookRide;
use App\RideOffer;
use App\RideStatus;
use Illuminate\Http\Request;

class RideActivityController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updaeRideSatus($userId){
         $rideStatusExpired=RideStatus::where('name','Expired')->first()['id'];

         $rideOffer=RideOffer::where('userId',$userId);
        foreach ($rideOffer->get() as $ride) {
            if($ride->isExpired==true){
                 $ride->update(['rideStatusId'=>$rideStatusExpired]);
            }
        }
    }
    public function show($userId)
    {
        $this->updaeRideSatus($userId);
        $rideStatusExpired=RideStatus::where('name','Expired')->first()['id'];
        $rideStatusOnGoing=RideStatus::where('name','OnGoing')->first()['id'];
        $rideStatusCanceled=RideStatus::where('name','Canceled')->first()['id'];
        $rideStatusCompleted=RideStatus::where('name','Completed')->first()['id'];
        try {
            $rideBookHistory = BookRide::where('rideConsumerId', $userId)->with('rideOffer.status')->with('rideOffer.user')->whereHas('rideOffer', function ($query) use($rideStatusCanceled,$rideStatusCompleted) {
                    $query->where('rideOfferId', '=', $rideStatusCanceled)
                          ->orWhere('rideOfferId', '=', $rideStatusCompleted);
            })->get();
            } catch (\Throwable $th) {
                $rideBookHistory=[];
            }
            try{
            $rideOfferHistory= RideOffer::where('userId',$userId)->where(function ($query) use($rideStatusCanceled,$rideStatusCompleted){
                $query->where('rideStatusId', '=', $rideStatusCanceled)
                      ->orWhere('rideStatusId', '=', $rideStatusCompleted);})->get();

            } catch (\Throwable $th) {
                $rideOfferHistory=[];
            }

        try {
            $rideStatusHold=RideStatus::where('name','Hold')->first()['id'];
            $rideStatusNew=RideStatus::where('name','New')->first()['id'];
            $rideBookCurrrent = BookRide::where('rideConsumerId', $userId)->with('rideOffer.status')->with('rideOffer.user')->whereHas('rideOffer.status', function ($query) use($rideStatusExpired,$rideStatusHold,$rideStatusNew,$rideStatusOnGoing) {
                $query->where('rideStatusId', '=', $rideStatusHold)
                      ->orWhere('rideStatusId', '=', $rideStatusNew)
                      ->orWhere('rideStatusId', '=', $rideStatusExpired)
                      ->orWhere('rideStatusId','=',$rideStatusOnGoing);})->get();
            } catch (\Throwable $th) {
                $rideBookCurrrent=[];
            }
            try{
            $rideOfferCurrent= RideOffer::where('userId',$userId)->where(function ($query) use($rideStatusOnGoing,$rideStatusHold,$rideStatusNew,$rideStatusExpired){
                $query->where('rideStatusId', '=', $rideStatusHold)
                      ->orWhere('rideStatusId', '=', $rideStatusNew)
                      ->orWhere('rideStatusId', '=', $rideStatusExpired)
                      ->orWhere('rideStatusId','=',$rideStatusOnGoing);})->with('passengers')->get();

        } catch (\Throwable $th) {
            $rideOfferCurrent=[];
        }
        $rideActivity=['rideBook'=>['current'=>$rideBookCurrrent,'history'=>$rideBookHistory],'rideOffer'=>['current'=>$rideOfferCurrent,'history'=>$rideOfferHistory]];
        return response()->json($rideActivity, 200);

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
