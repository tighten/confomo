<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $loginPath = '/';

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
        try {
            $twitter = Socialite::with('twitter')->user();
        } catch (InvalidArgumentException $e) {
            return redirect('/');
        }

        $user = User::updateOrCreate(['twitter_id' => $twitter->id], [
            'name' => $twitter->name,
            'username' => $twitter->username,
        ]);

        Auth::login($user, true);

        return redirect('/');
    }

    public function localLogin()
    {
        if (! App::environment('local')) {
            abort(404);
        }

        Auth::login(User::first(), true);

        return redirect('/dashboard');
    }
}
