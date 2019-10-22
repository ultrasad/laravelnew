<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use Iverberk\Larasearch\Traits\SearchableTrait;

class Event extends Model
{
    use SearchableTrait;
    //public static $__es_enable = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    //protected $table = 'events';
    //Mass Assignment
    protected $fillable = ['title', 'facebook_title', 'twitter_title', 'social_post', 'url_slug', 'start_date', 'end_date', 'image', 'brief', 'description', 'published_at', 'user_id', 'brand_id']; //Whitelist
    //protected $guarded = ['id'];// //Backlist

    protected $dates = ['start_date', 'end_date', 'published_at']; //register datetime to carbon object
    //protected $dates = ['start_date', 'published_at'];

    //Larasearch
    /*public static $__es_config = [
      'autocomplete' => ['title', 'url_slug', 'brief', 'brand.name', 'branch.name', 'tag.name', 'location.name'],
      'suggest' => ['title', 'url_slug', 'brief', 'brand.name', 'branch.name', 'tag.name', 'location.name'],
      'text_start' => ['title', 'brief', 'branch.name'],
      'text_middle' => ['title', 'brief', 'branch.name'],
      'text_end' => ['title', 'brief', 'branch.name'],
      'word_start' => ['title', 'brief', 'branch.name'],
      'word_middle' => ['title', 'brief', 'branch.name'],
      'word_end' => ['title', 'brief', 'branch.name'],
       //'suggest' => ['title', 'url_slug', 'brief', 'brand.name', 'branch.name', 'tag.name', 'location.name']
    ];*/

    public static $__es_config = [
        'autocomplete' => ['title', 'branch.name', 'branch.location'],
        //'suggest' => ['title', 'branch.name'],
        //'word_start' => ['title', 'description', 'branch.name', 'branch.location'],
        //'word_end' => ['title', 'description', 'branch.name', 'branch.location'],
        //'text_start' => ['title', 'description', 'branch.name', 'branch.location'], //old not work for length
        'text_start' => ['title', 'brief', 'branch.name', 'branch.location'], //old not work for length
        //'text_middle' => ['title', 'branch.name', 'branch.location'],
        //'text_end' => ['title', 'branch.name', 'branch.location'],
        //'text_start' => ['title', 'brief', 'description'],
        //'text_end' => ['title', 'brief', 'description'],
    ];

    /**
    * @return bool
    */
    public function shouldIndex()
    {
        // Your custom logic to determine if a (re)index should be performed
        //$this->shouldIndex();
        //$this->deleted('Event');

        //$this->reIndex('App\Event --relations');
        return true;
    }

    //Scope
    public function scopePublished($query)
    {
      $query->where('events.published_at', '<=', Carbon::now());
    }

    public function scopeUnpublished($query)
    {
      $query->where('events.published_at', '>', Carbon::now());
    }

    public function scopeNoExpire($query)
    {
        $query->where('end_date', '>=', Carbon::today())->orWhere('end_date', '=', '0000-00-00');
    }

    //category, edit list
    public function getCategoryListAttribute()
    {
        //return $this->tags->lists('id');
        return $this->category->lists('id')->all(); //relationship category events
        //or ican do this
        //return $this->category->lists('id')->toArray();
    }

    //tags, edit list
    public function getTagListAttribute()
    {
        return $this->tags->lists('name')->all(); //relationship tags events
    }

    public function getGalleryListAttribute()
    {
        return $this->gallery->pluck('image')->all();
    }

    public function getLocationFirstAttribute()
    {
        return $this->location->first();
    }

    public function getBranchListAttribute()
    {
      return $this->branch->lists('name', 'id')->all();
    }

    public function getCategoryFirstAttribute()
    {
        return $this->category->first();
    }

    protected function convertDate($timestamp)
    {
      // Quick month array
      $m = array("01"=>"ม.ค.",
             "02"=>"ก.พ.",
             "03"=>"มี.ค.",
             "04"=>"เม.ย.",
             "05"=>"พ.ค.",
             "06"=>"มิ.ย.",
             "07"=>"ก.ค.",
             "08"=>"ส.ค.",
             "09"=>"ก.ย.",
             "10"=>"ต.ค.",
             "11"=>"พ.ย.",
             "12"=>"ธ.ค."
      );

      //return $timestamp;
      //exit;

      //if(!starts_with($timestamp, '0000')) {
      if(!starts_with($timestamp, '-000')) {
        $date = date('Y-m-d', strtotime($timestamp));
        return ((int) substr($date, 8)).' '.$m[substr($date, 5, -3)].' '.(substr($date, 2, -6)+43);
      } else {
        return 'ไม่ระบุ';
      }
    }

