<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class EventRequest extends Request
{
      /**
     * {@inheritdoc}
     */
    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
     public function rules()
     {
         return [
             'title' => 'required|min:3|max:255',
             'url_slug'  => 'required',
             //'tag_list' => 'required',
             'brief' => 'required',
             //'published_at'  => 'required|date',
             'image' => 'mimes:png,jpeg,jpg,gif'
         ];
     }

     public function messages()
     {
         return [
           //'required' => 'You have to enter some data on :attribute field',
           //'title.required' => 'Please enter the title on this article',
           //'tag_list.required' => 'Please enter the tag on this event',

           //'required'  => 'Your :attribute is required.',
           //'tag_list.required' => 'Please enter the tag on this event',
           //'min'  => ':attribute must be at least :min characters in length.',
           //'email' => 'Please type valid email address.',
         ];
     }
}
