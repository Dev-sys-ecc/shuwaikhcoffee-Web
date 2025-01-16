<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\MegaMailer;
use App\Models\User;
use GuzzleHttp\Client;
use Auth;
use Session;
use App\Models\Language;
use Config;
use App\Models\BasicSetting as BS;
use App\Models\BasicExtended as BE;


class RegisterController extends Controller
{

    public function __construct()
    {
        $this->middleware('setlang');
        $bs = BS::first();
        $be = BE::first();

        Config::set('captcha.sitekey', $bs->google_recaptcha_site_key);
        Config::set('captcha.secret', $bs->google_recaptcha_secret_key);
    }

    public function registerPage()
    {
         return view('front.ShuwaikhCoffe.auth.signup');
    }

    public function register(Request $request)
    {

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;

        $rules = [
            'email'    => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'number'    => 'required|unique:users|regex:/^(\+)?[0-9]+$/',
            'password' => 'required|confirmed'
        ];


        $request->validate($rules);

        $user = new User;
        $input = $request->all();
        $input['status'] = 1;
        $input['password'] = bcrypt($request['password']);
        $user->email_verified = 'Yes';
        $user->fill($input)->save();

        Auth::guard('web')->login($user);
        return redirect()->route('front.index')->with('success', 'Registerd Successfully');
    }
    public function token($token)
    {
        $user = User::where('verification_link', $token)->first();
        if ($user->email_verified == 'Yes') {
            return view('errors.404');
        }
        if (isset($user)) {
            $user->email_verified = 'Yes';
            $user->update();
            Auth::guard('web')->login($user);
            Session::flash('success', 'Email Verified Successfully');
            return redirect()->route('user-dashboard');
        }
    }
}
