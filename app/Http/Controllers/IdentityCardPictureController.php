<?php

namespace App\Http\Controllers;

use App\IdentityCardPicture;
use Illuminate\Http\Request;

class IdentityCardPictureController extends Controller
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
        if ($request->file('identityCardPreview')) {
            $image = $request->file('identityCardPreview');
            $fileNameToStore  = 'Id-'.auth()->user()->firstName.time().'.'.$image->getClientOriginalExtension();
            $client = new  \GuzzleHttp\Client();
            try{
                $response = $client->request('POST', config('global.picturePaths.identityCard').'store', [
                  'multipart' => [
                       [
                          'name'     => 'fileName',
                          'contents' => $fileNameToStore
                      ],
                      [
                          'name'=>'identityCardPreview',
                          'contents' => fopen($image, 'r')
                      ],
                  ]
              ]);
                } catch (Exception $e) {
                    return response()->json(['message'=>$e], 200);
                }
            if($response->getStatusCode()==200){
                $request->user()->identityCardPicture()->create(['fileName'=>$fileNameToStore]);
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
     * @param  \App\IdentityCardPicture  $identityCardPicture
     * @return \Illuminate\Http\Response
     */
    public function show(IdentityCardPicture $identityCardPicture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IdentityCardPicture  $identityCardPicture
     * @return \Illuminate\Http\Response
     */
    public function edit(IdentityCardPicture $identityCardPicture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IdentityCardPicture  $identityCardPicture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IdentityCardPicture $identityCardPicture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IdentityCardPicture  $identityCardPicture
     * @return \Illuminate\Http\Response
     */
    public function destroy(IdentityCardPicture $identityCardPicture)
    {
        //
    }
}