    public function getCheckExpireAttribute()
    {
      $startdate = new Carbon($this->start_date);
      $enddate = new Carbon($this->end_date->addHour(23)->addMinute(59)->addSeconds(59)); //protected $dates
      $current = Carbon::now();
      $diff_start = $current->diffInDays($startdate, false);
      $diff_end = $current->diffInDays($enddate, false);
      $difference = '';
      switch(true){
        case ($startdate > $current):
          $difference = 'อีก ' . ($diff_start + 1) . ' วันเริ่มโปรโมชั่น';
        break;
        case($diff_end >= 1):
          $difference = 'เหลือเวลาอีก : ' . $diff_end . ' วัน';
        break;
        case ($diff_end < 1):
          if(!starts_with($this->end_date, '-000')) {
            $difference = 'หมดโปรโมชั่นแล้ว!!';
          }
        break;
        default:
          $difference = 'ไม่ระบุ';
        break;
      }
      //$difference = ($diff < 1) ? 'หมดโปรโมชั่นแล้ว!!' : 'เหลือเวลาอีก : ' . $diff . ' วัน';
      return $difference;
    }

    public function getEndDateThaiAttribute()
    {
      //echo '=> ' . $this->getAttribute('end_date');
      return $this->convertDate($this->getAttribute('end_date'));
      /*if($this->end_date){
        return $this->convertDate($this->end_date);
      } else {
        //return date('Y-m-d', strtotime('+5 years'));
        return $this->convertDate($this->start_date);
      }*/
    }

    public function getStartDateThaiAttribute()
    {
      //return $this->convertDate($this->getAttribute('start_date'));
      return $this->convertDate($this->start_date);
    }

    public function scopeSetLocal($query)
    {
      Carbon::setLocale('th');
    }

