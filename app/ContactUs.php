<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{

  protected $primaryKey = "id";
  public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','subject','description','userId'
    ];
   public function user()
   {
       return $this->belongsTo(EndUser::class, 'userId');
   }

}
