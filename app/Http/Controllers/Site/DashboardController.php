<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Member;
use App\Order;
use Hash;
//use Illuminate\Pagination\LengthAwarePaginator;
//use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class DashboardController extends Controller {

    public function getIndex(Request $request) {
        return view('site.pages.dashboard.index');
    }

    public function accountsettings(Request $request) {
        return view('site.pages.dashboard.accountsettings');
    }

    public function address(Request $request) {
//        die(var_dump(json_decode(auth()->guard('members')->user()->shipping_address)->name));
        return view('site.pages.dashboard.address');
    }

    public function addresspost(Request $request) {
        if ($request->input('type') == 'payment' || $request->input('type') == 'shipping') {
            $member = Member::Where('id', auth()->guard('members')->user()->id)->first();
            $address = array();
            $address['name'] = $request->input('name');
            $address['address'] = $request->input('address');
            $address['phone'] = $request->input('phone');
            if ($request->input('type') == 'payment') {
                $member->payment_address = json_encode($address);
            }
            if ($request->input('type') == 'shipping') {
                $member->shipping_address = json_encode($address);
            }
            


            if ($member->save()) {
                
            }
            return response()->json([
                        'response' => 'success',
                        'message' => 'تم تغير البيانات  بنجاح',
                        'url' => route('site.dashboard.address')
            ]);
        }
    }

    public function orders(Request $request) {

        $orders = Order::latest()->where('member_id', auth()->guard('members')->user()->id)->get();
//        die(var_dump(strtotime($orders[0]->products[0]->created_at)));


        return view('site.pages.dashboard.orders', compact('orders'));
    }

    public function accountsettingspost(Request $r) {
        $passwordchange = false;
        $old_email = auth()->guard('members')->user()->email;
        $name = $r->input('name');
        $email = $r->input('email');
        $password = $r->input('password');
// Searching for the admin matches the passed email or adminname
        $member = Member::Where('email', $old_email)->first();
        if (!($member && Hash::check($password, $member->password))) {
            return response()->json([
                        'response' => 'error',
                        'message' => trans('trans.invalidpassword')
            ]);
        }
        if ($old_email != $email && Member::Where('email', $email)->first()) {
            return response()->json([
                        'response' => 'error',
                        'message' => trans('trans.emailexist')
            ]);
        }
        $newpassword = $r->input('newpassword');
        $confirmpassword = $r->input('confirmpassword');
        if ($newpassword || $confirmpassword) {
            if ($newpassword != $confirmpassword) {
                return response()->json([
                            'response' => 'error',
                            'message' => trans('trans.new password not math confrm')
                ]);
            }
            if ($newpassword == $password) {
                return response()->json([
                            'response' => 'error',
                            'message' => trans('trans.new password must not equal old password')
                ]);
            }
            $member->password = bcrypt($newpassword);
        }


        $member->name = $name;
        $member->email = $email;
        if ($member->save()) {
            
        }
        return response()->json([
                    'response' => 'success',
                    'message' => 'تم تغير الاعدادات  بنجاح',
                    'url' => route('site.dashboard.accountsettings')
        ]);
    }

}
