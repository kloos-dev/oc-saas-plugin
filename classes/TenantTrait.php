<?php namespace Kloos\Saas\Classes;

use October\Rain\Extension\ExtensionBase;

class TenantTrait extends ExtensionBase
{
    public function __construct($model)
    {
        if (!Tenant::instance()->active()) {
            $model->setConnection('mysql');
            return;
        }

        $model->setConnection('tenant');
    }
}