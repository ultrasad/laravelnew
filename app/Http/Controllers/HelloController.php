<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HelloController extends Controller
{
    public function index()
    {
      // Temporarily increase memory limit to 256MB
      //ini_set('memory_limit','256M');

      //$unitTesting = true;
      //$testEnvironment = 'testing';

      //return "Hello from HelloController";
      return view('hello.index',['title'=> '<u>Hello Title</u>', 'subtitle' => 'Sub Title', 'record' => array(1,2,3), 'users' => array()]);
    }
}
