<?php namespace Kloos\Saas\Classes;

use Closure;
use Kloos\Saas\Classes\Tenant;
use Kloos\Saas\Models\Tenant as TenantModel;

class ResolveTenantByDomainMiddleware
{
    public function handle($request, Closure $next)
    {
        $domain = $request->getHost();
        $tenant = TenantModel::byDomain($domain);

        Tenant::instance()->switch($tenant);

        return $next($request);
    }
}