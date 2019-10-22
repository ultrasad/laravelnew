<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\BrandRequest;

use Auth;
use App\User;
use App\Event;
use App\Brand;
use App\Branch;
use App\Category;
use App\Social;

use Facebook;
//use Facebook\Authentication\AccessToken;
//use Facebook\FacebookSession;
//use Facebook\FacebookRequest;
//use Facebook\Entities\AccessToken;
//use Facebook\FacebookSDKException;

use Session;
//use App\Branch;
use Request as Response;

class BrandController extends Controller
{
  public function __construct()
  {
    //$this->middleware('auth', ['only' => ['create', 'store']]);
    $this->middleware('auth', ['except' => ['index', 'show', 'branch', 'category', 'locations']]);
  }

  /**
  * Display a list of the event.
  *
  *@return Response
  */
  public function index($slug='false')
  {
    //echo '=> ' . $brand;
    //$events = Event::published()->active()->eventBrand()->BrandId($brand_id)->orderBy('events.created_at', 'desc')->paginate(15);
    $paginate = 20;
    if($slug == 'false'){
      $brands = Brand::approved()->paginate($paginate);

      $more_page = $brands->hasMorePages();
      $total_page = $brands->total();

      return view('brand.main', compact('brands', 'more_page', 'total_page', 'paginate'));
    } else {
      $brand = Brand::where('url_slug', $slug)->first();
      $events = Event::select('events.*', 'events.url_slug as url_slug')->published()->active()->BrandSlug($slug)->orderBy('events.created_at', 'desc')->paginate($paginate);
      //dd($events);
      $more_page = $events->hasMorePages();
      $total_page = $events->total();

      return view('brand.index', compact('events', 'brand', 'more_page', 'total_page', 'paginate'));
    }
  }

  public function category($category='unknow')
  {
    //echo '=> ' . $category;
    $events = Event::published()->active()->brandCategoryList($category)->orderBy('events.updated_at', 'desc')->orderBy('events.created_at', 'desc')->paginate(15);

    //echo '<pre>';
    //print_r($events->count());
    //print_r($events->first()->brand->category->first()->name);
    //exit;

    if($events->count() < 1){
      //return redirect('/');
      $category_name = Category::nameCateId($category);
    } else {
      if($category == 'unknow'){
        $category_name = 'unknow';
      } else {
        //$category_name = $events->first()->category->where('category', $category)->first()->name;
        $category_name = $events->first()->brand->category->first()->name;
      }
    }

    return view('brand.category', compact('events', 'category_name'));
  }

  /**
  * Register New Brand.
  */
  public function register()
  {
    //echo 'register';
    $role_id = Auth::user()->role_id;
    $user_id = Auth::user()->id;
    $brands = array();
    if($role_id == 4){ //brand
      $brands = Brand::where('user_id', $user_id)->get();
    } elseif($role_id < 4) { //manager, admin
      $brands = Brand::all();
    }

    //$category = Category::select('name', 'id')->where('category_type', 'brand')->get();
    $category = Category::select('name', 'id')->get();
    return view('brand.register', compact('category', 'role_id', 'brands'));
  }

  public function lists()
  {
    $user_id = Auth::user()->id;
    $role_id = Auth::user()->role_id;
    $brands = array();
    if($role_id == 4){ //brand
      $brands = Brand::where('user_id', $user_id)->get();
    } elseif($role_id < 4) { //manager, admin
      $brands = Brand::orderBy('brand.updated_at', 'desc')->orderBy('brand.created_at', 'desc')->get();
    }

    return view('brand.lists', compact('brands', 'role_id'));
  }

