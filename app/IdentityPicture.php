<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdentityPicture extends Model
{
	protected $primaryKey = "id";
	public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','fileName', 'userId'
    ];

    public function imageable(){
      return $this->morphTo();
    }
    public function identityPicture(){
        return $this->morphMany('App\IdentityPicture', 'identityable');
    }
}
