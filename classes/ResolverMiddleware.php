<?php namespace Kloos\Saas\Classes;

use Closure;
use Kloos\Saas\Classes\Tenant;
use Kloos\Saas\Models\Settings;

class ResolverMiddleware
{
    public function handle($request, Closure $next)
    {
        $tenant = null;

        // Loop through all the resolvers
        foreach (Settings::get('resolvers') as $resolver) {
            $resolver = new $resolver['resolver'];
            $tenant = $resolver->run($request);
        }

        if ($tenant) {
            //ray($tenant);

            Tenant::instance()->switch($tenant);
        } else {
            // Todo: There is something wrong. Show a message...
        }

        return $next($request);
    }
}