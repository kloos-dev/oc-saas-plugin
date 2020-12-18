<?php namespace Kloos\Saas\Classes\Extend;

use Event;
use Kloos\Saas\Classes\Tenant;

class CmsPage
{
    public function subscribe()
    {
        Event::listen('cms.page.init', function ($page) {
            $page->vars['tenant'] = Tenant::instance()->active();
        });
    }
}