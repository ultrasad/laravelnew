<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Event;

class FilterController extends Controller
{
  public function condition($filter='today')
  {
    $paginate = 10;
    $events = Event::published()->active()->Filter($filter)->orderBy('events.updated_at', 'desc')->orderBy('events.created_at', 'desc')->paginate($paginate);

    /*echo 'filter => ' . $filter . '<br />';
    echo '<pre>';
    print_r($events);
    echo '</pre>';
    exit;
    */

    $more_page = $events->hasMorePages();
    $total_page = $events->total();

    return view('events.filter', compact('events', 'more_page', 'total_page', 'paginate', 'filter'));
  }
}