  function facebook_token($brand='', $fbpage=array(), $update=false)
  {
    $fa_master = array();
    if($update == true){
      $brand = Brand::find($brand->id);
      $social = $brand->page_exists;
      //echo '<pre>';
      //print_r(array_values($social));
      //print_r($social);

      $fa_master = Social::pageExists($brand->id, $fbpage)->lists('id')->all();
      //echo '<pre>';
      //print_r($fa_master);

      //$social = $brand->page_exists->lists('social_id');
      $fbpage = array_diff($fbpage, array_keys($social)); //(keys)page_id from db

      //echo '<pre>';
      //print_r($fbpage);
    }

    if(count($fbpage) > 0){

      //echo 'count more than 0 >> ' . $brand->id . '<br />';
      $fb = new Facebook\Facebook([
        'app_id' => env('FACEBOOK_APP_KEY'),
        //'app_id' => '141016549272100',
        'app_secret' => env('FACEBOOK_APP_SECRET'),
        //'app_secret' => '302ab7af4dc97ec2179efad4e2131dc8',
        'default_graph_version' => 'v2.6',
      ]);

      $helper = $fb->getJavaScriptHelper();

      try {
        $accessToken = $helper->getAccessToken();
      } catch(Facebook\Exceptions\FacebookSDKException $e) {
        // There was an error communicating with Graph
        // Or there was a problem validating the signed request
        echo $e->getMessage();
        exit;
      }

      if ($accessToken) {
        // Logged in.
        $_SESSION['facebook_access_token'] = (string) $accessToken;
        //echo 'session token => ' . $_SESSION['facebook_access_token'] . '<br />';

        # v5
        $client = $fb->getOAuth2Client();

        try {
          // Returns a long-lived access token
          $longLivedAccessToken = $client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
          // There was an error communicating with Graph
          echo $e->getMessage();
          exit;
        }
      }

      if (isset($longLivedAccessToken)) {
        // Logged in.
        $_SESSION['facebook_longlived_token'] = (string) $longLivedAccessToken;

        //echo 'longLivedAccessToken >> <br />';
        //echo '<pre>';
        //print_r($longLivedAccessToken);
        //echo '</pre>';

        $response = $fb->get('/me/accounts', $longLivedAccessToken);
        $pageList = $response->getGraphEdge()->asArray();
        $pages = array();
        foreach ($pageList as $page) {
          $pageID = $page['id'];
          if(in_array($pageID, $fbpage)){
            $pageName = $page['name'];
            $pageAccessToken = $page['access_token'];
            //echo 'id => ' . $pageID . ', name => ' . $pageName . ', token => ' . $pageAccessToken . '</p>';

            $pages[] = Social::firstOrCreate(array('social' => 'facebook', 'social_id' => $pageID, 'name' => $pageName, 'token' => $accessToken, 'long_live_token' => $longLivedAccessToken, 'page_token' => $pageAccessToken))->id;

            /*if($pageID == '192272534234138'){
              $msg_body = array(
                'message' => 'Test Promotion User Message !!',
                'access_token' => (string) $pageAccessToken
              );
              try {
                   $postResult = $fb->post('192272534234138/feed', $msg_body);
               } catch (FacebookApiException $e) {
                   echo $e->getMessage();
               }
            } //check page post test
            */

          }
        }

        if($pages){
          $pages =  array_merge($fa_master, $pages);
          $brand->social()->sync($pages);
        }

      } //end access token

      //posts message on page statues
      /*$pageToken = $request->input('access_token');
      $msg_body = array(
        'message' => 'Test User Message !!',
        'access_token' => (string) $pageToken
      );
      try {
           $postResult = $fb->post('192272534234138/feed', $msg_body);
       } catch (FacebookApiException $e) {
           echo $e->getMessage();
       }*/

    }  else {//check count diff, update brand check
      if(count($fa_master) > 0){
        $brand->social()->sync($fa_master); //ease old page and not new
      }
    }
    return true;
  }

  public function store(BrandRequest $request)
  {
    $brand = new Brand($request->all());
    //echo '<pre>';
    //print_r($brand);
    //echo '</pre>';
    //exit;


    //echo '<pre>';
    //print_r($fbpage);
    //echo '</pre>';
    //echo 'break >>';
    //exit;

    //logo image
    if($request->hasFile('logo_image')){
      $image_filename = $request->file('logo_image')->getClientOriginalName();
      $file_name = pathinfo($image_filename, PATHINFO_FILENAME); // name
      $extension = pathinfo($image_filename, PATHINFO_EXTENSION); // extension
      $image_name = 'logo_'. date('Ymd-His-').str_slug($file_name) . '.' . $extension;
      $public_path = 'images/brand/';
      $destination = base_path() . '/public/' . $public_path;
      $request->file('logo_image')->move($destination, $image_name); //move file to destination
      $brand->logo_image = $public_path . $image_name; //set brand image name
    }

    //cover image
    if($request->hasFile('cover_image')){
      $image_filename = $request->file('cover_image')->getClientOriginalName();
      $file_name = pathinfo($image_filename, PATHINFO_FILENAME); // name
      $extension = pathinfo($image_filename, PATHINFO_EXTENSION); // extension
      $image_name = 'cover_'. date('Ymd-His-').str_slug($file_name) . '.' . $extension;
      $public_path = 'images/brand/';
      $destination = base_path() . '/public/' . $public_path;
      $request->file('cover_image')->move($destination, $image_name); //move file to destination
      $brand->cover_image = $public_path . $image_name; //set brand image name
    }

    //url slug
    $url_slug = str_slug($request->input('url_slug'));
    $base_slug = $url_slug;
    //echo 'base => ' . $base_slug;

    $i=1; $dup=1;
    do {
      $slug = Brand::firstOrNew(array('url_slug' => $base_slug));
      if($slug->exists){
        $base_slug = $url_slug . '-' . $i++;
      } else {
        $dup=0;
      }
    } while($dup==1);
    $brand->url_slug = $base_slug;

    $name = $request->input('name');
    $username = $request->input('username');
    $password = $request->input('password');
    $email = $request->input('email');
    if(!empty($username) && !empty($password)){
      $brand->user_id =  User::create(array('name' => $name,'username' => $username, 'password' => bcrypt($password), 'email' => !empty($email)?$email:NULL, 'role_id' => 4))->id;
    }

    $brand->save(); //brand insert

    //category
    $categoryId = $request->input('category');
    if(!empty($categoryId)){
       $brand->category()->sync($categoryId);
    }

    //branch
    $branchId = $request->input('branch');
    if(!empty($branchId)){
       $brand->branch()->sync($branchId);
    }

    //facebook
    $fbpage = $request->input('fbpage');
    if($fbpage){
      $this->facebook_token($brand, $fbpage);
    }

    //twitter
    $twuser = $request->input('twuser');
    if($twuser){
      $brand->social()->attach($twuser);
    }

    $brand->reIndex(); //reindex search

    if($brand->id > 0){
      return Response::json('success', array(
                  'status' => 'success',
                  'brand_id'   => $brand->id
              ));
    }
  }

