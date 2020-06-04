<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RideStatus extends Model
{  protected $primaryKey = "id";
  public $incrementing = false;


  protected $fillable = [
      'id','name','description'
  ];
}
