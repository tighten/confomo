<?php namespace Confomo\Providers;

use Confomo\Entities\Conference;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Redirect;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Confomo\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        $router->filter('authConf', function ($route, $request) {
            $conference_id = $route->getParameter('conference_id');
            $conference = Conference::find($conference_id);

            if (! $conference || ! Auth::user() || $conference->user_id != Auth::user()->id) {
                $messages = new MessageBag;
                $messages->add('Validation Error', 'Conference does not exist or you do not have access to that conference.');
                return Redirect::back()
                    ->withErrors($messages)
                    ->withInput();
            }
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->loadRoutesFrom(app_path('Http/routes.php'));
    }

}
