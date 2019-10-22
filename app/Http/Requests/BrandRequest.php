<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class BrandRequest extends Request
{
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
          'name' => 'required|min:3|max:255',
          'url_slug'  => 'required',
          //'name' => 'required|min:3|max:255',
          //'url_slug'  => 'required',
          //'image' => 'mimes:png,jpeg,jpg,gif'
      ];
    }

    public function messages()
    {
        return [
          //'required' => 'You have to enter some data on :attribute field',
          //'title.required' => 'Please enter the title on this article'
        ];
    }
}
