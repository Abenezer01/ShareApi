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
        'getSelectedLogo','weightedAvg','rateValue','eachRatersValue'
    ];
    protected $with = [
        'location', 'serviceCatagory'
    ];
    public function logo()
    {
        return $this->morphMany('App\Image', 'imageable');
    }
    public function getGetSelectedLogoAttribute()
    {
        return $this->logo()->orderBy('created_at', 'ASC')->first();
    }
    public function getSelectedLogo()
    {
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
    public function rating()
    {
        return $this->morphMany('App\Rating', 'rateable');
    }
    public function getRateValueAttribute()
    {
        $rateValue = 0;
        $totalRate = $this->rating->count();
        foreach ($this->rating as $key) {
            $rateValue = $rateValue + $key->value;
        }
        if ($totalRate > 0) {
            return $rateValue / $totalRate;
        }
        return 0;
    }
    public function getEachRatersValueAttribute()
    {
        $totalRater = $this->rating->count();
        $ratingEachValue = ['one' => 0, 'two' => 0, 'three' => 0, 'four' => 0, 'five' => 0];
        foreach ($this->rating as $key) {
            switch ($key->value) {
                case 1:
                    $ratingEachValue['one'] += 1;
                    break;
                case 2:
                    $ratingEachValue['two'] += 1;
                    break;
                case 3:
                    $ratingEachValue['three'] += 1;
                    break;
                case 4:
                    $ratingEachValue['four'] += 1;
                    break;
                case 5:
                    $ratingEachValue['five'] += 1;
            }
        }
        if ($totalRater > 0) {
            $ratingEachValue['one'] /= $totalRater;
            $ratingEachValue['two'] /= $totalRater;
            $ratingEachValue['three'] /= $totalRater;
            $ratingEachValue['four'] /= $totalRater;
            $ratingEachValue['five'] /= $totalRater;
        }
        return $ratingEachValue;
    }
    public function getWeightedAvgAttribute()
    {
        $avgRateValue = $this->getRateValueAttribute();
        $totalRaters = $this->rating->count();
        return ($avgRateValue * 0.35) + ($totalRaters * 0.65);
    }

    public function admins()
    {
        return $this->belongsToMany('App\EndUser', 'user_service_providers', 'serviceProviderId', 'userId');
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
