<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $loginPath = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Authenticate the user with Twitter.
     *
     * @return Response
     */
    public function authenticate()
    {
        return Socialite::with('twitter')->redirect();
    }

    /**
     * Handle the authentication callback from Twitter.
     *
     * @return Response
     */
    public function handleTwitterCallback()
    {
        $twitter = Socialite::with('twitter')->user();

        $user = User::where('twitter_id', $twitter->id)->first();

        if ($user) {
            Auth::login($user);
        } else {
            Auth::login($user = User::create([
                'name' => $twitter->name,
                'twitter_id' => $twitter->id,
            ]));
        }

        return redirect('/');
    }

    public function localLogin()
    {
        if (! App::environment('local')) {
            abort(404);
        }

        Auth::login(User::first());

        return redirect('/dashboard');
    }
}
