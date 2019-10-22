<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\User;

class UserController extends Controller
{
    public function index()
    {
      //https://gist.github.com/drawmyattention/8cb599ee5dc0af5f4246

      //echo 'user role => ' . Auth::User()->getUserRole();
      echo '<br /> user has role manager => ' . Auth::User()->hasRole(['Root', 'Administrator', 'Manager']);

      //view
      /*
      @if( Auth::User()->hasRole(['Partner', 'Moder']) )
      @endif
      */

    }
}
