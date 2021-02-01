<?php namespace Kloos\Saas\Classes\Resolver;

use Auth;
use Kloos\Saas\Models\Tenant;

class User
{
    public function run($request)
    {
        $user = Auth::getUser();

        if (!$user) {
            return null;
        }

        return Tenant::byUser($user);
    }
}