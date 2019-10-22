<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::get('/img/{path}', 'GlideImageController@show')->where('path', '.*');

/*
Route::get('img/{$path}}', function(League\Glide\Server $server, $path){
  echo 'xx path => ';
  dd($path);
  exit;
});
*/

/*
Route::get('public/images/{path}', function(League\Glide\Server $server, Illuminate\Http\Request $request){
  //dd($request);
  $server->getImageResponse($request, []);
})->where('path', '.+');

Route::get('img/{path}', function($path, League\Glide\Server $server, Illuminate\Http\Request $request) {
  $server->outputImage($path, $request->all());
})->where('path', '.+');

Route::get('/img/{path}', 'ImageController@output');
*/


/*
Route::get('public/img/{path}', function($path, League\Glide\Server $server, Illuminate\Http\Request $request) {
  //$server->outputImage($path, $request->all());
  $server->getImageResponse($path, $request->all());
  dd($path);
})->where('path', '.+');
*/

Route::get('/reindex', 'EventsController@reindex');

/*
Route::get('images/{path}', function(League\Glide\Server $server, Illuminate\Http\Request $request, $path){
  //$server->outputImage($path, $request->input());
  dd($path);
})->where('path', '.+');
*/

//Route::get('/images/{path}', 'GlideController@show')->where('path', '.*');
//Route::get('images/{path}', 'GlideImageController@show')->where('path', '.*');
//Route::get('/img/{path}', 'GlideImageController@show')->where('path', '.*');

