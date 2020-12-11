<?php

Route::get('/test-tenant', function () {

    dd(config('database'));

})->middleware('\Kloos\Saas\Classes\ResolveTenantByDomainMiddleware');