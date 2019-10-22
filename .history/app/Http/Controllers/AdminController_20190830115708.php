<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

//use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Auth;
use App\Brand;
use App\Event;

class AdminController extends Controller
{
  //admin event lists
  public function index()
  {

    echo 'test';
    exit;

    $user_id = Auth::user()->id;
    $role_id = Auth::user()->role_id;
    $paginate = 20;
    if($role_id == 4){//brand
      $brands = Brand::where('user_id', $user_id)->get();
      $brands_list = $brands->lists('id')->toArray();

      //$events = Event::published()->active()->brandEvent($brands_list)->orderBy('events.updated_at', 'desc')->orderBy('events.created_at', 'desc')->get();
      $events = Event::published()->active()->brandEvent($brands_list)->orderBy('events.created_at', 'desc')->paginate($paginate);

    } elseif($role_id < 4){ // manager, admin
      $brands = Brand::all();
      $events = Event::published()->active()->orderBy('events.created_at', 'desc')->paginate($paginate);
    }
    return view('admin.index', compact('events', 'role_id', 'user_id', 'brands'));
  }

  public function setting()
  {
    $user_id = Auth::user()->id;
    $role_id = Auth::user()->role_id;
    if($role_id == 4){//brand
      $brands = Brand::where('user_id', $user_id)->get();
    } elseif($role_id < 4){ // manager, admin
      $brands = Brand::all();
    }
    return view('admin.setting', compact('role_id', 'user_id', 'brands'));
  }

  public function events(Request $request)
  {
    //echo($request->input('test'));

    /*$start = isset($request['start'])?$request['start']:0;
		$info['PerPage'] = isset($request['length'])?$request['length']:20;
		if($start == 0){
			$pageNo = 1;
		} else if($start == 20) {
			$pageNo = 2;
      //echo 'start => ' . $start . '<br />';
      //echo 'pageNo => ' . $pageNo . '<br />';
		} else {
			$pageNo = ($start/20)+1;
		}*/

    $user_id = Auth::user()->id;
    $role_id = Auth::user()->role_id;

    $event_title = $request->input('event_title');
    $brand_id = $request->input('brand_id');

    $paginate = 20;
    if($role_id == 4){//brand
      $brands = Brand::where('user_id', $user_id)->get();
      $brands_list = $brands->lists('id')->toArray();
      $events = Event::published()->active()->eventLike($event_title)->brandEvent($brands_list)->orderBy('events.created_at', 'desc')->paginate($paginate);

    } elseif($role_id < 4){ // manager, admin
      //$brands = Brand::all();
      //->where('title', 'LIKE', "%$title%")
      $events = Event::published()->active()->eventLike($event_title)->brandEvent($brand_id)->orderBy('events.created_at', 'desc')->paginate($paginate);
    }

    $totaldata = $events->total();
    $totalfiltered = $totaldata;
    $data = array();

    foreach($events as $event){
      if($role_id < 4){ // manager, admin
        $btn_action = "<div id='btn_confirm' style='display:none'>
            <a href='javascript:void(0);' id='{$event->id}' class='btn btn-confirm-action btn-success btn-xs'><i class='fa fa-check'></i><span class='hidden-xs'> Yes</span></a>
            <a href='javascript:void(0);' class='btn btn-cancel-action btn-danger btn-xs'><i class='fa fa-times'></i><span class='hidden-xs'> No</span></a>
          </div>
          <div id='btn_action' style='display:block'>
            <a href='/events/{$event->id}/edit' class='btn btn-edit-action btn-complete btn-xs'><i class='fa fa-pencil-square-o'></i><span class='hidden-xs'> Edit</span></a>
            <a href='javascript:void(0);' class='btn btn-delete-action btn-danger btn-xs'><i class='fa fa-trash'></i><span class='hidden-xs'> Del</span></a>
          </div>";
      } else {
        $btn_action = "<div id='btn_action' style='display:block'>
            <a href='/events/{$event->id}/edit' class='btn btn-edit-action btn-complete btn-xs'><i class='fa fa-pencil-square-o'></i><span class='hidden-xs'> Edit</span></a>
          </div>";
      }

      $nestedData=array();
      $nestedData[] = $btn_action;
      $nestedData[] = $event->title;
      $nestedData[] = $event->brand->name;
      $nestedData[] = $event->start_date_thai;
      $nestedData[] = $event->end_date_thai;
      $data[] = $nestedData;
    }

    $draw = isset($request['draw'])?$request['draw']:1;
    $json_data = array(
			"draw" => intval( $draw ),
			"recordsTotal" => intval( $totaldata ),
			"recordsFiltered" => intval( $totalfiltered ),
			"data"  => $data
		);
		echo json_encode($json_data);
  }

  public function delete_event($id=0){
    $event = Event::find($id);
    $event->active = 'N';
    $event->deleted_at = date('Y-m-d H:i:s');
    $id = $event->save();
    if($id){
      echo json_encode(array('status'=> 'success', 'id' => $id));
    } else {
      echo json_encode(array('status'=> 'failure', 'id' => 'false'));
    }
  }
}
