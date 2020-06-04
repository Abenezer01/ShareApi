<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserServiceProvider extends Model
{
  protected $fillable = [
      'userId','serviceProviderId'
  ];
}
