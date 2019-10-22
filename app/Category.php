<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Iverberk\Larasearch\Traits\MappableTrait;

class Category extends Model
{
    //use MappableTrait;

    //Mass Assignment
    protected $fillable = ['name', 'category', 'category_type']; //Whitelist

    public function scopeNameCateId($query, $cate_id)
    {
      return $this->where('category', $cate_id)->first()->name;
    }

    public function articles()
    {
      return $this->belongsToMany('App\Article');
    }

    public function events()
    {
      return $this->belongsToMany('App\Event');
    }

    public function brand()
    {
      return $this->belongsToMany('App\Brand');
    }
}
