<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShareServiceType extends Model
{
    protected $primaryKey = "id";
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
      'id','name','description'
    ];
    protected $casts = [
        'quantity' => 'integer',
    ];
    public function serviceCatagory()
    {
        return $this->hasMany('App\ServiceCatagory','serviceTypeId');
    }
    public function serviceProviders()
    {
        return $this->hasManyThrough('App\CHRLServiceProviders', 'App\ServiceCatagory','serviceTypeId','serviceCatagoryId');
    }
    public function menuItemGroup()
    {
        return $this->hasMany('App\MenuItemGroup','serviceTypeId');
    }

    public function menuItems()
    {
        return $this->hasManyThrough('App\MenuItems', 'App\MenuItemGroup','serviceTypeId','itemsGroupId');
    }

}
