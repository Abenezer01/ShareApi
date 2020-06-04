<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class status extends Model
{
  protected $primaryKey = "id";
  public $incrementing = false;
  protected $fillable = [
     'id','name','description','color'
  ];
}
