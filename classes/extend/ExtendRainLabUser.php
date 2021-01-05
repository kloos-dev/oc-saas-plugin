<?php namespace Kloos\Saas\Classes\Extend;

use Kloos\Saas\Models\Tenant;
use System\Classes\PluginManager;

class ExtendRainLabUser
{
    protected $model;

    public function subscribe()
    {
        if (!PluginManager::instance()->exists('RainLab.User')) {
            return;
        }

        \RainLab\User\Models\User::extend(function ($model) {
            $this->model = $model;

            $this->addMethods();
            $this->addRelations();
            $this->addImplements();
        });
    }

    protected function addMethods()
    {
        $model = $this->model;

        $model->addDynamicMethod('hasAccessToTenant', function ($tenant) use ($model) {
            if (!$tenant) {
                return false;
            }

            return $tenant->users->contains($model);
        });
    }

    protected function addRelations()
    {
        $model = $this->model;

        $model->morphToMany['tenants'] = [
            Tenant::class,
            'name' => 'tenant_relation',
            'table' => 'kloos_saas_tenants_relations',
        ];
    }

    protected function addImplements()
    {
        $model = $this->model;
        $model->implement[] = 'Kloos.Saas.Behaviors.AttachedToTenant';
    }
}