  /**
  * Show the form for editing the specified resource.
  *
  *@param int $id
  *@return Response
  */
  public function edit($id)
  {
    $role_id = Auth::user()->role_id;
    $user_id = Auth::user()->id;

    $brands = array();
    if($role_id == 4){ //brand
      $brands = Brand::where('user_id', $user_id)->get();
    } elseif($role_id < 4) { //manager, admin
      $brands = Brand::all();
    }

    $brand = Brand::find($id);
    //$category = Category::select('name', 'id')->where('category_type', 'brand')->get();
    $category = Category::select('name', 'id')->get();
    $brand_category = isset($brand->category_list)?array_keys($brand->category_list):'';

    $facebook = $brand->social->all();

    $branchs = $brand->branch->all();

    //echo '<pre>';
    //print_r($branchs);
    //exit;

    if(empty($brand))
      abort(404);
    return  view('brand.edit', compact('brand', 'brand_category', 'facebook', 'branchs', 'brands', 'category', 'role_id'));
  }

  /**
  * Update the specified resource in storage.
  *
  *@param int $id
  *@return Response
  */
  public function update($id, BrandRequest $request)
  {
    $brand = Brand::find($id);
    $input = $request->all(); /* Request all inputs */
    $brand_id = $request->input('brand_edit_id');

    //logo image
    if($request->hasFile('logo_image')){
      $base_hash = '';
      if(is_file(base_path() . '/public/' . $brand->logo_image)){
        $base_hash = md5_file(base_path() . '/public/' . $brand->logo_image);
      }
      $image_hash = md5_file($request->file('logo_image')->getPathName());

      if($base_hash != $image_hash){
        $image_filename = $request->file('logo_image')->getClientOriginalName();
        $file_name = pathinfo($image_filename, PATHINFO_FILENAME); // name
        $extension = pathinfo($image_filename, PATHINFO_EXTENSION); // extension
        $image_name = 'logo_'. date('Ymd-His-').str_slug($file_name) . '.' . $extension;
        $public_path = 'images/brand/';
        $destination = base_path() . '/public/' . $public_path;
        $request->file('logo_image')->move($destination, $image_name); //move file to destination
        $input['logo_image'] = $public_path . $image_name; //set article image name
      } else {
        $input['logo_image'] = $brand->logo_image;
      }
    }

    //cover image
    if($request->hasFile('cover_image')){
      $base_hash = md5_file(base_path() . '/public/' . $brand->cover_image);
      $image_hash = md5_file($request->file('cover_image')->getPathName());

      if($base_hash != $image_hash){
        $image_filename = $request->file('cover_image')->getClientOriginalName();
        $file_name = pathinfo($image_filename, PATHINFO_FILENAME); // name
        $extension = pathinfo($image_filename, PATHINFO_EXTENSION); // extension
        $image_name = 'cover_'. date('Ymd-His-').str_slug($file_name) . '.' . $extension;
        $public_path = 'images/brand/';
        $destination = base_path() . '/public/' . $public_path;
        $request->file('cover_image')->move($destination, $image_name); //move file to destination
        $input['cover_image'] = $public_path . $image_name; //set article image name
      } else {
        $input['cover_image'] = $brand->cover_image;
      }
    }

    //url slug
    $url_slug = str_slug($request->input('url_slug'));
    $base_slug = $url_slug;

    $i=1; $dup=1;
    do {
      //$slug = Event::firstOrNew(array('url_slug' => $base_slug));
      $slug = Brand::where('url_slug', '=', $base_slug)->where('id', '!=', $brand_id)->first();
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
       $brand->category()->sync($categoryId);
    }

    //branch
    $branchId = $request->input('branch');
    if(!empty($branchId)){
       $brand->branch()->sync($branchId);
    }

    //facebook
    $fbpage = $request->input('fbpage');
    if($fbpage){
      $this->facebook_token($brand, $fbpage, $update=true);
    }

    $input['facebook'] = $request->input('facebook');
    $input['twitter'] = $request->input('twitter');
    $input['line_officail'] = $request->input('line_officail');
    $input['youtube'] = $request->input('youtube');

    $brand->fill($input);
    $brand->save();

    //echo 'brand id => ' . $brand->id;

    $email = $request->input('email');
    $password = $request->input('password');
    if(!empty($email) || !empty($password)){
      $user = User::find($brand->user->id);
      $user->email = $email;
      $user->password = bcrypt($password);
      $user->save();
      //$brand->user_id =  User::create(array('name' => $name,'username' => $username, 'password' => bcrypt($password), 'email' => !empty($email)?$email:NULL, 'role_id' => 4))->id;
    }

    $brand->reIndex(); //reindex search

    if($brand->id > 0){
      //hide, 2016-06-13 1716
      //$pageToken = $request->input('access_token');
      //Session::set('pageTokenTest', $pageToken);

      return Response::json('success', array(
                  'status' => 'success',
                  'brand_id'   => $brand->id
              ));
    }
  }

