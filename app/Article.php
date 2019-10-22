<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Article extends Model
{
    //Mass Assignment
    protected $fillable = ['title', 'description', 'published_at', 'image']; //Whitelist
    //protected $guarded = ['id'];// //Backlist

    protected $dates = ['published_at']; //register datetime to carbon object

    //Mutators, convert date to subday
    public function setPublishedAtAtribute($date)
    {
      $this->attributes['published_at'] = Carbon::parse($date)->subDay();
    }

    //tags, edit list
    public function getTagListAttribute()
    {
        //return $this->tags->lists('id');
        return $this->tags->pluck('id')->all(); //relationship tags articles
        //or ican do this
        //return $this->tags->lists('id')->toArray();
    }

    //relationship, User Model
    /*public function user()
    {
      return $this->belongTo('App\User');
    }*/

    //Scope
    public function scopePublished($query)
    {
      $query->where('published_at', '<=', Carbon::now());
    }

    public function scopeUnpublished($query)
    {
      $query->where('published_at', '>', Carbon::now());
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function tags()
    {
      return $this->belongsToMany('App\Tag')
                  ->withTimestamps(); //update created app, updated app relationship table
    }
}
