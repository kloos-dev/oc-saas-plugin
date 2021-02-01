<?php namespace Kloos\Saas\Classes\Resolver;

use Closure;
use Kloos\Saas\Classes\Tenant;
use Kloos\Saas\Models\Tenant as TenantModel;

class Domain
{
    public function run($request)
    {
        $domain = $request->getHost();
        return TenantModel::byDomain($domain);
    }
}