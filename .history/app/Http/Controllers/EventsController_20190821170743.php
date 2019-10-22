<?php

namespace App\Http\Controllers;

use Cache;
use Redirect;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;

use Auth;
use App\Brand;
use App\Event;
use App\Category;
use App\Tag;
use App\Branch;
use App\Gallery;
use App\Location;
use App\SocialPost;
use Facebook;
use Twitter;
use Session;
//use GlideImage;

use GuzzleHttp\Client;

use Request as Response;

class EventsController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth', ['except' => ['index', 'search', 'show', 'desc_upload', 'locations', 'removefile', 'branch', 'reindex', 'show2']]);
  }

  function string_friendly($string)
  {
    $string = preg_replace("`\[.*\]`U","",$string);
    $string = preg_replace('`&(amp;)?#?[a-z0-9]+;`i','-',$string);
    $string = str_replace('%', '-percent', $string);
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = preg_replace("`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i","\\1", $string);
    $string = strtolower(preg_replace(array("`[^a-z0-9ก-๙เ-า]`i","`[-]+`"), "-", $string));
    return $string;
  }

  public function check_env()
  {
    echo env('TWITTER_ACCESS_TOKEN_SECRET');
  }

  function get_google($longUrl)
  {
    //This is the URL you want to shorten
    $apiKey = 'AIzaSyA34vD_CyNz2VPnHVyeX8wc0MvQJJZBid8';
    //Get API key from : http://code.google.com/apis/console/

    $postData = array('longUrl' => $longUrl, 'key' => $apiKey);
    $jsonData = json_encode($postData);

    $curlObj = curl_init();

    curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url?key='.$apiKey);
    curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curlObj, CURLOPT_HEADER, 0);
    curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
    curl_setopt($curlObj, CURLOPT_POST, 1);
    curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);

    $response = curl_exec($curlObj);

    //change the response json string to object
    $json = json_decode($response);
    curl_close($curlObj);
    return $json->id;
  }

  public function post_social($event_id=0)
  {
    $role_id = Auth::user()->role_id;
    $event = Event::find($event_id);

    $fb = new Facebook\Facebook([
      'app_id' => env('FACEBOOK_APP_KEY'),
      'app_secret' => env('FACEBOOK_APP_SECRET'),
      'default_graph_version' => 'v2.6',
    ]);

    $default_page_id = env('FACEBOOK_WLP_PAGE_ID');

    if($role_id == 2) {
      $msg_body = array(
        'message' => $event->facebook_title,
        'url' => url('/' . $event->image),
        //'url' => 'http://welovepro.com/images/events/2016-07-13/20160713-113715-jubilee.jpg',
        'access_token' => env('FACEBOOK_WLP_LONGLIVE_TOKEN')
      );

      try {
           $postResult = $fb->post($default_page_id . '/photos', $msg_body);
           $post_id = json_decode($postResult->getBody(), true)['id'];
           $social = SocialPost::firstOrCreate(array('social' => 'facebook','event_id' => $event_id, 'page_id' => $default_page_id, 'post_id' => $post_id, 'published_at' => date('Y-m-d')))->id;

       } catch (FacebookApiException $e) {
           echo $e->getMessage();
       }

      try {
        list($twitter_title, $full_url) = explode('http', $event->twitter_title);
        $short_url = $this->get_google($full_url); //short url
        //$short_url = $this->get_google('http://www.welovepro.com/promotion-dak-galbi-groupshot-50-off-add-on-menu-july-aug-2016');

        $uploaded_media = Twitter::uploadMedia(['media' => file_get_contents(url('/' . $event->image))]);
        //$uploaded_media = Twitter::uploadMedia(['media' => file_get_contents('http://welovepro.com/images/events/2016-07-13/20160713-113715-jubilee.jpg')]);
        $response = Twitter::postTweet(['status' => "{$twitter_title} {$short_url}", 'media_ids' => $uploaded_media->media_id_string]);
        $social = SocialPost::firstOrCreate(array('social' => 'twitter','event_id' => $event_id, 'page_id' => 'welovepro', 'post_id' => $response->id, 'published_at' => date('Y-m-d')))->id;
       } catch (Exception $e) {
          dd(Twitter::logs());
       }

       //echo '<pre>';
       //print_r($response);

       //dd($response);

       /*
       list($twitter_title, $full_url) = explode('http', $event->twitter_title);
       $short_url = $this->get_googl($full_url); //short url

       $uploaded_media = Twitter::uploadMedia(['media' => file_get_contents(url('/' . $event->image))]);
       //$uploaded_media = Twitter::uploadMedia(['media' => file_get_contents('http://welovepro.com/images/events/2016-07-13/20160713-113715-jubilee.jpg')]);
       Twitter::postTweet(['status' => "{$twitter_title} {$short_url}", 'media_ids' => $uploaded_media->media_id_string]);
       */

    } else { //brand post
      if($event->brand->social){
        foreach($event->brand->social->where('social', 'facebook')->all() as $page){

          $msg_body = array(
            'message' => $event->facebook_title,
            'url' => url('/' . $event->image),
            //'url' => 'http://welovepro.com/images/events/2016-07-13/20160713-113715-jubilee.jpg',
            'access_token' => $page->page_token
          );

          try {
               $postResult = $fb->post($page->social_id . '/photos', $msg_body);
               $post_id = json_decode($postResult->getBody(), true)['id'];

               $social = SocialPost::firstOrCreate(array('social' => 'facebook','event_id' => $event_id, 'page_id' => $page->social_id, 'post_id' => $post_id, 'published_at' => date('Y-m-d')))->id;

           } catch (FacebookApiException $e) {
               echo $e->getMessage();
           }

        } //end facebook page brand

        foreach($event->brand->social->where('social', 'twitter')->all() as $user){
          $user_token = json_decode($user->token, true);
          $oauth_request_token = $user_token['oauth_token'];
          $oauth_request_token_secret = $user_token['oauth_token_secret'];
          $request_token = array(
              'token'  => $oauth_request_token,
              'secret' => $oauth_request_token_secret,
          );

          Twitter::reconfig($request_token);

          try {
            list($twitter_title, $full_url) = explode('http', $event->twitter_title);
            $short_url = $this->get_google($full_url); //short url
            //$short_url = $this->get_google('http://www.promotiontoyou.com/2016/07/promotion-peak-warehouse-sale-up-to-80-off-july-2016');

            $uploaded_media = Twitter::uploadMedia(['media' => file_get_contents(url('/' . $event->image))]);
            //$uploaded_media = Twitter::uploadMedia(['media' => file_get_contents('http://www.promotiontoyou.com/wp-content/uploads/2016/07/Promotion-Peak-Warehouse-Sale-up-to-80-Off-July.2016.png')]);
            $response = Twitter::postTweet(['status' => "{$twitter_title} {$short_url}", 'media_ids' => $uploaded_media->media_id_string]);
            $social = SocialPost::firstOrCreate(array('social' => 'twitter','event_id' => $event_id, 'page_id' => $user->name, 'post_id' => $response->id, 'published_at' => date('Y-m-d')))->id;
          } catch (Exception $e) {
              dd(Twitter::logs());
          }

        } //end twitter user brand
      } //end event brand
    } //end user role
    return true;
  }

  function twitter_reconfig()
  {
    $event = Event::find('8049');
    $event_id = '8049';

    foreach($event->brand->social->where('social', 'twitter')->all() as $user){
      $user_token = json_decode($user->token, true);
      echo 'auth => ' . $user_token['oauth_token'] . '<br />';
      echo 'secret => ' . $user_token['oauth_token_secret'];

      //dd(json_decode($user->token));
      //exit;

      $oauth_request_token = $user_token['oauth_token'];
      $oauth_request_token_secret = $user_token['oauth_token_secret'];
      $request_token = array(
          'token'  => $oauth_request_token,
          'secret' => $oauth_request_token_secret,
      );

      Twitter::reconfig($request_token);

      try {
        list($twitter_title, $full_url) = explode('http', $event->twitter_title);
        //$short_url = $this->get_google($full_url); //short url
        $short_url = $this->get_google('http://www.promotiontoyou.com/2016/07/promotion-peak-warehouse-sale-up-to-80-off-july-2016');

        //$uploaded_media = Twitter::uploadMedia(['media' => file_get_contents(url('/' . $event->image))]);
        $uploaded_media = Twitter::uploadMedia(['media' => file_get_contents('http://www.promotiontoyou.com/wp-content/uploads/2016/07/Promotion-Peak-Warehouse-Sale-up-to-80-Off-July.2016.png')]);
        $response = Twitter::postTweet(['status' => "{$twitter_title} {$short_url}", 'media_ids' => $uploaded_media->media_id_string]);
        $social = SocialPost::firstOrCreate(array('social' => 'twitter','event_id' => $event_id, 'page_id' => $user->name, 'post_id' => $response->id, 'published_at' => date('Y-m-d')))->id;
       } catch (Exception $e) {
          dd(Twitter::logs());
       }
    } //end twitter user brand
  }

  public function client_request()
  {
      //$client = new GuzzleHttp\Client(['base_uri' => 'http://httpbin.org']);
      //dd($client);

      $client = new Client();
      /*$res = $client->request('POST', 'https://url_to_the_api', [
           'form_params' => [
               'client_id' => 'test_id',
               'secret' => 'test_secret',
           ]
       ]);*/

       //echo env('FACEBOOK_APP_KEY');
       //$res = $client->get('https://api.github.com/user', ['auth' =>  ['user', 'password']]);
       //echo $res->getStatusCode(); // 200
       //echo $res->getBody(); // { "type": "User", ....

       //echo '=> '. Auth::user()->role_id;
       //exit;
  }

  public function reindex()
  {
    //ini_set('max_execution_time', 300); //300 seconds = 5 minutes
    set_time_limit(0);
    $event = new Event;
    //$event->shouldIndex();
    $event->reIndex('App\Event --relations');
    //Queue::push('Iverberk\Larasearch\Jobs\ReindexJob', $this->findAffectedModels($event));
    echo 'OK >>';
  }

  /**
  * Search Test
  */
  public function search($type="promotion", $keywords='welovepro')
  {
    //ini_set('max_execution_time', 300); //300 seconds = 5 minutes
    //set_time_limit(0);
    //$event = new Event;
    //$event->reIndex('App\Event --relations');
    //$event->shouldIndex();

    //Artisan::call('larasearch:reindex App\Event --relations');
    //exit;

    //$brand = new Brand;
    //$brand->reIndex();

    if($type == 'promotion'){
      $results = Event::search(trim($keywords), [
          'fields' => ['title', 'description', 'branch.name' => 'text_start', 'branch.location' => 'text_start'],
          'select' => ['title', 'image', 'url_slug', 'brief', 'active', 'branch.name', 'branch.location', 'branch.lat', 'branch.lon'],
          'highlight' => true,
          //'suggest' => true,
          //'sort' => [['created_at' => 'desc'],'_score'],
          'sort' => [['published_at' => 'asc'], '_score'],
          /*'filter' => ['active' => 'Y'],
          'filter' => [
              'bool' => [
                  'should' => [
                      'term' => ['active' => 'Y']
                  ]
              ]
          ]*/
      ])->getResults();
    } else {
        $results = Brand::search(trim($keywords), [
            'autocomplete' => true,
            'highlight' => true,
        ])->getResults();
    }

    //echo '<pre>';
    //print_r($results);
    //exit;

    $arr_response = array();
    $arr_location = array();
    $arr_brand = array();
    $arr_index = array();
    foreach($results as $result){
      if($type == 'promotion'){
        $fields = $result->getFields();
        $arr_branch = '';
        if(isset($fields['branch.name'])){
          $arr_branch = $fields['branch.name'];
        }
        $arr_data = array('title' => $fields['title'][0], 'image' => '/img/' . $fields['image'][0], 'url_slug' => $fields['url_slug'][0], 'brief' => $fields['brief'][0]);
        array_push($arr_response, $arr_data);
        $highlights = $result->getHighlights(['branch.name']);
        if($highlights){
          foreach($highlights as $highlight){
              foreach($highlight as $value){
                $name = strip_tags($value);
                $branch_index = array_search($name, $arr_branch);
                if($branch_index !== false){
                  if(in_array($name, $arr_index) == false){
                    $arr_map = array('name' => $name, 'lat' => $fields['branch.lat'][$branch_index], 'lon' => $fields['branch.lon'][$branch_index]);
                    array_push($arr_location, $arr_map);
                    array_push($arr_index, $name);
                  }
                }
              }
          }
        }
      } else {
        $category_name = 'ไม่ระบุหมวดหมู่';
        $category_slug = 'unknow';
        $cate = Brand::find($result->id)->category->first();
        if($cate){
          $category_name = $cate->name;
          $category_slug = $cate->category;
        }
        $arr_data = array('name' => $result->name, 'logo_image' => $result->logo_image, 'url_slug' => $result->url_slug, 'slogan' => $result->slogan, 'category' => $category_name, 'category_slug' => $category_slug);
        array_push($arr_brand, $arr_data);
      }
    }

    //echo '<pre>';
    //print_r($arr_brand);
    //exit;

    echo json_encode(array('event' => $arr_response, 'map' => $arr_location, 'brand' => $arr_brand));
    exit;
  }

  public function index(Request $request)
  {
    $paginate = 10;
    $events = Event::published()->active()->orderBy('events.created_at', 'desc')->paginate($paginate);

    $more_page = $events->hasMorePages();
    $total_page = $events->total();

    //dd($events);

    return view('events.list', compact('events', 'more_page', 'total_page', 'paginate'));
  }

  public function create()
  {
      $user_id = Auth::user()->id;
      $role_id = Auth::user()->role_id;

      if($role_id == 4){ //brand
        $brands = Brand::select('id', 'name')->where('user_id', $user_id)->get();
      } elseif($role_id < 4) { //manager, admin
        $brands = Brand::select('id', 'name')->get();
      }

      if($brands->count() == 1){
        $branch = Branch::brandList($brands->first()->id)->get();
      } else {
        $branch = array();
      }

      $brand_category = $brands->first()->category_list;

      //dd($brand_category);
      //exit;

      return view('events.create', compact('brands', 'branch', 'brand_category', 'role_id'));
  }

  public function store(EventRequest $request)
  {
    //ini_set('max_execution_time', 300); //300 seconds = 5 minutes
    //set_time_limit(0);
    $event = new Event($request->all());

    //image
    if($request->hasFile('image')){
      $image_filename = $request->file('image')->getClientOriginalName();
      $file_name = pathinfo($image_filename, PATHINFO_FILENAME); // name
      $extension = pathinfo($image_filename, PATHINFO_EXTENSION); // extension
      $image_name = date('Ymd-His-').str_slug($file_name) . '.' . $extension;
      $public_path = 'images/events/' . date('Y-m-d') . '/';
      $destination = base_path() . '/public/' . $public_path;
      $request->file('image')->move($destination, $image_name); //move file to destination
      $event->image = $public_path . $image_name; //set article image name
    }

    //published
    if($request->input('published_now')){
      $event->published_at = $request->input('published_now');
    }

    //url slug
    $url_slug = str_slug($request->input('url_slug'));
    $base_slug = $url_slug;

    $i=1; $dup=1;
    do {
      $slug = Event::firstOrNew(array('url_slug' => $base_slug));
      if($slug->exists){
        $base_slug = $url_slug . '-' . $i++;
      } else {
        $dup=0;
      }
    } while($dup==1);
    $event->url_slug = $base_slug;

    //brand
    $event->brand_id = $request->input('brand'); //event brand
    $event_id = Auth::user()->events()->save($event)->id; //user id

    //category
    $categoryId = $request->input('category');
    if(!empty($categoryId)){
       $event->category()->sync($categoryId);
    }

    //branch
    $branchId = $request->input('branch');
    if(!empty($branchId)){
       $event->branch()->sync($branchId);
    }

    //tags
    $tagsId = $request->input('tag_list');
    if(!empty($tagsId)){
       $tag_list = explode(',', $tagsId);
       $tags = array();
       foreach($tag_list as $name)
       {
         $tag = $this->string_friendly($name);
         $tags[] = Tag::firstOrCreate(array('name' => $name, 'tag' => $tag))->id;
       }
       $event->tags()->sync($tags);
    }

    //gallery
    $gallery = $request->file('gallery');
    $success = 0;
    $error = 0;
    $file_index = 0;
    if($gallery){
      $images = array();
      foreach($gallery as $file){
         $image_filename = $file->getClientOriginalName();
         $file_name = pathinfo($image_filename, PATHINFO_FILENAME); // name
         $extension = pathinfo($image_filename, PATHINFO_EXTENSION); // extension
         $image_name = date('Ymd-His-').str_slug($file_name) . '.' . $extension;
         $public_path = 'images/events/'. date('Y-m-d') .'/gallery/'. $event_id . '/';
         $destination = base_path() . '/public/' . $public_path;
         $upload_success = $file->move($destination, $image_name); //move file to destination
         if( $upload_success ) {
            $success++;
            $image = $destination;
            $images[] = Gallery::firstOrCreate(array('name' => $image_name, 'image' => $public_path . $image_name))->id;
          } else {
            $error++;
          }
          $file_index++;
      }
      $event->gallery()->sync($images);
    }

    //location
    $location_name = $request->input('event_location');
    $location_lat = $request->input('location_lat');
    $location_lon = $request->input('location_lon');
    $location_zoom = $request->input('location_zoom');

    if($location_name != '' && $location_lat != '' && $location_lon != ''){
      $location = array();
      $location[] = Location::firstOrCreate(array('name' => $location_name, 'lat' => $location_lat, 'lon' => $location_lon, 'zoom' => $location_zoom))->id;
      $event->location()->sync($location);
    }

    //$event->reIndex('App\Event --relations'); //reindex search

    if($event->id > 0){
      //hide 2016-06-13, 1714
      //$pageToken = Session::get('pageTokenTest');
      //$this->facebook_post($pageToken);
      //exit;

      if($request->input('social_post') == 'Y')
         $this->post_social($event->id);

      return Response::json('success', array(
                  'status' => 'success',
                  'event_id'   => $event->id
              ));
    }
  }

  function facebook_post($pageToken=null)
  {
    # /js-login.php
    $fb = new Facebook\Facebook([
      'app_id' => '586408658176811',
      'app_secret' => '2b75dba58fc378a00b4858afc7866aed',
      'default_graph_version' => 'v2.6',
    ]);

    $helper = $fb->getJavaScriptHelper();

    //373634482682319
    try {
      $accessToken = $helper->getAccessToken();
      //posts message on page statues
      //$pageToken = $request->input('access_token');
      $pageToken = $pageToken; //from brand session fix
      echo 'page token => ' . $pageToken . '<br />';
      $msg_body = array(
        'message' => 'Test Facebook Message, Promotion !!',
        'access_token' => (string) $pageToken
      );
      try {
           $postResult = $fb->post('192272534234138/feed', $msg_body );
       } catch (FacebookApiException $e) {
           echo $e->getMessage();
       }
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }

    if (! isset($accessToken)) {
      echo 'No cookie set or no OAuth data could be obtained from cookie.';
      exit;
    }

    // Logged in
    echo '<h3>Access Token</h3>';
    var_dump($accessToken->getValue());

    $_SESSION['fb_access_token'] = (string) $accessToken;

    return true;
  }

  /**
  * Display the speified resource.
  *
  *@param int $id
  *@return Response
  */
  public function show($slug)
  {
      //echo 'slug => ' . rawurlencode($slug) . '<br />';
      //exit;

      $slug = rawurlencode($slug);
      if(is_numeric($slug)) {
          echo 'numeric slug';
          exit;

          $event = Event::findOrFail($slug);
          return redirect()->action('EventsController@show', ['slug' => $event->url_slug]);
      }

      //echo 'not numeric slug';
      //exit;

      $event = Cache::remember('_' . $slug, 1440, function() use ($slug) { //1440 Min(24 Hr.)
        return Event::where('url_slug', $slug)->first();
      });

      if(!$event){
        //return redirect('/');
        //abort(404);

        $events = Event::published()->active()->orderBy('events.created_at', 'desc')->limit(10)->get();
        //dd($events);
        return \Response::view('errors.404', array('url' => Response::url(), 'events' => $events, 'msg' => 'ไม่พบข้อมูลที่คุณต้องการ'), 404); //\Response is native response, Reponse is make from Request
      }

      $branchs = array();
      $tags = array();

      foreach($event->branch->all() as $index => $branch){
        $branchs[] = '<span><i class="pg-map hint-text-9" aria-hidden="true"></i></span>' . link_to('#' . $branch->name, $branch->name, array('title' => $branch->name, 'data-index' => $branch->lat.','.$branch->lon.','.$branch->name, 'class' => 'place'));
      }

      $tags_relate = array();
      foreach($event->tags->all() as $index => $tag){
        array_push($tags_relate, $tag->tag);
        $tags[] = '<span><i class="fa fa-tag fa-flip-horizontal hint-text-8 m-t-10" aria-hidden="true"></i></span> ' . link_to('/tag/' . $tag->tag, $tag->name, array('title' => $tag->name, 'data-index' => $index, 'class' => 'tag'));
      }

      $event_id = $event->id;
      $event_title = $event->title;
      $cate_id = isset($event->category->first()->id)?$event->category->first()->id:'';
      $brand_cate_id = isset($event->brand->category->first()->id)?$event->brand->category->first()->id:'';
      $relates = array();

      //echo '<pre>';
      //print_r($tags_relate);
      //echo '</pre>';
      //echo 'cate id => ' . $brand_cate_id . '<br />';

      if($event_id){
        //$relates = Event::published()->active()->relateThis($event_id, $brand_cate_id, $tags_relate)->skip(0)->take(6)->get();
        $relates = Cache::remember('_relate_' . $slug, 1440, function() use ($event_id, $cate_id, $brand_cate_id, $tags_relate) { //1440 Min(24 Hr.)
          //echo $event_id . '=>' . $cate_id . '=>'. $brand_cate_id;
          //print_r($tags_relate);
          //exit;
          return Event::relateThis($event_id, $cate_id, $brand_cate_id, $tags_relate)->published()->active()->skip(0)->take(6)->get();
        });
      }

      //echo count($relates);
      //exit;

      //echo '<pre>';
      //print_r($relates);
      //echo '</pre>';
      //exit;

      return view('events.show', compact('event', 'branchs', 'locations', 'tags', 'relates', 'event_title'));
  }

  /**
  * Display the speified resource.
  *
  *@param int $id
  *@return Response
  */
  public function show2($slug)
  {
      //echo 'slug => ' . rawurlencode($slug) . '<br />';
      //exit;
      $slug = rawurlencode($slug);
      if(is_numeric($slug)) {
          $event = Event::findOrFail($slug);
          return redirect()->action('EventsController@show', ['slug' => $event->url_slug]);
      }

      $event = Cache::remember('_' . $slug, 1440, function() use ($slug) { //1440 Min(24 Hr.)
        return Event::where('url_slug', $slug)->first();
      });

      if(!$event)
        return redirect('/');

      $branchs = array();
      $tags = array();

      foreach($event->branch->all() as $index => $branch){
        $branchs[] = '<span><i class="pg-map hint-text-9" aria-hidden="true"></i></span>' . link_to('#' . $branch->name, $branch->name, array('title' => $branch->name, 'data-index' => $branch->lat.','.$branch->lon.','.$branch->name, 'class' => 'place'));
      }

      $tags_relate = array();
      foreach($event->tags->all() as $index => $tag){
        array_push($tags_relate, $tag->tag);
        $tags[] = '<span><i class="fa fa-tag fa-flip-horizontal hint-text-8 m-t-10" aria-hidden="true"></i></span> ' . link_to('/tag/' . $tag->tag, $tag->name, array('title' => $tag->name, 'data-index' => $index, 'class' => 'tag'));
      }

      $event_id = $event->id;
      $event_title = $event->title;
      $cate_id = isset($event->category->first()->id)?$event->category->first()->id:'';
      $brand_cate_id = isset($event->brand->category->first()->id)?$event->brand->category->first()->id:'';
      $relates = array();

      //echo '<pre>';
      //print_r($tags_relate);
      //echo '</pre>';
      //echo 'cate id => ' . $brand_cate_id . '<br />';

      if($event_id){
        //$relates = Event::published()->active()->relateThis($event_id, $brand_cate_id, $tags_relate)->skip(0)->take(6)->get();
        $relates = Cache::remember('_relate_' . $slug, 1440, function() use ($event_id, $cate_id, $brand_cate_id, $tags_relate) { //1440 Min(24 Hr.)
          //echo $event_id . '=>' . $cate_id . '=>'. $brand_cate_id;
          //print_r($tags_relate);
          //exit;
          return Event::published()->active()->relateThis($event_id, $cate_id, $brand_cate_id, $tags_relate)->skip(0)->take(6)->get();
        });
      }

      //echo count($relates);
      //exit;

      //echo '<pre>';
      //print_r($relates);
      //echo '</pre>';
      //exit;

      return view('events.show2', compact('event', 'branchs', 'locations', 'tags', 'relates', 'event_title'));
  }

  /**
  * Show the form for editing the specified resource.
  *
  *@param int $id
  *@return Response
  */
  public function edit($id)
  {
    $user_id = Auth::user()->id;
    $role_id = Auth::user()->role_id;

    if($role_id == 4){ //brand
      $brands = Brand::select('id', 'name')->where('user_id', $user_id)->get();
      $arr_brand = array();
      foreach($brands as $brand){
        array_push($arr_brand, $brand->id);
      }

      $event = Event::whereIn('brand_id', $arr_brand)->where('id', $id)->first();
      if($event->count() < 1){
        abort(401);
        exit;
      }

    } elseif($role_id < 4){ // manager, admin
      $brands = Brand::select('id', 'name')->get();
      $event = Event::find($id);
    }

    $branch = array();
    if($brands->count() == 1){
      $branch = Branch::brandList($brands->first()->id)->get();
    }
    //dd($event->first()->brand_id);
    $brand_active = Brand::find($event->brand_id);
    $branch = $brand_active->branch_list; //default null

    $obj = array();
    $result = array();
    foreach($event->gallery_list as $file){
      $fileinfo = base_path() .'/public/'. $file;
      $filename = pathinfo($fileinfo)['basename'];
      $filesize = filesize($fileinfo);

      $obj['name'] = $filename; //get the filename in array
      $obj['size'] = $filesize; //get the flesize in array
      $obj['fileinfo'] = '/'.$file; //get the fileinfo in array
      $result[] = $obj; // copy it to another array
    }
    $gallery =  json_encode($result);

    $location = $event->location_first;

    $string_tag = implode(',', $event->tag_list);
    $brand_category = $brands->first()->category_list;

    if(empty($event))
      abort(404);

    return  view('events.edit', compact('event', 'brand_category', 'brands', 'branch', 'string_tag', 'gallery', 'location', 'role_id'));
  }

  /**
  * Update the specified resource in storage.
  *
  *@param int $id
  *@return Response
  */
  public function update($id, EventRequest $request)
  {
    $event = Event::find($id);
    $input = $request->all(); /* Request all inputs */
    $event_id = $request->input('event_edit_id');

    //image
    if($request->hasFile('image')){
      $base_hash = '';
      if(is_file(base_path() . '/public/' . $event->image)){
          $base_hash = md5_file(base_path() . '/public/' . $event->image);
      }
      $image_hash = md5_file($request->file('image')->getPathName());

      if($base_hash != $image_hash){
        $image_filename = $request->file('image')->getClientOriginalName();
        $file_name = pathinfo($image_filename, PATHINFO_FILENAME); // name
        $extension = pathinfo($image_filename, PATHINFO_EXTENSION); // extension
        $image_name = date('Ymd-His-').str_slug($file_name) . '.' . $extension;
        $public_path = 'images/events/' . date('Y-m-d') . '/';
        $destination = base_path() . '/public/' . $public_path;
        $request->file('image')->move($destination, $image_name); //move file to destination
        $input['image'] = $public_path . $image_name; //set article image name
      } else {
        $input['image'] = $event->image;
      }
    } else {
      $input['image'] = $event->image;
    }

    //url slug
    $url_slug = str_slug($request->input('url_slug'));
    $base_slug = $url_slug;

    $i=1; $dup=1;
    do {
      $slug = Event::where('url_slug', '=', $base_slug)->where('id', '!=', $event_id)->first();
      if($slug){
        $base_slug = $url_slug . '-' . $i++;
      } else {
        $dup=0;
      }
    } while($dup==1);
    $input['url_slug'] = $base_slug;

    //category
    $categoryId = $request->input('category');
    if(!empty($categoryId)){
       $event->category()->sync($categoryId);
    }

    //brand
    $input['brand_id'] = $request->input('brand');

    //branch
    $branchId = $request->input('branch');
    if(!empty($branchId)){
       $event->branch()->sync($branchId);
    }

    //tags
    $tagsId = $request->input('tag_list');
    if(!empty($tagsId)){
       $tag_list = explode(',', $tagsId);
       $tags = array();
       foreach($tag_list as $name)
       {
         $tag = $this->string_friendly($name);
         $tags[] = Tag::firstOrCreate(array('name' => $name, 'tag' => $tag))->id;
       }
       $event->tags()->sync($tags);
    }

    //gallery
    $gallery = $request->file('gallery');

    $success = 0;
    $error = 0;
    $file_index = 0;
    if($gallery){
      foreach($gallery as $file){
         $image_filename = $file->getClientOriginalName();
         $file_name = pathinfo($image_filename, PATHINFO_FILENAME); // name
         $extension = pathinfo($image_filename, PATHINFO_EXTENSION); // extension
         $image_name = date('Ymd-His-').str_slug($file_name) . '.' . $extension;
         $public_path = 'images/events/'. date('Y-m-d') .'/gallery/'. $event_id . '/';
         $destination = base_path() . '/public/' . $public_path;
         $upload_success = $file->move($destination, $image_name); //move file to destination
         if( $upload_success ) {
            $success++;
            $image = $destination;
            $images_id = Gallery::firstOrCreate(array('name' => $image_name, 'image' => $public_path . $image_name))->id;
            $event_gallery = $event->gallery()->attach($images_id);
          } else {
            $error++;
          }
          $file_index++;
      }
    }

    //location
    $location_name = $request->input('event_location');
    $location_lat = $request->input('location_lat');
    $location_lon = $request->input('location_lon');
    $location_zoom = $request->input('location_zoom');

    if($location_name != '' && $location_lat != '' && $location_lon != ''){
      $location = array();
      $location[] = Location::firstOrCreate(array('name' => $location_name, 'lat' => $location_lat, 'lon' => $location_lon, 'zoom' => $location_zoom))->id;
      $event->location()->sync($location);
    }

    $event->fill($input);
    $event->save();

    if($event->id > 0){
      return Response::json('success', array(
                  'status' => 'success',
                  'event_id'   => $event->id
              ));
    }
  }

  public function _locations($event)
  {
    $event = Event::findOrFail($event);
    echo json_encode($event->branch->all());
  }

  //public function locations($id)
  public function locations($slug)
  {
    $event_locations = array();
    $event_brand = array();
      //$event = Event::where('id', $id)->first();
      $event = Cache::remember('_promotion_' . $slug, 1440, function() use ($slug) {
        //return $event = Event::where('url_slug', $slug)->first();
        return Event::where('url_slug', $slug)->first();
      });

      $event_slug_id = $event->id;

      if($event->brand->count() > 0){
        $cate_name = 'ไม่ระบุหมวดหมู่';
        $cate_slug = 'unknow';
        if($event->brand->category->count() > 0){
          $cate_name = $event->brand->category->first()->name;
          $cate_slug = $event->brand->category->first()->category;
        }
        $event_brand = array('name' => $event->brand->name, 'image' => $event->brand->logo_image, 'url_slug' => $event->brand->url_slug, 'category' => $cate_name, 'category_slug' => $cate_slug);
      }

      if($event->branch->count() > 0){
        foreach($event->branch->all() as $branch){
          if($branch->events->count() == 1){
              $event_locations[$branch->lat .','. $branch->lon .','. $branch->name] = array();
          }
          $events_branch = Event::eventBranch($branch->id)->published()->active()->noExpire()->orderBy('events.created_at', 'desc')->get(); //check expire
          if($events_branch->count() < 1){
            $event_locations[$branch->lat .','. $branch->lon .','. $branch->name] = array();
            continue;
          }

          $cate_name = 'ไม่ระบุ หมวดหมู่';
          $cate_slug = 'unknow';

          foreach($events_branch as $event){
            if($event->category->count() > 0){
              $cate_name = $event->category->first()->name;
              $cate_slug = $event->category->first()->category;
            }

            //if($event->id != $id){ //without self
            if($event->id != $event_slug_id){
              if(!array_key_exists($branch->lat .','. $branch->lon . ',' . $branch->name, $event_locations)){
                $event_locations[$branch->lat .','. $branch->lon .','. $branch->name] = array(array('title' => $event->title, 'slug' => $event->url_slug, 'brand' => $event->brand->name, 'brand_slug' => $event->brand->url_slug, 'brand_logo' => $event->brand->logo_image,'image' => $event->image, 'category' => $cate_name, 'category_slug' => $cate_slug, 'start_date_thai' => $event->start_date_thai, 'end_date_thai' => $event->end_date_thai));
              } else {
                array_push($event_locations[$branch->lat .','. $branch->lon .','. $branch->name], array('title' => $event->title, 'slug' => $event->url_slug, 'brand' => $event->brand->name, 'brand_slug' => $event->brand->url_slug, 'brand_logo' => $event->brand->logo_image, 'image' => $event->image, 'category' => $cate_name, 'category_slug' => $cate_slug, 'start_date_thai' => $event->start_date_thai, 'end_date_thai' => $event->end_date_thai));
              }
            } else {
              if(!array_key_exists($branch->lat .','. $branch->lon . ',' . $branch->name, $event_locations)){
                $event_locations[$branch->lat .','. $branch->lon .','. $branch->name] = array();
              }
            }
          }
        }
      }

    echo json_encode(array('brand'=> $event_brand, 'locations' => $event_locations));
  }

  public function desc_upload()
  {
      if(Response::ajax() && Response::hasFile('file_upload')){
        $image_filename = Response::file('file_upload')->getClientOriginalName();
        $file_name = pathinfo($image_filename, PATHINFO_FILENAME); // name
        $extension = pathinfo($image_filename, PATHINFO_EXTENSION); // extension
        $image_name = date('Ymd-His-').str_slug($file_name) . '.' . $extension;
        $public_path = 'images/events/'. date('Y-m-d') .'/description/';
        $destination = base_path() . '/public/' . $public_path;
        $upload_success = Response::file('file_upload')->move($destination, $image_name); //move file to destination
        if( $upload_success ) {
          return '/'. $public_path . $image_name;
        } else {
          return false;
        }
      }

      return Response::json('success', 200);
  }

  /* remove file */
  public function removefile($id, $image)
  {
    $image = Gallery::select('id')->where('name', $image)->get();
    if($image->first()){
      $image_id = $image->first()->id;
      $deletedRows = Event::find($id)->gallery()->detach($image_id); // delete the relationships with Image (Pivot table) first.
    }
  }

  /**
  * Display the speified resource.
  *
  *@param int $id
  *@return Response
  */
  public function _branch(Request $request)
  {
    $id = $request->input('id');
    $brand = Brand::find($id);
    echo json_encode($brand->branch_list);
  }

  public function brand($id)
  {
    $brand = Brand::findOrFail($id);
    echo json_encode(array('branch' => $brand->branch_list, 'category' => $brand->category_list));
  }

}
