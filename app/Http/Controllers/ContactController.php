<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function __construct()
    {
      //$this->middleware('auth', ['except' => ['index']]);
    }

    public function index()
    {
        return view('contact.index');
    }

    /**
    * Store a newly created resource in storage.
    *
    *@return Response
    */
    public function store(Request $request)
    {
      /*$validate = Validator::make(Input::all(), [
        'g-recaptcha-response' => 'required|captcha'
      ]);*/

      /*$validate = Validator::make($request->all(), [
        'g-recaptcha-response' => 'required|captcha'
      ]);*/

      $validator = Validator::make($request->all(), [
           'fname' => 'required',
           'lname' => 'required',
           'email' => 'required|email',
           //'phone' => 'required',
           'g-recaptcha-response' => 'required|captcha'
           //'phone' => 'required',
           //'body' => 'required',
       ], ['phone.required' => 'กรุณากรอกเบอร์โทรศัพท์', 'g-recaptcha-response.required' => 'กรุณาติ๊กลงในช่องป้องกันสแปม']);

       //dd($request->all());
       if ($validator->fails()) {
         return redirect('contact')->withInput()->withErrors($validator);
       } else {
         echo 'success';
         //send mail, save db
         //send success message
       }
    }
}
