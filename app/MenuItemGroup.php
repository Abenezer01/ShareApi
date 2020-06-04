<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuItemGroup extends Model
{
  protected $guarded=[];
  protected $primaryKey = "id";
  public $incrementing = false;
  protected $appends = [
    'getPicture'
];
  protected $fillable = [
      'id',  'name', 'description','serviceTypeId'
  ];
  public function menuItems()
  {
      return $this->hasMany('App\MenuItems','itemsGroupId');
  }
  public function picture(){
    return $this->morphMany('App\Image', 'imageable');
  }
  public function getGetPictureAttribute(){
    return $this->picture()->orderBy('created_at', 'ASC')->first();
  }

  public function serviceType()
  {
      return $this->belongsTo('App\ShareServiceType', 'serviceTypeId');
  }

}
