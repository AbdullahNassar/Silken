<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Sproduct;
use App\Subscriber;
use Illuminate\Http\Request;
use App\Slider;

class HomeController extends Controller
{
    //
    public function getIndex(){
        $sliders = Slider::get();
        $products = Sproduct::get()->take(4);

        return view('site.pages.home' ,compact('sliders' ,'products'));
    }

    public function postSubscribe(Request $request){
        $op_array = [
            'response' => 'success',
            'message' => app()->getLocale() == 'ar' ? 'تمت الاضافه بنجاح' : 'Email added successfully'
        ];

        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

        if (!$email) {
            $op_array['response'] = 'error';
            $op_array['message'] =  app()->getLocale() == 'ar' ? 'البريد الاكتروني غير صحيح' : 'Email is not valid';
        }

        $subscribe = Subscriber::where('email', '=', $email)->get()->count();

        if ($subscribe > 0) {
            $op_array['response'] = 'error';
            $op_array['message'] = app()->getLocale() == 'ar' ? 'انت مشترك معنا بالفعل' : 'Already with us';
        } else {
            Subscriber::insert(['email' => $email]);
        }

        return json_encode($op_array);
    }
}
