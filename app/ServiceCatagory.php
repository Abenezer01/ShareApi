<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCatagory extends Model
{
    protected $primaryKey = "id";
    public $incrementing = false;
    protected $fillable = [
    'id', 'name', 'description','serviceTypeId'
  ];
  protected $appends = [
    'getSelectedLogo'
];
  public function serviceProviders()
  {
    return $this->hasMany('App\CHRLServiceProviders', 'serviceCatagoryId');
  }
  public function logo(){
    return $this->morphMany('App\Image', 'imageable');
  }
  public function getSelectedLogo(){
    return $this->logo()->orderBy('created_at', 'ASC')->first();
  }
  public function getGetSelectedLogoAttribute(){
    return $this->logo()->orderBy('created_at', 'ASC')->first();
  }
  public function serviceType()
  {
      return $this->belongsTo('App\ShareServiceType', 'serviceTypeId');
  }
}
