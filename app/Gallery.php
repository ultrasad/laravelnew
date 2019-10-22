<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
  //protected $table = 'galleries';

  //Mass Assignment
  protected $fillable = ['name', 'image']; //Whitelist
  public function events()
  {
    return $this->belongsToMany('App\Event');
  }
}
