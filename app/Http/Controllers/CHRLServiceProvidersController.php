<?php

namespace App\Http\Controllers;

use App\CHRLServiceProviders;
use App\ShareServiceType;
use App\ServiceCatagory;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Image;
class CHRLServiceProvidersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($option=null)
    {
        if($option!=null){
            $model=ShareServiceType::where('name',$option)->first()->serviceCatagory;
        }else{
            $model=ServiceCatagory::all();
        }
        return response()->json($model, 200);
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
    public function store(Request $request, CHRLServiceProviders $model)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CHRLServiceProviders  $cHRLServiceProviders
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $serviceProviders=CHRLServiceProviders::where('id',$id)->with('serviceCatagory.serviceProviders')->with('menuItems')->first();
        return response()->json($serviceProviders, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CHRLServiceProviders  $cHRLServiceProviders
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model1 = CHRLServiceProviders::find($id);
        $model2 = ServiceCatagory::all();
        return view('serviceProviders.edit', ['serviceProvider' => $model1, 'ServiceCatagories' => $model2]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CHRLServiceProviders  $cHRLServiceProviders
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cHRLServiceProviders)
    {
        $model = CHRLServiceProviders::find($cHRLServiceProviders);
        $model->update($request->all());
        return redirect('serviceProviders')->with('Service Provider Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CHRLServiceProviders  $cHRLServiceProviders
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      // return $menuItemGroup;
      $check = CHRLServiceProviders::find($id)->delete();
      if (!$check) {
          return redirect()->back()->withErrors("Something went wrong");
      }
        return redirect()->back()->withSuccess('Successfully Deleted');
    }
    public function getLogo($imageName)
    {
        $path = public_path() . '/storage/Images/ServiceProviders/logos/' . $imageName;
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }
}
