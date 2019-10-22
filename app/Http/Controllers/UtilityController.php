<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App;
use App\Event;
use Facebook;

class UtilityController extends Controller
{
    public function index()
    {
      echo 'Welovepro utility';
    }
    public function summary()
    {
		//$promotion = Event::orderBy('events.created_at', 'desc')->limit(10)->get();
		$promotion = Event::select('title', 'image', 'url_slug')->where('published_at', '>=', Carbon::today())->active()->orderBy('events.created_at', 'desc')->get();
		
		if( $promotion && count( $promotion ) > 0 ){
			$message = "";
			$thmArr = array();
			
			foreach( $promotion as $pro ){
				$newsTitle = html_entity_decode( $pro->title , ENT_QUOTES, 'UTF-8' );
				$message .= $newsTitle . " \n\r ";
				$message .= url( $pro->url_slug ) . "\n\r\n\r ---------------------- \n\r\n\r";
				
				$thmArr[] = (object) array( 
					"link" => url( $pro->url_slug ), 
					"picture" => url( $pro->image ), 
					"name" => substr( $newsTitle, 0, strrpos($newsTitle, ' ', -50) ) 
				);
			} //foreach
			
			# POST to Facebook
			$this->post_summary_to_facebook( array( 'message' => $message, 'thmArr' => $thmArr ) );
			
		} // has some news
		
    }
	
	/*------------------------------------------------
	| Get all last posts of today!
	| Then Post to Facebook (WeLoveProFan)
	------------------------------------------------*/
	private function post_summary_to_facebook( $data = array() )
    {
		 $fb = new Facebook\Facebook([
			'app_id' => env('FACEBOOK_APP_KEY'),
			'app_secret' => env('FACEBOOK_APP_SECRET'),
			'default_graph_version' => 'v2.6',
		]);
		
		$args = array(
			'message' => "สรุปข่าวโปรโมชั่น! ที่เพิ่มเข้ามาวันนี้ \n\r\n\r " . $data['message' ] . "#welovepro #promotion #โปรโมชั่น #sale",
			'link' => config('app.url'),
			'child_attachments' => $data['thmArr'],
		);

		//print_r( $args );
		# POST request
		try {
			$response = $fb->post( '/'.env('FACEBOOK_WLP_PAGE_ID').'/feed', $args, env('FACEBOOK_WLP_LONGLIVE_TOKEN'));
        } catch (FacebookApiException $e) {
            echo $e->getMessage();
        }
		return;
    }
	
	/*------------------------------------------------
	| Get all last posts of today!
	| Then Post to Twitter (@welovepro)
	------------------------------------------------*/
	private function post_summary_to_twitter( $data = array() )
    {
		
	}
	

