<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class CHRLServiceProviders extends Model
{
  protected $primaryKey = "id";
  public $incrementing = false;
  //
  protected $fillable = [
      'id', 'serviceCatagoryId', 'name', 'isOpen', 'email', 'phone', 'about', 'webLink', 'openningHour', 'closingHour',
  ];
  protected $appends = [
    'getSelectedLogo'
];
protected $with = [
    'location','serviceCatagory'
];
  public function logo(){
    return $this->morphMany('App\Image', 'imageable');
  }
  public function getGetSelectedLogoAttribute(){
    return $this->logo()->orderBy('created_at', 'ASC')->first();
  }
  public function getSelectedLogo(){
    return $this->logo()->orderBy('created_at', 'ASC')->first();
  }

  public function getLocationAttribute()
  {
      return $this->hasOne('App\Location', 'serviceProviderId');
  }
  public function location()
  {
      return $this->hasOne('App\Location', 'serviceProviderId');
  }
  public function user()
  {
      return $this->hasMany('App\EndUser', 'serviceProviderId');
  }
  public function serviceCatagory()
  {
      return $this->belongsTo('App\ServiceCatagory', 'serviceCatagoryId');
  }
  public function menuItems()
  {
      return $this->hasMany('App\MenuItems', 'serviceProviderId');
  }
  public function customerOrders()
  {
      return $this->hasMany('App\CustomerOrders', 'serviceProviderId');
  }
  public function rate()
  {
      return $this->hasMany('App\SPRating', 'serviceProviderId');
  }
  public function admins(){
    return $this->belongsToMany('App\EndUser', 'user_service_providers','serviceProviderId','userId');
  }
  // public function logo(){
  //     return $this.
  // }
  public function isOpen()
  {
      $openningHour = Carbon::parse($this->openningHour);
      $closingHour = Carbon::parse($this->closingHour);
      $now = Carbon::now();
      if ($now->gte($openningHour) && $now->lte($closingHour)) {
          $data = [
              'isOpen' => true,
          ];
          return response()->json($data, 200);
      }
      $data = [
          'isOpen' => false,
      ];

      return response()->json($data, 200);
  }
}
