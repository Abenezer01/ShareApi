<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class EndUser extends Authenticatable #changed
{
    use Notifiable, HasApiTokens; #changed

  protected $primaryKey = "id";
  public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','firstName', 'lastName','phone','gender','email','password'
    ];
    // protected $with = [];
    protected $appends = [
        'getSelectedAvatar'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function getGetSelectedAvatarAttribute(){

        return $this->avatar()->orderBy('created_at', 'desc')->first();
    }
    protected $table='end_users';
    public function avatar(){
      return $this->morphMany('App\Avatar', 'avatarable');
     }
    public function getSelectedAvatar(){
        return $this->avatar()->orderBy('created_at', 'desc')->first();
    }
    public function getSelectedSP(){
        return $this->serviceProviders()->where("selected",1)->first();
    }
    public function fullName(){
        return "{$this->firstName} {$this->lastName}";
    }
    public function serviceProviders(){
      return $this->belongsToMany('App\CHRLServiceProviders', 'user_service_providers', 'userId', 'serviceProviderId')->withPivot('selected');
    }
    public function vehicles()
    {
        return $this->hasMany('App\Vehicle', 'userId');
    }
    public function rideOffer()
    {
        return $this->hasMany('App\RideOffer', 'userId');
    }
    public function customerOrders()
    {
        return $this->hasMany('App\CustomerOrders','customerId','id');
    }
    

}
