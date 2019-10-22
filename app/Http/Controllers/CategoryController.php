<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Event;
use App\Category;
use Request as Response;

class CategoryController extends Controller
{
  public function index($category='')
  {
      $paginate = 10;
      $category_name = 'ไม่ระบุ หมวดหมู่';
      $category_icon = '';
      $cate = Category::where('category', $category)->first();
      if($cate){
        $category_name = $cate->name;
        $category_icon= $cate->icon;
      } else {
        if($category != 'unknow'){
          //return redirect('/');
          $events = Event::published()->active()->orderBy('events.created_at', 'desc')->limit(10)->get();
          return \Response::view('errors.404', array('url' => Response::url(), 'events' => $events, 'msg' => 'ไม่พบข้อมูลที่คุณต้องการ'), 404); //\Response is native response, Reponse is make from Request
        }
      }

      //echo 'cate => ' . $category . '<br />';
      //try {
      //$events = Event::published()->active()->categoryList($category)->orderBy('events.created_at', 'desc')->paginate(15);
      $events = Event::select('events.*', 'events.url_slug as url_slug')->published()->active()->brandCategoryList($category)->orderBy('events.updated_at', 'desc')->orderBy('events.created_at', 'desc')->paginate($paginate);
      //$category_name = $events->first()->category->where('category', $category)->first()->name;

      $more_page = $events->hasMorePages();
      $total_page = $events->total();

      //echo '<pre>';
      //print_r($events);
      //exit;

      /*if($events->count() > 0){
        if($category == 'unknow'){
          $category_name = 'ไม่ระบุ หมวดหมู่';
        } else {
          $category_name = $events->first()->category->where('category', $category)->first()->name;
        }
      }*/

      /*
      if($events->count() < 1){
        //return Redirect::back()->with('message','Tag Not Exists !');
        //return redirect('/');
        $category_name = Category::nameCateId($category);
      } else {
        if($category == 'unknow'){
          $category_name = 'ไม่ระบุ หมวดหมู่';
        } else {
          $category_name = $events->first()->category->where('category', $category)->first()->name;
        }
      }
      */

    //} catch(ErrorException $e) {
      //abort(404);
    //}

      //echo 'name => '. $category_name;
      //exit;
      return view('category.list', compact('events', 'category', 'category_name', 'category_icon', 'more_page', 'total_page', 'paginate'));
  }
}
