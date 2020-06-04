<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ServiceCatagory;
use App\Images;
use Image;
class ServiceCatagoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $model=ServiceCatagory::all();
      return $model;
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
    public function store(Request $request,ServiceCatagory $model)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $model=ServiceCatagory::where('id',$id)->with('serviceProviders')->first();

        } catch (\Throwable $th) {
            return response()->json(['message'=>'something went wrong'], 200);
        }
        return response()->json($model, 200);
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
      // return $menuItemGroup;
      $check = ServiceCatagory::find($id)->delete();
      if (!$check) {
          return redirect()->back()->withErrors("Something went wrong");
      }
        return redirect()->back()->withSuccess('Successfully Deleted');

    }
}
