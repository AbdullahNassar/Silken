<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Member;
use App\Locale;
use Auth;
use Config;
use Carbon\Carbon;
use Mail;
class MembersController extends Controller {

    public function getIndex() {
        $members = Member::get();
        return view('admin.pages.members.index', compact('members'));
    }

     public function postAdd(Request $r) {
        $v = validator($r->all(), [
            "f_name" => 'required|min:2',
            "l_name" => 'required|min:2|unique:users,l_name',
            "address" => 'required|min:2',
            "phone" => 'required|min:10|numeric',
            "email" => 'required|email|unique:users,email',
            "password" => 'required|password|min:8',
            "repassword" => 'required|same:password',
        ]
        ,[
            'f_name.required' => 'Please full name',
            'f_name.min' => 'full name should be at least 1 word',
            'l_name.required' => 'Please user name',
            'l_name.min' => 'user name should be at least 1 word',
            'email.required' => 'Please enter email',
            'email.email' => ' email should be in correct format',
            'address.required' => 'Please enter  address',
            'address.min' => ' address should be at least one word',
            'phone.required' => 'Please enter  phone number',
            'phone.min' => ' phone number should be at least 10 numbers',
            'password.required' => 'Please enter password',
            'repassword.required' => 'Please enter  repassword',
            'repassword.same' => 'Please enter similar password',

        ]);

        // if the validation has been failed return the error msgs
        if ($v->fails()) {
            return ['status' => false, 'data' => implode(PHP_EOL, $v->errors()->all())];
        }

       $member = new Member;

        // set data for the new created data
        $member->f_name = $r->f_name;
        $member->l_name = $r->l_name;
        $member->email = $r->email;
        $member->phone = $r->phone;
        $member->address = $r->address;
        $member->password = bcrypt($r->password);
        $member->active = $r->active;

        // add the new ad data
        if ($member->save()) {
       
            return ['status' => true, 'data' => ' Member added seccessfully.'];
        }

        // return an error if there's un expected action occured
        return ['status' => false, 'data' => 'unexpected error .. please try again'];
    }


    public function postActive(Request $request){
        if ($request->ajax()) {
            $member = Member::find($request->id);
            $member->active = 1;

            if($member->save()){
//                Mail::send('admin.mails.active-member',
//                compact('member'),
//                function ($m) use ($member) {
//                    $m->to($member->email, $member->name)->subject('Registeration Mail !');
//                });
                return response()->json('success');

            }
        }
    }

    public function postDisActive(Request $request){
        if ($request->ajax()) {
            $member = Member::find($request->id);
            $member->active = 0;
            $member->save();

//            Mail::send('admin.mails.disactive-member',
//            compact('member'),
//            function ($m) use ($member) {
//                $m->to($member->email, $member->name)->subject('Activation Mail !');
//            });
            return response()->json('success');
        }
    }

    public function postBlock(Request $request){
        if ($request->ajax()) {
            $member = Member::find($request->id);
            $member->active =-1;
            $member->save();

//            Mail::send('admin.mails.block-member',
//            compact('member'),
//            function ($m) use ($member) {
//                $m->to($member->email, $member->f_name)->subject('Registeration Mail !');
//            });
            return response()->json('success');
        }
    }

    public function getDelete($id = null) {
        $member = Member::find($id);

        $member->delete();

        return redirect()->back();
    }

   
}
