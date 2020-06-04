<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\EndUser;
use App\UserType;
use File, Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Image;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

  }
  public function getAllUser()
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
    $this->validate($request, [
      'name' => 'required',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|same:confirm-password',
      'phone' => 'required',
      'avatarPreview' => 'required|image|mimes:jpeg,jpg,png,gif,tif|nullable'
    ]);
    $fileNameToStore = "";
      // return $request;
    if ($request->file('avatarPreview')) {
      $image = $request->file('avatarPreview');
      $fileNameToStore  = $request['name'] . time() . '.' . $image->getClientOriginalExtension();
      $path = 'storage/images/avatar/' . $fileNameToStore;
      Image::make($image->getRealPath())->resize(200, 200)->save($path);
    }

    $input = $request->all();
    $input['password'] = Hash::make($input['password']);
    $input['avatar'] = $fileNameToStore;
    $input['id']=$input['name'].time();
    $user = EndUser::create($input);
    return redirect()->route('users.index')
      ->with('success', 'User created successfully');
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
    $user=EndUser::find($id);
    if($user){
      $user->delete();
      return redirect()->back()->withSuccess('User deleted Successfully');
    }
    return redirect()->back()->withErrors('Something went wrong');
  }
}
