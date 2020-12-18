<?php namespace Kloos\Saas\Classes\Extend;

use Event;
use October\Rain\Parse\Yaml;
use Kloos\Saas\Classes\Tenant;
use Kloos\Saas\Controllers\Tenants;
use Kloos\Saas\Classes\TenantManager;

class ExtendTenant
{
    public function subscribe()
    {
        Event::listen('backend.form.extendFields', function ($formWidget) {
            if (!$formWidget->getController() instanceof Tenants) {
                return;
            }

            if (!$formWidget->model instanceof \Kloos\Saas\Models\Tenant) {
                return;
            }


            $models = Tenant::instance()->getModels();
            $controller = $formWidget->getController();

            foreach ($models as $model) {
                //dd($formWidget);
            }
        });
    }
}