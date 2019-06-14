<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sproduct;

class SproductsController extends Controller
{
    //
    public function getIndex(){
        $products = Sproduct::get();

        return view('site.pages.products.index' ,compact('products'));
    }
}
