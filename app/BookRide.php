<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookRide extends Model
{
  protected $primaryKey = "id";
    public $incrementing = false;
    protected $with = ['user'];
    protected $fillable = [
        'rideOfferId','id','rideConsumerId','totalPass'
    ];
    public function user()
    {
        return $this->belongsTo('App\EndUser', 'rideConsumerId');
    }
    public function rideOffer()
    {
        return $this->belongsTo('App\RideOffer', 'rideOfferId');
    }

}
