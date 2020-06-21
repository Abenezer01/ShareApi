<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuItems extends Model
{

  protected $guarded=[];
  protected $primaryKey = "id";
  public $incrementing = false;
  protected $fillable = [
      'id', 'itemsGroupId', 'availability', 'name', 'price', 'description', 'serviceProviderId',
  ];
  protected $appends = [
    'weightedAvg','getPicture','rateValue','eachRatersValue','totalCustomers'
];
 protected $with=[
     'rating','itemsGroup','serviceProvider'
 ];
  public function customerOrders(){
      return $this->hasMany('App\CustomerOrders', 'itemId');
  }
  public function getTotalCustomersAttribute(){
    return $this->customerOrders()->count();
  }
  public function serviceProvider()
  {
      return $this->belongsTo('App\CHRLServiceProviders', 'serviceProviderId');
  }
  public function itemsGroup()
  {
      return $this->belongsTo('App\MenuItemGroup', 'itemsGroupId');
  }
  public function getSelectedPicture(){
     return $this->pictures()->orderBy('created_at', 'ASC')->first();
  }
  public function getGetPictureAttribute(){
     return $this->pictures()->orderBy('created_at', 'ASC')->first();
  }

  public function pictures(){
     return $this->morphMany(Image::class,'imageable');
  }
  public function rating(){
    return $this->morphMany(Rating::class,'rateable');
  }
  public function getRateValueAttribute(){
    $rateValue=0;
    $totalRate=$this->rating->count();
    foreach ($this->rating as $key) {
        $rateValue=$rateValue+$key->value;
    }
    if($totalRate>0){
        return $rateValue/$totalRate;
    }
    return 0;
  }
  public function getEachRatersValueAttribute(){
    $totalRater=$this->rating->count();
    $ratingEachValue=['one'=>0,'two'=>0,'three'=>0,'four'=>0,'five'=>0];
    foreach ($this->rating as $key) {
        switch($key->value){
            case 1:$ratingEachValue['one']+=1;
                break;
            case 2:$ratingEachValue['two']+=1;
                break;
            case 3:$ratingEachValue['three']+=1;
                break;
            case 4:$ratingEachValue['four']+=1;
                break;
            case 5:$ratingEachValue['five']+=1;
        }

    }
    if($totalRater>0){
        $ratingEachValue['one']/=$totalRater;
        $ratingEachValue['two']/=$totalRater;
        $ratingEachValue['three']/=$totalRater;
        $ratingEachValue['four']/=$totalRater;
        $ratingEachValue['five']/=$totalRater;
    }
    return $ratingEachValue;
  }
  public function getWeightedAvgAttribute(){
    $avgRateValue=$this->getRateValueAttribute();
    $totalRaters=$this->rating->count();
    return ($avgRateValue*0.35)+($totalRaters*0.65);
  }

}
