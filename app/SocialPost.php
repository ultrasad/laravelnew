<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialPost extends Model
{
  protected $table = 'social_posts';

  protected $fillable =  ['social', 'event_id', 'page_id', 'post_id', 'published_at', 'deleted_at'];

  public function events()
  {
      return $this->belongsTo('App\Event');
  }
}
