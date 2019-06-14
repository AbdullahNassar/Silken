<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Solution;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    //

    public function getIndex(){
        $solution = Solution::first();

        return view('site.pages.services.index' ,compact('solution'));
    }
}
