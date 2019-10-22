<?php

namespace App\Http\Controllers;

//use Redirect;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Event;
use App\Tag;

use Request as Response;

class TagsController extends Controller
{
  public function index($tag='')
  {
      $events = Event::select('events.*', 'events.url_slug as url_slug')->published()->active()->tagList($tag)->orderBy('events.created_at', 'desc')->paginate(10);
      if($events->count() < 1){
        //return Redirect::back()->with('message','Tag Not Exists !');
        //return redirect('/');
        $events = Event::published()->active()->orderBy('events.created_at', 'desc')->limit(10)->get();
        return \Response::view('errors.404', array('url' => Response::url(), 'events' => $events, 'msg' => 'ไม่พบข้อมูลที่คุณต้องการ'), 404); //\Response is native response, Reponse is make from Request
      } else {
        $tag_name = $events->first()->tags->where('tag', $tag)->first()->name;
      }

      //echo 'name => '. $tag_name;
      //exit;
      return view('tags.list', compact('events', 'tag_name'));
  }

  public function all_tags()
  {
    $tags = Tag::select('name')->get();
    $arr_tag = array();
    foreach($tags as $tag){
      array_push($arr_tag, $tag->name);
    }

    echo json_encode($arr_tag);
  }
}
