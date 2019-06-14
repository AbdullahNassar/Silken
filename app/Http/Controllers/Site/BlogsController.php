<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Blog;

class BlogsController extends Controller
{
    //
    public function getIndex(){
        $blogs = Blog::get();

        return view('site.pages.blogs.index' ,compact('blogs'));
    }

    public function getOnly($slug){
        $blog = Blog::where('slug' ,$slug)->first();

        return view('site.pages.blogs.only' ,compact('blog'));
    }
}
