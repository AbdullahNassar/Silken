<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\About;

class AboutController extends Controller
{
    //
    public function getIndex(){
        $about = About::get();

        return view('site.pages.about.index' ,compact('about'));
    }
}
