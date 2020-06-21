<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $primaryKey = ['id', 'userId'];
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'userId', 'value',
    ];

    public function rateable()
    {
        return $this->morphTo();
    }

}
