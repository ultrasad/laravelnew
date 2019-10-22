<?php

namespace App\Helpers;
use Illuminate\Database\Eloquent\Model;

use Cache;
use App\Category;
use App\Brand;

class MenuHelper {

  public static function brand()
  {
    $brand = Cache::remember('_brand_all', 1440, function() {
      return Brand::orderBy('master_group', 'asc')->get();
    });
    return $brand;
    //return Brand::orderBy('master_group', 'asc')->get();
  }

  public static function menu()
  {
    $category = Cache::remember('_category_all', 1440, function() {
      return Category::orderBy('order_id', 'asc')->get();
    });
    return $category;
    //return Category::orderBy('order_id', 'asc')->get();
  }

  /*public static function dateFormat1($date) {
        if ($date) {
            $dt = new DateTime($date);

        return $dt->format("m/d/y"); // 10/27/2014
      }
   }*/
}
