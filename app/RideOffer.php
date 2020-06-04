<?php

namespace App;
use Carbon\CarbonImmutable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class RideOffer extends Model
{
    protected $primaryKey = "id";
    public $incrementing = false;
    // protected $appends = ['vehicle'];
    protected $with = ['vehicle','user','status'];
    protected $appends = [
        'isExpired','humanDate','isAvailable'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'id','userId','vehicleId',
        'pickup','destination','no_of_seats','date',
        'time','price','rideStatusId','originLat',
        'originLong','destinationLong','destinationLat'
    ];
    public function user()
    {
        return $this->belongsTo('App\EndUser', 'userId');
    }
    public function status()
    {
        return $this->belongsTo('App\RideStatus', 'rideStatusId');
    }

    public function vehicle()
    {
        return $this->belongsTo('App\Vehicle', 'vehicleId');
    }
    public function getVehicleAttribute()
    {
        return $this->vehicle();
    }
    public function bookRide()
    {
        return $this->hasMany('App\BookRide', 'rideOfferId');
    }
    public function fullDateTime(){
        return Carbon::parse(Carbon::parse($this->date)->format('Y-m-d').' '. $this->time);
    }
    public function getIsExpiredAttribute(){
        $now = Carbon::now();
        $timestamp = Carbon::parse($this->fullDateTime())->addHour();

        if($now > $timestamp){
            return true;
        }
        return false;
    }
    public function getIsAvailableAttribute(){
        if($this->bookRide()->count()<=$this->no_of_seats){
            return true;
        }
        return false;
    }
    public function getHumanDateAttribute(){
        $today=Carbon::now()->toDateString();

        if(Carbon::parse($today)->diffInDays(Carbon::parse($this->date))>=7||
        Carbon::parse($today)->diffInDays(Carbon::parse($this->date))<=-7){
            return Carbon::parse($today)->diffForHumans(Carbon::parse($this->date));
        }
        switch (Carbon::parse($today)->diffInDays(Carbon::parse($this->date),false)) {
            case 0:
                return 'Today';
            case 1:
                return 'Tommorow';
            case -1:{
                return 'Yesterday';
            }
            default: return Carbon::parse($today)->format('l');
        }
    }
    public function passengers(){
        return $this->belongsToMany('App\EndUser', 'book_rides', 'rideOfferId','rideConsumerId');
    }
}
