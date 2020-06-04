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
    'getPicture'
];
 protected $with=[
     'itemsGroup','serviceProvider'
 ];
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
}
