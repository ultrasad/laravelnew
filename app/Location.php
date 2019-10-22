<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Iverberk\Larasearch\Traits\MappableTrait;

class Location extends Model
{
  //use MappableTrait;

  protected $table = 'locations';

  //Mass Assignment
  protected $fillable = ['name', 'lat', 'lon', 'zoom']; //Whitelist

  /**
  * @return bool
  */
  public function shouldIndex()
  {
      // Your custom logic to determine if a (re)index should be performed
      //$this->shouldIndex();
      //$this->deleted('Event');
      return true;
  }

  public function events()
  {
    return $this->belongsToMany('App\Event');
  }
}
