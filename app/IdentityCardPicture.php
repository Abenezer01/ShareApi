<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdentityCardPicture extends Model
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
}
