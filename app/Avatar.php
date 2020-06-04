<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
  protected $primaryKey = "id";
  public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','avatarName', 'userId'
    ];

    public function imageable(){
      return $this->morphTo();
    }
}
