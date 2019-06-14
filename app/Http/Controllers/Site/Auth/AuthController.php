<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Controller;
use Hash;
use Mail;
use Auth;
use App\Member;
use Illuminate\Http\Request;
use App\SocialLogin;
use Socialite;

class AuthController extends Controller {

    public function __construct(Request $request) {



        $this->middleware('guest.site', ['except' => ['logout', 'getLogout']]);
        parent::__construct($request);
    }

    public function getLogin() {
        return view('site.auth.login');
    }

    public function getRegister() {
        return view('site.auth.register');
    }

    public function postLogin(Request $r) {
// 1- Validator::make()
// 2- check if fails
// 3- fails redirect or success not redirect

        $return = [
            'response' => 'success',
            'message' => 'تم تسجيل دخولك بنجاح',
            'url' => route('site.home')
        ];

// grapping admin credentials
        $name = $r->input('email');
        $password = $r->input('password');
// Searching for the admin matches the passed email or adminname
        $admin = Member::Where('email', $name)->first();

        if ($admin && Hash::check($password, $admin->password)) {
// login the admin
            if ($admin->active == 0) {
                $return = [
                    'response' => 'error',
                    'message' => trans('trans.activation need')
                ];
            } else if ($admin->active == 1) {
                Auth::guard('members')->login($admin, $r->has('remember'));
            } else if ($admin->active == -1) {
                $return = [
                    'response' => 'error',
                    'message' => trans('trans.invlaidlogin')
                ];
            }
        } else {
            $return = [
                'response' => 'error',
                'message' => trans('trans.invlaidlogin')
            ];
        }
        return response()->json($return);
    }

    public function getLogout() {
//        die();
        Auth::guard('members')->logout();
        return redirect('/login')->with('info', trans('admin_global.msg_success_logout'));
    }

    public function postRegister(Request $r) {

        $v = validator($r->all(), [
            'name' => 'required|min:2',
            'email' => 'required|email|unique:members',
            'membershiptype' => 'required',
            'password' => 'required',
            'confirmpassword' => 'required|same:password',
                ], [
            'email.unique' => trans('trans.email_exist'),
        ]);

        if ($v->fails()) {
            return ['status' => false, 'data' => implode(PHP_EOL, $v->errors()->all())];
        }

        $member = new Member();
        $member->name = $r->input('name');
        $member->membershiptype = $r->input('membershiptype');

        $member->email = $r->input('email');
        $member->password = bcrypt($r->input('password'));

        if ($r->input('membershiptype') == 'user') {
            $member->active = 1;
        }

        if ($member->save()) {

            if ($r->input('membershiptype') == 'user') {
                Auth::guard('members')->login($member, $r->has('remember'));
                return [
                    'response' => 'success',
                    'message' => 'Registered successfully',
                    'url' => route('site.home')
                ];
            }
            return [
                'response' => 'success',
                'message' => 'Registered successfully Wait Acount Activation From Admin',
                'url' => route('site.home')
            ];

//            Mail::send('site.mails.confirm', compact('member'), function ($m) use ($member) {
//                $m->to($member->email, $member->name)->subject('Your Reminder!');
//            });
        }

//         return redirect()->intended('/')->with("success",'members registered successfully');
        return redirect()->back()->with('error', 'username or password are not correct');
    }

    public function getProfile() {
        return view('site.auth.profile');
    }

    public function getRecoverPassword() {
        return view('site.auth.recover-password');
    }

    public function getChangePassword($hash) {

        $site = Member::where('recover_hash', $hash)->first();

        if ($site) {
            return view('site.auth.new-password', compact('hash'));
        }

// failed
        return redirect('auth/login')->with('msg', 'incorrect data');
    }

    public function postRecoverPassword(Request $r) {

        $this->validate($r, [
            'email' => 'required|email',
        ]);

// grapping site credentials
        $email = $r->input('email');

        $site = Member::where('email', $email)->first();

        if ($site) {
            $recover_hash = str_random(128);

            $site->update(compact('recover_hash'));

            Mail::send('site.mails.recover-password', compact('site', 'recover_hash'), function ($m) use ($site) {
                $m->to($site->email, $site->name)->subject('Your Reminder!');
            });

            return redirect('auth/login');
        }
// failed
        return redirect()->back()->with('msg', 'اincorrect data');
// dd($r->all());
    }

    public function postChangePassword(Request $r) {

// Searching for the site matches the recover_hash
        $site = Member::where('recover_hash', $r->input('_hash'))->first();

        if ($site) {

            $this->validate($r, [
                'password' => 'required|password',
                'repassword' => 'required|same:password',
            ]);

// grapping site credentials
            $password = bcrypt($r->input('password'));
            $recover_hash = null;

            $site->update(compact('password', 'recover_hash'));

            return redirect('auth/login')->with('msg', 'incorrect data');
        }
// failed
        return redirect()->back()->with('msg', 'incorrect data');
    }

    /**
     * Redirect the user to the provider authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider) {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from the provider.
     *
     * @return Response
     */
    public function handleProviderCallback($provider) {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/');
        }

//check if we have logged provider
        $socialProvider = SocialLogin::where('provider_id', $socialUser->getId())
                        ->where('provider_type', $provider)->first();

        if (!$socialProvider or ( $socialProvider and ! $socialProvider->user)) {
//create a new user and provider
            $user = Member::where(['email' => $socialUser->getEmail()])->first();

            if ($user) {
                return redirect(route('site.home'))->withFancy([
                            'status' => 'warning',
                            'title' => trans('global.msg_title.error_login'),
                            'msg' => trans('global.msg.warning_account_taken'),
                ]);
            }

            $name = explode(' ', $socialUser->getName());

            $user = Member::create([
                        'email' => $socialUser->getEmail(),
                        'image' => $socialUser->getAvatar(),
                        'f_name' => $name[0],
                        'l_name' => end($name),
                        'password' => $provider,
                        'active' => 1,
            ]);

            if ($socialProvider and ! $socialProvider->user) {
                $user->social()->save($socialProvider);
            } else {
                $user->social()->create(
                        ['provider_id' => $socialUser->getId(), 'provider_type' => $provider]
                );
            }
        } else {
            $user = $socialProvider->user;
        }

        auth()->guard('members')->login($user, true);

        return redirect('/');
    }

}
