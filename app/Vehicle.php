<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
  protected $primaryKey = "id";
  public $incrementing = false;
  protected $fillable = [
      'id','brand', 'model','year', 'plateNo','userId','isActive'
  ];
  public function user()
  {
      return $this->belongsTo('App\EndUser', 'userId');
  }
  public function rides()
  {
      return $this->hasMany('App\RideOffer', 'vehicleId');
  }
}
