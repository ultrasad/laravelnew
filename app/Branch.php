<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Iverberk\Larasearch\Traits\MappableTrait;
//use Iverberk\Larasearch\Traits\TransformableTrait;
//use Iverberk\Larasearch\Traits\CallableTrait;
use Iverberk\Larasearch\Traits\SearchableTrait;
class Branch extends Model
{
    //use MappableTrait;
    //use TransformableTrait;
    use SearchableTrait;
    //use TransformableTrait, CallableTrait;

    protected $table = 'branch';

    //Mass Assignment
    protected $fillable = ['name', 'location', 'image', 'lat', 'lon', 'zoom', 'detail']; //Whitelist

    /*public function getEventAllAttribute()
    {
        return $this->events->lists('title')->all();
    }*/

    public static $__es_config = [
      //'autocomplete' => ['event.title', 'event.url_slug', 'event.brief', 'brand.name', 'branch.name'],
      //'suggest' => ['event.title', 'event.url_slug', 'event.brief', 'brand.name', 'branch.name'],
      'autocomplete' => ['name'],
      'suggest' => ['name'],
      'word_start' => ['name'],
      'word_end' => ['name'],
      'text_start' => ['name'],
      'text_end' => ['name'],
    ];

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

    public function scopeBrandList($query, $brand)
    {
      return $this->whereHas('brands', function($query) use ($brand)
      {
          $query->where('id', '=', $brand);
      });
    }

    public function events()
    {
      //return $this->belongsToMany('App\Event', 'event_branch');
      return $this->belongsToMany('App\Event', 'event_branch', 'branch_id');
    }

    public function brands()
    {
      return $this->belongsToMany('App\Brand', 'brand_branch');
    }
}
