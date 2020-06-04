<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

  protected $fillable = [
  'city', 'subCity', 'serviceProviderId', 'lng', 'lat',
];
protected $casts = [
  'lat' => 'float',
  'lng' => 'float',
];
public function serviceProvider()
{
    return $this->belongsTo('App\CHRLServiceProviders', 'serviceProviderId');
}
}
