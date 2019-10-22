<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Event;
use App\Location;
use App\Branch;

class MapsController extends Controller
{
  /**
  * Display a list of the event.
  *
  *@return Response
  */
  //public function index($id=0)
  public function index($lat=0, $lon=0)
  {
    //echo 'lat => ' . $lat . ', lon => ' . $lon . '<br />';
    return view('maps.index', compact('lat', 'lon'));
  }

  /*public function check()
  {
    //echo 'lat => ' . $lat . ', lon => ' . $lon . '<br />';
    $lat = '13.8167454';
    $lon = '100.56087009999999';
    return view('maps.index2');
  }*/

  public function latlon($lat=0, $lon=0)
  {
    $event_locations = array();
    if($lat > 0 && $lon > 0){
      //$events = Event::noExpire()->active()->eventLocation($id)->get();
      $events = Event::noExpire()->active()->eventLatLon($lat, $lon)->get();
      //echo '<pre>';
      //print_r($events);
      //exit;

      $branch_name = Branch::where('lat', $lat)->where('lon', $lon)->first()->name;
      //$event_locations[$lat .','. $lon .','. $location_name] = array();
      foreach($events as $id => $event){
        $cate_name = isset($event->category->first()->name)?$event->category->first()->name:'ไม่ระบุ หมวดหมู่';
        //echo $location_name;
        //echo 'brand => ' . $event->brand->name .'<br />';
        //echo '<pre>';
        //print_r($location_name->name);
        //exit;

        if(!array_key_exists($lat .','. $lon . ',' . $branch_name, $event_locations)){
          $event_locations[$lat .','. $lon .','. $branch_name] = array(array('title' => $event->title, 'slug' => $event->url_slug, 'brand' => $event->brand->name, 'brand_slug' => $event->brand->url_slug, 'brand_logo' => $event->brand->logo_image, 'image' => $event->image, 'category' => $cate_name, 'start_date_thai' => $event->start_date_thai, 'end_date_thai' => $event->end_date_thai));
        } else {
          //echo 'in array => ' . $branch->lat .','. $branch->lon;
          array_push($event_locations[$lat .','. $lon .','. $branch_name], array('title' => $event->title, 'slug' => $event->url_slug, 'brand' => $event->brand->name, 'brand_slug' => $event->brand->url_slug, 'brand_logo' => $event->brand->logo_image, 'image' => $event->image, 'category' => $cate_name, 'start_date_thai' => $event->start_date_thai, 'end_date_thai' => $event->end_date_thai));
        }

        //array_push($event_locations[$lat .','. $lon .','. $location_name], array('title' => $event->title, 'slug' => $event->url_slug, 'brand' => $event->brand->name, 'image' => $event->image, 'category' => $cate_name));
        //array_push($event_locations[$lat .','. $lon .','. $location_name], array('title' => $event->title, 'slug' => $event->url_slug, 'brand' => $event->brand->name, 'brand_slug' => $event->brand->url_slug, 'brand_logo' => $event->brand->logo_image, 'image' => $event->image, 'category' => $cate_name, 'start_date_thai' => $event->start_date_thai, 'end_date_thai' => $event->end_date_thai));
      }

      //echo '<pre>';
      //print_r($event_locations);
      //exit;
      echo json_encode($event_locations);
    }

    //echo json_encode($event_locations);
  }