	/*------------------------------------------------------------------
	| Call Facebook API go get "Photo" or "Album"
	| Then replace to post
	| -> this Method call by Ajax Short Code Script!!!
	-------------------------------------------------------------------*/
	public function get_facebook_photos( Request $request )
    {
		$data = explode(',', $request->input('shtcd') );
		if( !is_array( $data ) || ( count ( $data ) < 1 ) ){
			return json_encode( array( "res" => "false" ) );
		}else{
			
			$fb = $this->__connect_fb();
			$res = array();
			$xloop = 0;
			
			foreach ($data as $key => $value) {
				$shortCodeInfo = $this->__extrack_shortcode( $value );
				if( $shortCodeInfo ){
					switch( $shortCodeInfo['action'] ){
						
						/*----------- Single Photo ----------------*/
						case 'fbPhoto' :
								$args = '?fields=images,name,from';
							if( $fbRes = $this->__request_to_fb_get( $fb, '/'.$shortCodeInfo['id'].$args ) ){
								$Photo = json_decode( $fbRes->getBody(), true );
								if($Photo['images']){
									$res[] = array( 'key' => $value, 'rpl' => "<p><img src=\"".$Photo['images'][0]['source']."\" alt=\"".$shortCodeInfo['title']."\" title=\"".$shortCodeInfo['title']."\" class=\"img-responsive\"/><br/>credit : ".$Photo['from']['name']."</p>" );
								} // found image
							} //fbRes
						break;
						
						/*----------- Photo Album ----------------*/
						case 'fbPhotoAlbum' :
							$args = '?fields=photos.limit(100){name,images},name,description,from';
							if( $fbRes = $this->__request_to_fb_get( $fb, '/'.$shortCodeInfo['id'].$args ) ){
								$ListPhoto = json_decode( $fbRes->getBody(), true );
								if($ListPhoto['photos']){
									$dtxt = isset( $ListPhoto['name'] ) ? "<h3>".$ListPhoto['name']."</h3>" : "";
									$dtxt .= isset( $ListPhoto['description'] ) ? "<p>".$ListPhoto['description']."</p>" : "";
									/* $dtxt .= "<span class=\"fbShortCodeDesc\">**คลิ๊กที่ภาพ เพื่อขยาย**</span><br/>"; */
									$dtxt .= "<br/>credit : ".$ListPhoto['from']['name'];
									for($lp=0; $lp<count($ListPhoto['photos']['data']); $lp++){
										$dtxt .= "<p><img src=\"".$ListPhoto['photos']['data'][$lp]['images'][3]['source']."\" alt=\"".$shortCodeInfo['title']."\" title=\"".$shortCodeInfo['title']."\" class=\"img-responsive\"/></p>";
									} //for
									$res[] = array( 'key' => $value, 'rpl' => $dtxt );
								} //if list
							} //fbRes
						break;
						
					} //switch
				} // if shortcode
			} //foreach
			
			return ( count( $res ) > 0 ) ? json_encode( array( "res" => "OK", "data" => $res ) ) : json_encode( array( "res" => "false" ) );
			
		} //else
	}
	
	########### Utility #############
	
	/*------------------------------------------------------------------
	| make a fb connection
	| return : Object
	-------------------------------------------------------------------*/
	private function __connect_fb()
	{
			return new Facebook\Facebook([
				'app_id' => env('FACEBOOK_APP_KEY'),
				'app_secret' => env('FACEBOOK_APP_SECRET'),
				'default_graph_version' => 'v2.6',
			]);
	}
	
	/*------------------------------------------------------------------
	| make a fb request GET
	| return : Facebok Object
	-------------------------------------------------------------------*/
	private function __request_to_fb_get( $fb, $req )
	{
		try {
			$response = $fb->get( $req, env('FACEBOOK_WLP_LONGLIVE_TOKEN') );
			return $response;
		} catch (FacebookApiException $e) {
			return false;
		}
	}
	
	/*------------------------------------------------------------------
	| make a fb request POST
	| return : Facebok Object
	-------------------------------------------------------------------*/
	private function __request_to_fb_post( $fb, $req, $args )
	{
		try {
			$response = $fb->post( $req, $args, env('FACEBOOK_WLP_LONGLIVE_TOKEN') );
			return $response;
		} catch (FacebookApiException $e) {
			return false;
		}
	}
	
	
	/*------------------------------------------------------------------
	| explode short code 
	| return : Array()
	-------------------------------------------------------------------*/
	private function __extrack_shortcode( $shortcode )
	{
		$shortcode = str_replace( '[','', $shortcode );
		$shortcode = str_replace( ']','', $shortcode );
		$shortcode = trim( $shortcode );
		
		$shortcmd = explode( ' ', $shortcode );
		
		if( count( $shortcmd ) > 1 ){
			$res = array( "action" => trim( $shortcmd[0] ) );
			for( $xlp=1; $xlp < count( $shortcmd ); $xlp++ ){
				preg_match('/(.*)="(.*)"/', trim( $shortcmd[$xlp] ) , $matches);
				if( $matches[1] && $matches[2] ){
					$res[$matches[1]] = $matches[2];
				}
			}
			$res['title'] = isset( $res['title'] ) ? $res['title'] : '';
			return $res;
		}else{
			return false;
		}
	}
	
}
