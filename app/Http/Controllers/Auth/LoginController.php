<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
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

        if ($user = User::where('twitter_id', $twitter->id)->first()) {
            Auth::login($user, true);
        } else {
            Auth::login($user = User::create([
                'name' => $twitter->name,
                'twitter_id' => $twitter->id,
            ]), true);
        }

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