  //public function locations($id=0)
  public function locations($id=0)
  {
    $event_locations = array();
    if($id > 0){
      //$location = Location::find($id);
      $events = Event::noExpire()->active()->eventLocation($id)->get();
      //echo '<pre>';
      //print_r($events);
      //exit;

      foreach($events as $id => $event){

        $cate_name = isset($event->category->first()->name)?$event->category->first()->name:'ไม่ระบุ หมวดหมู่';
        //echo 'cate name => ' . $cate_name . '<br />';
        //echo 'lo name => ' . $event->location->first()->name . '<br />';
        //echo 'lo lat => ' . $event->location->first()->lat . '<br />';
        //echo 'lo lon => ' . $event->location->first()->lon . '<br /></p>';

        if(!array_key_exists($event->location->first()->lat .','. $event->location->first()->lon . ',' . $event->location->first()->name, $event_locations)){
          $event_locations[$event->location->first()->lat .','. $event->location->first()->lon .','. $event->location->first()->name] = array(array('title' => $event->title, 'slug' => $event->url_slug, 'brand' => $event->brand->name, 'image' => $event->image, 'category' => $cate_name));
        } else {
          //echo 'in array => ' . $branch->lat .','. $branch->lon;
          array_push($event_locations[$event->location->first()->lat .','. $event->location->first()->lon .','. $event->location->first()->name], array('title' => $event->title, 'slug' => $event->url_slug, 'brand' => $event->brand->name, 'image' => $event->image, 'category' => $cate_name));
        }

        /*
        if($event->branch->count() > 0){
          $event_count = 0;
          foreach($event->branch->all() as $branch){
            //echo $branch->name . ', lat =>' .$branch->lat . '<br />';
            if(!array_key_exists($branch->lat .','. $branch->lon . ',' . $branch->name, $event_locations)){
              $event_locations[$branch->lat .','. $branch->lon .','. $branch->name] = array(array('title' => $event->title, 'slug' => $event->url_slug, 'brand' => $event->brand->name, 'image' => $event->image, 'category' => $cate_name));
            } else {
              //echo 'in array => ' . $branch->lat .','. $branch->lon;
              array_push($event_locations[$branch->lat .','. $branch->lon .','. $branch->name], array('title' => $event->title, 'slug' => $event->url_slug, 'brand' => $event->brand->name, 'image' => $event->image, 'category' => $cate_name));
            }
          }
        } else {
          //event location first
        }
        */
        //echo '</p>';
      }
      //exit;

    } else {
        $events = Event::noExpire()->active()->get();

        //echo '<pre>';
        //print_r($events);
        //exit;

        foreach($events as $id => $event){

          $cate_name = isset($event->category->first()->name)?$event->category->first()->name:'ไม่ระบุ หมวดหมู่';
          //echo $event->title . ', end => ' . $event->end_date .  '<br />';
          //echo 'count => ' . $event->branch->count() . '<br />';

          //echo '=>' . $event->id . '<br />';
          //exit;
          $event_end_date = $event->end_date;
          if(starts_with($event_end_date, '-000')){
              $event_end_date = date('Y-m-d', strtotime("+1 month", strtotime($event->start_date)));
          }

          if(($event->branch->count() > 0) && ($event_end_date > date('Y-m-d'))){
            $event_count = 0;
            foreach($event->branch->all() as $branch){
              //echo $branch->name . ', lat =>' .$branch->lat . '<br />';
              if(!array_key_exists($branch->lat .','. $branch->lon . ',' . $branch->name, $event_locations)){
                $event_locations[$branch->lat .','. $branch->lon .','. $branch->name] = array(array('title' => $event->title, 'slug' => $event->url_slug, 'brand' => $event->brand->name, 'brand_slug' => $event->brand->url_slug, 'brand_logo' => $event->brand->logo_image, 'image' => $event->image, 'category' => $cate_name, 'start_date_thai' => $event->start_date_thai, 'end_date_thai' => $event->end_date_thai));
              } else {
                //echo 'in array => ' . $branch->lat .','. $branch->lon;
                array_push($event_locations[$branch->lat .','. $branch->lon .','. $branch->name], array('title' => $event->title, 'slug' => $event->url_slug, 'brand' => $event->brand->name, 'brand_slug' => $event->brand->url_slug, 'brand_logo' => $event->brand->logo_image, 'image' => $event->image, 'category' => $cate_name, 'start_date_thai' => $event->start_date_thai, 'end_date_thai' => $event->end_date_thai));
              }
            }
          } else {
            //event location first
          }
          //echo '</p>';
        }

        //echo '<pre>';
        //print_r($event_locations);
        //exit;

        //echo json_encode($event_locations);
    }
    echo json_encode($event_locations);
  }

}
