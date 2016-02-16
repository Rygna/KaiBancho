<?php

namespace App\Http\Controllers\Auth;

use App\OsuUserStats;
use App\TaikoUserStats;
use App\ManiaUserStats;
use App\CTBUserStats;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:20|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt(md5($data['password'])),
            'banned' => 0,
            'country' => 0,
            'usergroup' => 0,
            'avatar' => ""
        ]);
        $user->OsuUserStats()->save(new OsuUserStats(array('level' => 0)));
        $user->TaikoUserStats()->save(new TaikoUserStats(array('level' => 0)));
        $user->ManiaUserStats()->save(new ManiaUserStats(array('level' => 0)));
        $user->CTBUserStats()->save(new CTBUserStats(array('level' => 0)));
        return $user;
    }
}
