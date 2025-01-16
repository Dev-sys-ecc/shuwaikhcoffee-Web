<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Language;
use Config;
use App\Models\BasicSetting as BS;
use App\Models\BasicExtended as BE;
use App\Models\User;
use Socialite;
use Redirect;

use function GuzzleHttp\json_decode;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'userLogout']]);
        $this->middleware('setlang');
        $bs = BS::first();
        $be = BE::first();

        Config::set('captcha.sitekey', $bs->google_recaptcha_site_key);
        Config::set('captcha.secret', $bs->google_recaptcha_secret_key);

        Config::set('services.facebook.client_id', $be->facebook_app_id);
        Config::set('services.facebook.client_secret', $be->facebook_app_secret);
        Config::set('services.facebook.redirect', url('login/facebook/callback'));

        Config::set('services.google.client_id', $be->google_client_id);
        Config::set('services.google.client_secret', $be->google_client_secret);
        Config::set('services.google.redirect', url('login/google/callback'));
    }

    public function showLoginForm()
    {
        if (strpos(session()->get('link'), 'qr-menu') !== false) {
            session()->forget('link');
        }

        return view('front.ShuwaikhCoffe.auth.login');
    }

    public function login(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;

        $rules = [
            'username'   => 'required',
            'password' => 'required'
        ];


        $request->validate($rules);

        if (Session::has('link')) {
            $redirectUrl = Session::get('link');
            Session::forget('link');
        } else {
            $redirectUrl = route('front.index');
        }

        // Attempt to log the user in
        if (Auth::guard('web')->attempt(['username' => $request->username, 'password' => $request->password])) {

            // Check If Email is verified or not
            if (Auth::guard('web')->user()->email_verified == 'no' || Auth::guard('web')->user()->email_verified == 'No') {
                Auth::guard('web')->logout();

                return back()->with('err', __('Your Email is not Verified!'));
            }
            if (Auth::guard('web')->user()->status == '0') {
                Auth::guard('web')->logout();

                return back()->with('err', __('Your account has been banned'));
            }
            //here
            return redirect($redirectUrl)->with('success' , 'Logged in successfully');
        }
        return back()->with('err', __("Credentials Doesn't Match !"));
    }


    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/')->with('success' , 'Logout successfully');
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        return $this->authUserViaProvider('facebook');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        return $this->authUserViaProvider('google');
    }

    public function authUserViaProvider($provider) {
        if (Session::has('link')) {
            $redirectUrl = Session::get('link');
            Session::forget('link');
        } else {
            $redirectUrl = route('user-profile');
        }

        $user = Socialite::driver($provider)->user();
        if ($provider == 'facebook') {
            $user = json_decode(json_encode($user), true);
        } elseif ($provider == 'google') {
            $user = json_decode(json_encode($user), true)['user'];
        }


        if ($provider == 'facebook') {
            $fname = $user['name'];
            $photo = $user['avatar'];
        } elseif ($provider == 'google') {
            $fname = $user['given_name'];
            $photo = $user['picture'];
        }
        $email = $user['email'];
        $provider_id = $user['id'];


        $user = User::where('email', $email)->first();

        if (empty($user)) {
            $user = new User;
            $user->email = $email;
            $user->username = $fname;
            $user->photo = $photo;
            $user->provider_id = $provider_id;
            $user->provider = $provider;
            $user->status = 1;
            $user->email_verified = 'Yes';
            $user->save();
        }


        Auth::guard('web')->login($user);

        if ($user->status == 0) {
            Auth::guard('web')->logout();
            return redirect(route('user.login'))->with('err', __('Your account has been banned'));
        }

        return redirect($redirectUrl);

    }
}
