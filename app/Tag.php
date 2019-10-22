<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Iverberk\Larasearch\Traits\MappableTrait;

class Tag extends Model
{
    //use MappableTrait;

    //Mass Assignment
    protected $fillable = ['name', 'tag']; //Whitelist

    public function articles()
    {
      return $this->belongsToMany('App\Article');
    }

    public function events()
    {
      return $this->belongsToMany('App\Event');
    }
}