Route::group(['middleware' => 'web'], function () {

    //Route::auth();
    Auth::routes();

    /*
    Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
        Route::get('/', 'Auth\LoginController@showLoginForm');
        Route::post('login', 'Auth\LoginController@login');
        Route::post('logout', 'Auth\LoginController@logout');
    });
    
    Route::group(['namespace' => 'Site', 'prefix' => 'admin'], function () {
        Route::get('/', 'Auth\LoginController@showLoginForm');
        Route::post('login', 'Auth\LoginController@login');
        Route::post('logout', 'Auth\LoginController@logout');
    });
    */

    Route::get('sitemap', function()
    {

        // create sitemap index
        $sitemap = App::make ("sitemap");

        // create new sitemap object
        $sitemap_category = App::make("sitemap");

        // add every category to the sitemap
        $category = DB::table('categories')->orderBy('id', 'asc')->get();
        foreach($category as $cate)
        {
          $sitemap_category->add(URL::to('/category/' . $cate->category), date('Y-m-d H:i:s'), '0.9', 'monthly');
        }
        $sitemap_category->store('xml','sitemap-category');
        // add sitemaps (loc, lastmod (optional))
        $sitemap->addSitemap(url('sitemap-category.xml'), date('Y-m-d H:i:s'));

        // create new sitemap object
        $sitemap_brand = App::make("sitemap");

        // add every brand to the sitemap
        $brands = DB::table('brand')->orderBy('id', 'asc')->get();
        foreach($brands as $brand)
        {
          $sitemap_brand->add(URL::to('/brand/' . $brand->url_slug), date('Y-m-d H:i:s'), '0.9', 'monthly');
        }
        $sitemap_brand->store('xml','sitemap-brand');
        // add sitemaps (loc, lastmod (optional))
        $sitemap->addSitemap(url('sitemap-brand.xml'), date('Y-m-d H:i:s'));

        // get all products from db (or wherever you store them)
        $posts = DB::table('events')->orderBy('created_at', 'desc')->get();

        // counters
        $counter = 0;
        $sitemapCounter = 0;

        // create new sitemap object
        $sitemap_posts = App::make("sitemap");

        // add every product to multiple sitemaps with one sitemapindex
        foreach ($posts as $post)
        {
            if($sitemapCounter == 0 && $counter == 0){
              $sitemap_posts->add(URL::to('/'), date('Y-m-d H:i:s'), '1.0', 'daily');
              $counter++;
            }

            if ($counter == 1000)
            {
                // generate new sitemap file
                $sitemap_posts->store('xml','sitemap-'.$sitemapCounter);
                // add the file to the sitemaps array
                //$sitemap->addSitemap(secure_url('sitemap-'.$sitemapCounter.'.xml'));
                $sitemap->addSitemap(url('sitemap-'.$sitemapCounter.'.xml'), date('Y-m-d H:i:s'));
                // reset items array (clear memory)
                $sitemap_posts->model->resetItems();
                // reset the counter
                $counter = 0;
                // count generated sitemap
                $sitemapCounter++;
            }

            // add product to items array
            $image = array();
            $image[] = array(
                'url' => URL::to('/' . $post->image),
                'title' => htmlspecialchars($post->title, ENT_QUOTES|ENT_XML1, "UTF-8"),
                'caption' => htmlspecialchars($post->title, ENT_QUOTES|ENT_XML1, "UTF-8")
                //'caption' => htmlspecialchars($post->brief, ENT_QUOTES|ENT_XML1, "UTF-8")
            );
            $sitemap_posts->add(URL::to('/' . $post->url_slug), $post->created_at, '0.9', 'monthly', $image);

            // count number of elements
            $counter++;
          }

          // you need to check for unused items
          if (!empty($sitemap_posts->model->getItems()))
          {
               // generate sitemap with last items
               $sitemap_posts->store('xml','sitemap-'.$sitemapCounter);
               // add sitemap to sitemaps array
               //$sitemap->addSitemap(secure_url('sitemap-'.$sitemapCounter.'.xml'));
               $sitemap->addSitemap(url('sitemap-'.$sitemapCounter.'.xml'), date('Y-m-d H:i:s'));
               // reset items array
               $sitemap_posts->model->resetItems();
           }


           // create sitemap index
           //$sitemap = App::make ("sitemap");

           //$sitemap->addSitemap(url('sitemap-category'), date('Y-m-d H:i:s'));
           //$sitemap->addSitemap(url('sitemap-brand'), date('Y-m-d H:i:s'));

           // generate new sitemapindex that will contain all generated sitemaps above
           $sitemap->store('sitemapindex','sitemap');

           return 'OK';
    });

    Route::get('/check_env', 'EventsController@check_env');
    Route::get('/client_request', 'EventsController@client_request');

    Route::get('/', 'EventsController@index');
    /*Route::get('/register', function () {
        return redirect('/');
    });*/

    Route::get('/clear-cache', function() {
        $clearCompiled = Artisan::call('clear-compiled');
        $clearView = Artisan::call('view:clear');
        $clearCache = Artisan::call('cache:clear');
        //$clearRoute = Artisan::call('route:cache');
        // return what you want
        return 'OK';
    });

    Route::get('/clear-config', function() {
        $clearConfig = Artisan::call('config:clear');
        return 'OK => ' . $clearConfig;
    });

    Route::get('/cache-config', function() {
        $cacheConfig = Artisan::call('config:cache');
        return 'OK => ' . $cacheConfig;
    });

    Route::get('/config-sitemap', function() {
        $configSitemap = Artisan::call('vendor:publish',
        [
            '--provider' => 'Roumen\Sitemap\SitemapServiceProvider',
            //'--tag' => ['seeds'],
            //'--force' => true
        ]);

        return ($configSitemap);
        //return 'OK';
    });

    /*Route::get('/reindex', function() {
      $reIndexSearch = Artisan::call('larasearch:reindex',
      [
        '--relations' => true,
        '--dir' => 'App/Event'
      ]);
    });*/

    /*Route::get('/posttweet', function()
    {
        return Twitter::postTweet(['status' => 'Laravel is beautiful', 'format' => 'json']);
    });*/

    Route::get('/events/post_social/{event_id}', 'EventsController@post_social');

    Route::get('user/{user}', [
    	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
    	'uses' => 'UserController@index',
    	'roles' => ['administrator', 'manager'] // Only an administrator, or a manager can access this route
    ]);

    Route::get('twitter/login',array('as' => 'twitter.login','uses' => 'TwitterController@login'));
    Route::get('twitter/callback', array('as' => 'twitter.callback','uses' =>'TwitterController@callback'));
    Route::get('twitter/error', array('as' => 'twitter.error','uses' =>'TwitterController@error'));
    Route::get('twitter/logout', array('as' => 'twitter.logout','uses' =>'TwitterController@logout'));
    Route::get('twitter/tweet', array('as' => 'twitter.tweet','uses' =>'TwitterController@tweet'));

    Route::get('home', 'HomeController@index');
    Route::get('events/locations/{id}', 'EventsController@locations');
    Route::post('events/desc_upload', 'EventsController@desc_upload');
    //Route::get('events/branch/{id}', 'EventsController@branch');
    Route::get('events/brand/{id}', 'EventsController@brand');
    Route::get('events/removefile/{id}/{image}', 'EventsController@removefile');
    Route::get('twitter_reconfig', 'EventsController@twitter_reconfig');

    Route::get('tag/all_tags', 'TagsController@all_tags');
    Route::get('tag/{name}', 'TagsController@index');

    Route::get('category/{name}', 'CategoryController@index');
    Route::get('brand/check_facebook', 'BrandController@check_facebook');
    Route::get('brand/category/{name}', 'BrandController@category');
    Route::get('brand/locations/{slug}', 'BrandController@locations');
    Route::get('maps/locations', 'MapsController@locations');
    Route::get('map', 'MapsController@index');
    //Route::get('map/check', 'MapsController@check');
    //Route::get('events/check', 'EventsController@check');
    Route::get('map/locations/{id}', 'MapsController@locations');
    Route::get('map/latlon/{lat}/{lon}', 'MapsController@latlon');
    //Route::get('map/{lat}/{lon}', 'MapsController@index')->where(['lat' => '[0-9\.]+', 'lon' => '[0-9\.]+']);
    Route::get('map/{lat}/{lon}', 'MapsController@index')->where(['lat' => '[0-9\.]+', 'lon' => '[0-9\.]+']);
    //Route::get('maps/{id}', 'MapsController@index'); //old solution
    Route::get('brand/register', [
      'middleware' => ['auth', 'roles'],
      'uses' => 'BrandController@register',
      'roles' => ['administrator', 'manager']
    ]);
    Route::post('brand/add_branch', 'BrandController@add_branch');

    Route::get('brand/lists', 'BrandController@lists');

    Route::get('/brand/{id}', array('as' => 'id', 'uses' => 'BrandController@index'))
    ->where('id', '[0-9]+');

    Route::get('/brand/{slug}', array('as' => 'slug', 'uses' => 'BrandController@index'))
    ->where('slug', '[A-Za-z0-9\-]+');

    Route::get('/admin',[
      'middleware' => ['auth', 'roles'],
      //'uses' => 'EventsController@admin',
      'uses' => 'AdminController@index',
      'roles' => ['Administrator', 'Manager', 'Company Manager']
    ]);

    Route::get('/admin/setting',[
      'middleware' => ['auth', 'roles'],
      //'uses' => 'EventsController@admin',
      'uses' => 'AdminController@setting',
      'roles' => ['Administrator', 'Manager']
    ]);

    Route::get('utility/summary', 'UtilityController@summary');
	  Route::post('utility/fbphotocode', 'UtilityController@get_facebook_photos');

    Route::post('/admin/events', 'AdminController@events');
    Route::get('/admin/events', 'AdminController@events');

    Route::get('/admin/del_event/{id}', array('as' => 'id', 'uses' => 'AdminController@delete_event'))
    ->where('id', '[0-9]+');

    Route::resource('brand', 'BrandController'); //RESTful Resource Controllers
    Route::resource('contact', 'ContactController'); //RESTful Resource Controllers
    Route::resource('events', 'EventsController'); //RESTful Resource Controllers
    Route::resource('utility', 'UtilityController'); //RESTful Resource Controllers

    //filter
    Route::get('/{filter}', array('as' => 'filter', 'uses' => 'FilterController@condition'))
    ->where('filter', '(today|thisweek|[0-9]{4}-[0-9]{2}-[0-9]{2})');

    //Route::get('events/search/{keywords}', array('as' => 'keywords', 'uses' => 'EventsController@search'));
    Route::get('events/search/{type}/{keywords}', 'EventsController@search');
    Route::get('show2/{slug}', array('as' => 'slug', 'uses' => 'EventsController@show2'));
    Route::get('/{slug}', array('as' => 'detail', 'uses' => 'EventsController@show'));

    //Route::resource('articles', 'ArticlesController'); //RESTful Resource Controllers
    //Route::resource('events', 'EventsController'); //RESTful Resource Controllers
    //Route::resource('maps', 'MapsController'); //RESTful Resource Controllers
    //Route::resource('brand', 'BrandController'); //RESTful Resource Controllers
    //Route::resource('contact', 'ContactController'); //RESTful Resource Controllers
});
