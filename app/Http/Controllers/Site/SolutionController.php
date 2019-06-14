<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Solution;

class SolutionController extends Controller
{
    //
    public function getIndex($slug){
        $solution = Solution::where('slug' ,$slug)->first();

        return view('site.pages.solutions.index' ,compact('solution'));
    }
}
