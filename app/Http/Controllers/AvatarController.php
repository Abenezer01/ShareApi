<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvatarController extends Controller
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->file('avatarPreview')) {
            $image = $request->file('avatarPreview');
            $fileNameToStore  = auth()->user()->firstName.time().'.'.$image->getClientOriginalExtension();
            $client = new  \GuzzleHttp\Client();
            try{
                $response = $client->request('POST', config('global.picturePaths.avatar').'store', [
                  'multipart' => [
                       [
                          'name'     => 'fileName',
                          'contents' => $fileNameToStore
                      ],
                      [
                          'name'=>'avatarPreview',
                          'contents' => fopen($image, 'r')
                      ],
                  ]
              ]);
                } catch (Exception $e) {
                    return response()->json(['message'=>$e], 200);
                }
            if($response->getStatusCode()==200){
                $request->user()->avatar()->create(['avatarName'=>$fileNameToStore]);
             }else{
                return response()->json(['message'=>'something went wrong'], 200);
             }
          }else{
              return response()->json(['message'=>'profile picture updated successfully'], 200);
          }
          return response()->json(['message'=>'profile picture updated successfully'], 200);
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
