<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Social;
use Auth;
use Session;
use Twitter;


class TwitterController extends Controller
{
    public function login(){
         // your SIGN IN WITH TWITTER  button should point to this route
        $sign_in_twitter = true;
        $force_login = false; //false

        // Make sure we make this request w/o tokens, overwrite the default values in case of login.
        Twitter::reconfig(array('token' => '', 'secret' => ''));
        $token = Twitter::getRequestToken(route('twitter.callback'));

        if (isset($token['oauth_token_secret']))
        {
            $url = Twitter::getAuthorizeURL($token, $sign_in_twitter, $force_login);
            Session::put('oauth_state', 'start');
            Session::put('oauth_request_token', $token['oauth_token']);
            Session::put('oauth_request_token_secret', $token['oauth_token_secret']);

            //return Redirect::to($url);
            return redirect($url);
        }
        //return Redirect::route('twitter.error');
        return redirect()->route('twitter.error');
        //echo 'twitter error';
    }

    public function callback(Request $request){
        if (Session::has('oauth_request_token'))
        {
            $request_token = array(
                'token'  => Session::get('oauth_request_token'),
                'secret' => Session::get('oauth_request_token_secret'),
            );

            Twitter::reconfig($request_token);
            $oauth_verifier = false;
            /*
            if (Input::has('oauth_verifier'))
            {
                $oauth_verifier = Input::get('oauth_verifier');
            }
            */

            if ($request->has('oauth_verifier')) {
                $oauth_verifier = $request->oauth_verifier;
                //echo 'oauth => ' . $request->oauth_verifier;
            }

            // getAccessToken() will reset the token for you
            $token = Twitter::getAccessToken($oauth_verifier);
            if (!isset($token['oauth_token_secret']))
            {
                //return Redirect::route('twitter.login')->with('flash_error', 'We could not log you in on Twitter.');
                return redirect()->route('twitter.login')->with('flash_error', 'We could not log you in on Twitter.');
                //echo 'We could not log you in on Twitter.';
            }

            $credentials = Twitter::getCredentials();
            if (is_object($credentials) && !isset($credentials->error))
            {
                // $credentials contains the Twitter user object with all the info about the user.
                // Add here your own user logic, store profiles, create new users on your tables...you name it!
                // Typically you'll want to store at least, user id, name and access tokens
                // if you want to be able to call the API on behalf of your users.

                // This is also the moment to log in your users if you're using Laravel's Auth class
                // Auth::login($user) should do the trick.
                Session::put('access_token', $token);

                //echo 'token ok >>>';

                //insert token to database
                $user = Twitter::get('account/verify_credentials');
                $token['user_name'] = $user->name;
                $tToken = json_encode($token);

                //2016-07-27 1605, master ok
                $twitter = 0;
                $new_user = 'N';
                $user_id = Auth::user()->id;
                $exists_social = Social::where('user_id', $user_id)->where('social_id', $user->id)->first();
                if(is_null($exists_social)){
                  $twitter = Social::firstOrCreate(array('social' => 'twitter', 'user_id' => $user_id, 'social_id' => $user->id, 'name' => $user->name, 'token' => $tToken, 'long_live_token' => null, 'page_token' => null))->id;
                  $new_user = 'Y';
                } else {
                  $twitter = $exists_social->id;
                }
                //$twitter = json_encode($token);
                //$brand->social()->sync($twitter);

                //return Redirect::to('/')->with('flash_notice', 'Congrats! You\'ve successfully signed in!');
                //return redirect('/twitter/tweet')->with('flash_notice', 'Congrats! You\'ve successfully signed in!'); //master ok, 2016-06-24 0004
                $user_id = $token['user_id'];
                $user_name = $token['user_name'];
                return view('brand.twitter', compact('user_id', 'user_name', 'twitter', 'new_user'));
            }
            //return Redirect::route('twitter.error')->with('flash_error', 'Crab! Something went wrong while signing you up!');
            return redirect()->route('twitter.error')->with('flash_error', 'Crab! Something went wrong while signing you up!');
        }
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

    public function tweet()
    {
        //Test Current User
        /*$user = Twitter::get('account/verify_credentials');
        echo 'id => ' . $user->id . '<br />';
        echo '<pre>';
        print_r(Session::get('access_token'));
        echo '<pre>';
        print_r($user);*/

        //return view('brand.twitter');
        $short_url = $this->get_google('http://www.welovepro.com/promotion-dak-galbi-groupshot-50-off-add-on-menu-july-aug-2016');

        echo ("โปรโมชั่น รวมกันลดอยู่ แยกหมู่อดนะ จาก Dak Galbi ลด 50% เมนู ADD ONS แบบไม่จำกัด (ก.ค.-ส.ค.59) $short_url");
        exit;

        $uploaded_media = Twitter::uploadMedia(['media' => file_get_contents('http://welovepro.com/images/events/2016-07-13/20160713-163319-dakgalbi.jpg')]);
        Twitter::postTweet(['status' => "โปรโมชั่น รวมกันลดอยู่ แยกหมู่อดนะ จาก Dak Galbi ลด 50% เมนู ADD ONS แบบไม่จำกัด (ก.ค.-ส.ค.59) $short_url", 'media_ids' => $uploaded_media->media_id_string]);
        //$url = Twitter::linkify('http://www.welovepro.com/promotion-dak-galbi-groupshot-50-off-add-on-menu-july-aug-2016');
        //$link = Twitter::linkTweet('http://www.welovepro.com/promotion-dak-galbi-groupshot-50-off-add-on-menu-july-aug-2016');
        //echo $url . '<br />';
        //echo $link . '<br />';
        echo 'tweet >>';
    }

    public function error(){
      //echo 'error';
    }

    public function logout(){
        Session::forget('access_token');
        //return Redirect::to('/')->with('flash_notice', 'You\'ve successfully logged out!');
        return redirect('/')->with('flash_notice', 'You\'ve successfully logged out!');
    }
}
