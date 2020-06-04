<?php

namespace App\Http\Controllers;

use App\UserServiceProvider;
use Illuminate\Http\Request;
use App\CHRLServiceProviders;
class UserServiceProviderController extends Controller
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
        $serviceProviders=CHRLServiceProviders::find($request['serviceProviderId']);
        $serviceProviders->admins()->attach($request['endUserId']);
        return redirect()->back()->withSuccess('Admin Successfully added');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserServiceProvider  $userServiceProvider
     * @return \Illuminate\Http\Response
     */

    public function show(UserServiceProvider $userServiceProvider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserServiceProvider  $userServiceProvider
     * @return \Illuminate\Http\Response
     */
    public function edit(UserServiceProvider $userServiceProvider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserServiceProvider  $userServiceProvider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserServiceProvider $userServiceProvider)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserServiceProvider  $userServiceProvider
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserServiceProvider $userServiceProvider)
    {
        //
    }
    public function changeServiceProvider(Request $request){
        $serviceProviders=auth()->user()->serviceProviders;
        foreach ($serviceProviders as $key => $item) {
            auth()->user()->serviceProviders()->updateExistingPivot($item->id,['selected' => false]);
        }
        auth()->user()->serviceProviders()->updateExistingPivot($request['serviceProviderId'],['selected' => true]);
        return redirect()->back()->withSuccess('Admin Successfully added');
    }
}