    public function scopeFilter($query, $condition)
    {
      if($condition == 'today'){
       return $query->where('start_date', date('Y-m-d'));
     } else if ($condition == 'thisweek'){
       return $query->whereBetween('start_date', [
            Carbon::parse('last monday')->startOfDay(),
            Carbon::parse('next friday')->endOfDay(),
        ]);
     } else if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$condition)){ //Y-m-d
       return $query->where('start_date', date('Y-m-d', strtotime($condition)));
     }
    }

    /**
    * Scope a query to only include active events.
    *
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeActive($query)
    {
       return $query->where('events.active', 'Y');
    }

    public function scopeEventOther($query, $id)
    {
      return $query->where('id', '!=', $id);
    }

    public function scopeRelateThis($query, $event_id, $cate_id, $brand_cate_id, $tags=null)
    {

      //echo $event_id . '=>' . $cate_id . '=>'. $brand_cate_id;
      //exit;

      //print_r($tags);
      //exit;

        if($brand_cate_id > 0){
          $relate_cate = $query->select('events.*')->leftJoin('brand', 'events.brand_id', '=', 'brand.id')
          ->leftJoin('brand_category', 'brand_category.brand_id', '=', 'brand.id')
          ->where('brand_category.cate_id', '=', $brand_cate_id)
          ->where('events.id', '!=', $event_id)
          ->where('events.active', 'Y')->orderBy('events.created_at', 'desc')->limit(6);

        } else { //unknow category
          $relate_cate = $query->select('events.*')->leftJoin('brand', 'events.brand_id', '=', 'brand.id')
          ->leftJoin('brand_category', 'brand_category.brand_id', '=', 'brand.id')
          ->whereNull('brand_category.cate_id')
          ->where('events.id', '!=', $event_id)
          ->where('events.active', 'Y')->orderBy('events.created_at', 'desc')->limit(6);
        }

        $relate_tag_count = 0;
        if(!empty($tags)){
          //echo 'tag xx';
          //exit;
          $relate_tag = $this->select('events.*')->whereHas('tags', function($query) use ($tags){
            $query->whereIn('tags.tag', $tags);
          })->orderBy('events.created_at', 'desc')->union($relate_cate)->where('events.active', 'Y')->where('id', '!=', $event_id)->limit(6);

          $relate_tag_count = $relate_tag->get()->count();
        }

        if($relate_tag_count < 1){
          return $relate_cate;
        } else {
          return $relate_tag;
        }

        /*$relate_cate = $this->whereHas('category', function($query) use ($cate_id) {
          $query->where('categories.id', $cate_id);
        })->where('id', '!=', $event_id)->orderBy('events.created_at', 'desc');

        $relate_tag = $this->whereHas('tags', function($query) use ($tags){
          $query->whereIn('tags.tag', $tags);
        })->with(['category' => function($query) use ($cate_id){
          //$query->where('category.id', $cate_id);
        }])->orderBy('events.created_at', 'desc')->union($relate_cate)->where('id', '!=', $event_id); //->get();

        if($relate_tag->get()->count() < 1){
          return $relate_cate;
        } else {
          return $relate_tag;
        }*/
    }

    public function scopeBrandEvent($query, $brand)
    {
      return $query->whereHas('brand', function($query) use ($brand)
      {
        if(is_array($brand)){
            $query->whereIn('id', $brand);
        } else{
            if($brand != '')
              $query->where('id', '=', $brand);
        }
      });
    }

    /*public function scopeEventBrand($query)
    {
      return $query->leftJoin('brand','events.brand_id','=','brand.id')->select('events.*', 'brand.id as brand_id', 'brand.name as brand_name');
    }*/

    public function scopeEventLike($query, $title)
    {
      //if(trim($title) != '')
      //echo '=> =>' . $title;
      return $query->where('title', 'LIKE', "%$title%");
    }

    public function scopeBrandId($query, $brand)
    {
      return $query->where('brand_id', $brand);
    }

    public function scopeBrandSlug($query, $brand)
    {
      return $query->leftJoin('brand','events.brand_id','=','brand.id')->where('brand.url_slug', $brand);
    }

    public function scopeTagList($query, $tag)
    {
      return $this->whereHas('tags', function($query) use ($tag)
      {
          $query->where('tag', '=', $tag);
      })->where('events.active', 'Y');
    }

    public function scopeCategoryList($query, $category)
    {
      if($category != 'unknow'){
        return $this->whereHas('category', function($query) use ($category)
        {
            $query->where('category', '=', $category);
            //$query->where('category', '=', NULL);
        });
      } else {
        return  $this->leftJoin('event_category','event_category.event_id','=','events.id')->leftJoin('categories','categories.id','=','event_category.cate_id')->whereNull('categories.name');
      }
    }

    public function scopeBrandCategoryList($query, $category)
    {
      if($category != 'unknow'){
        return $this->whereHas('brand', function($query) use ($category)
        {
            //$query->where('category', '=', $category);
            $query->whereHas('category', function ($query) use ($category){
              $query->where('category', '=', $category);
            });
        })->where('events.active', 'Y');
      } else {
        return  $this->leftJoin('brand', 'brand.id', '=', 'events.brand_id')->leftJoin('brand_category','brand_category.brand_id','=','brand.id')->leftJoin('categories','categories.id','=','brand_category.cate_id')->select('events.*', 'brand.name')->where('events.active', 'Y')->whereNull('categories.name');
      }
    }

    public function scopeEventLocation($query, $location)
    {
      return $this->whereHas('location', function($query) use ($location)
      {
        $query->where('id', '=', $location);
      });
    }

    public function scopeEventLatLon($query, $lat, $lon)
    {
      return $this->whereHas('branch', function($query) use ($lat, $lon)
      {
        $query->where('lat', '=', $lat)->where('lon', '=', $lon);
      });
    }

    public function scopeEventBranch($query, $branch)
    {
      return $this->whereHas('branch', function($query) use ($branch)
      {
        $query->where('id', '=', $branch);
      });
    }

    public function scopeEventGallery($query, $image)
    {
      return $this->whereHas('gallery', function($query) use ($image)
      {
        $query->where('name', '=', $image);
      });
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }

    public function socialPost()
    {
        return $this->hasMany('App\SocialPost');
    }

    public function tags()
    {
      return $this->belongsToMany('App\Tag')
                  ->withTimestamps(); //update created app, updated app relationship table
    }

    public function category()
    {
      return $this->belongsToMany('App\Category', 'event_category', 'event_id', 'cate_id')
                  ->withTimestamps(); //update created app, updated app relationship table
    }

    public function gallery()
    {
      return $this->belongsToMany('App\Gallery')
                  ->withTimestamps(); //update created app, updated app relationship table
    }

    public function location()
    {
      return $this->belongsToMany('App\Location')
                  ->withTimestamps(); //update created app, updated app relationship table
    }

    public function branch()
    {
      return $this->belongsToMany('App\Branch', 'event_branch', 'event_id')
                  ->withTimestamps(); //update created app, updated app relationship table
    }
}
