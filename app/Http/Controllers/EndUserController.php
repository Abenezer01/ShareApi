<?php

namespace App\Http\Controllers;

use App\Avatar;
use App\EndUser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Unique;
use App\UserType;
use File, Hash;
use Image;
use Response;

class EndUserController extends Controller
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

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EndUser  $endUser
     * @return \Illuminate\Http\Response
     */
    public function show(EndUser $endUser)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EndUser  $endUser
     * @return \Illuminate\Http\Response
     */
    public function edit(EndUser $endUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EndUser  $endUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EndUser $endUser)
    {
        if($endUser->getSelectedAvatar()->avatarName)
        $credentials=['firstName'=>$request->firstName,
                      'lastName'=>$request->lastName,
                       'email'=>$request->email];
        $endUser->update($credentials);
        return redirect()->back()->withSuccess('Profile updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EndUser  $endUser
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user=EndUser::find($id);
      if($user){
        $user->delete();
        return redirect()->back()->withSuccess('User deleted Successfully');
      }
      return redirect()->back()->withErrors('Something went wrong');
    }
    public function filter(Request $request,$id){
      $user=EndUser::where('id',$id)->get();
      return Response::json($user);
    }
}
