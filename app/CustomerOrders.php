<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CustomerOrders extends Model
{

    protected $primaryKey = "id";
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'quantity','customerId', 'itemId','userLocation','statusId', 'description', 'serviceProviderId','description'
    ];
    protected $appends = [
        'isExpired'
      ];
    protected $casts = [
        'quantity' => 'integer',
    ];
    protected $with = ['status','serviceProvider','item'];

    public function item()
    {
        return $this->belongsTo('App\MenuItems', 'itemId');
    }
    public function serviceProvider(){
    	return $this->belongsTo('App\CHRLServiceProviders','serviceProviderId');
    }
    public function status(){
    	return $this->belongsTo('App\Status','statusId');
    }
    public function customer()
    {
        return $this->belongsTo('App\EndUser', 'customerId','id');
    }

    public function totalPrice(){
    	return $this->quantity* $this->item()->price;
    }
    public function getIsExpiredAttribute(){
        $now = Carbon::now();
        $timestamp = Carbon::parse($this->created_at)->addHour();
        if($now > $timestamp){
            return true;
        }
        return false;
    }

}
