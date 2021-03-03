<?php namespace Kloos\Saas\Classes\Resolver;

use Auth;
use BackendAuth;
use Kloos\Saas\Models\Tenant;

class User
{
    public function run($request)
    {
        if ($request->is(config('cms.backendUri').'*')) {
            $user = BackendAuth::getUser();
        } else {
            $user = Auth::getUser();
        }

        if (!$user) {
            return null;
        }

        return Tenant::byUser($user);
    }
}