  public function facebook(Request $request)
  {

    # /js-login.php
    $fb = new Facebook\Facebook([
      'app_id' => env('FACEBOOK_APP_KEY', '141016549272100'),
      'app_secret' => env('FACEBOOK_APP_SECRET', '302ab7af4dc97ec2179efad4e2131dc8'),
      'default_graph_version' => 'v2.6',
    ]);

    $helper = $fb->getJavaScriptHelper();

    //373634482682319
    try {
      $accessToken = $helper->getAccessToken();
      //posts message on page statues
      $pageToken = $request->input('access_token');
      $msg_body = array(
        'message' => 'Test User Message !!',
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

    // User is logged in!
    // You can redirect them to a members-only page.
    //header('Location: https://example.com/members.php');

    $brand = new Brand($request->all());
    echo '=> ' . $request->input('title');
    echo '<pre>';
    print_r($brand);
  }

  public function branch(Request $request)
  {
    $id = $request->input('id');
    $brand = Brand::find($id);
    echo json_encode($brand->branch_list);
  }

  public function add_branch(Request $request)
  {
    //echo 'name => ' . $request->input('branch_name');
    // Getting all post data
    /*if($request->ajax()){
       echo 'name => ' . $request->json('branch_name');
      //echo '<pre>';
      //print_r($branch_name);
      //$data = $request->all();
      //print_r($data);die;
    }
    exit;*/

    $branch = new Branch;
    $branch->name = $request->json('branch_name');
    $branch->location = $request->json('branch_location');
    $branch->detail = $request->json('branch_detail');
    $branch->lat = $request->json('branch_lat');
    $branch->lon = $request->json('branch_lon');
    $branch->zoom = $request->json('branch_zoom');
    $branch->save();

    if($request->json('brand_id')){ //case event, brand exists and create new branch
      $brand = Brand::find($request->json('brand_id'));
      $brand->branch()->attach($branch->id);
      /*if($branch->id > 0){
        //echo json_encode(array('status' => 'success', 'branch_id' => $branch->id));
        return Response::json(array(
                    'status' => success,
                    'branch_id'   => $branch->id
                ));
      }*/
    }

    if($branch->id > 0){
      return Response::json('success', array(
                  'status' => 'success',
                  'branch_id'   => $branch->id
              ));
    }
  }

  public function locations($slug) //branch loation
  {
    $event_locations = array();
    $event_brand = array();
      //$event = Event::where('id', $id)->first();
      //$event = Cache::remember('Promotion_' . $slug, 1440, function() use ($slug) {
        //return $event = Event::where('url_slug', $slug)->first();
        //return Event::where('url_slug', $slug)->first();
      //});

      //$event_slug_id = $event->id;

      $brand = Brand::where('url_slug', $slug)->first();
      $cate_name = 'ไม่ระบุหมวดหมู่';
      $cate_slug = 'unknow';
      if($brand->category->count() > 0){
          $cate_name = $brand->category->first()->name;
          $cate_slug = $brand->category->first()->category;
      }
      $event_brand = array('name' => $brand->name, 'image' => $brand->logo_image, 'url_slug' => $brand->url_slug, 'category' => $cate_name, 'category_slug' => $cate_slug);


      if($brand->branch->count() > 0){
        foreach($brand->branch->all() as $branch){
          $event_locations[$branch->lat .','. $branch->lon .','. $branch->name] = array();
        }
      }

    echo json_encode(array('brand'=> $event_brand, 'locations' => $event_locations));
  }
}
