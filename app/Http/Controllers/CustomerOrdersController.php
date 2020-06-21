<?php

namespace App\Http\Controllers;

use App\CustomerOrders;
use Illuminate\Http\Request;
use App\Status;
use Auth;
class CustomerOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->updateOrderStatus();
        $model =Auth::user()->customerOrders->sortByDesc('created_at')->values();
        return response()->json($model, 200);
    }
    private function updateOrderStatus(){

        $status=Status::where('name','Expired')->first();
        foreach (Auth::user()->customerOrders as $order) {
            if($order->isExpired==true){
                $order->update(['statusId'=>$status->id]);
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
        $orderData=$request->all();
        $orderData['userLocation']=json_encode($orderData['userLocation']);
        $orderData['id']='CO-'.uniqid();
        $orderData['statusId']=Status::where('name','New')->first()['id'];
        $response=$request->user()->customerOrders()->create($orderData);
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CustomerOrders  $customerOrders
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerOrders $customerOrders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomerOrders  $customerOrders
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerOrders $customerOrders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomerOrders  $customerOrders
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerOrders $customerOrders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomerOrders  $customerOrders
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerOrders $customerOrders)
    {
        //
    }
}
