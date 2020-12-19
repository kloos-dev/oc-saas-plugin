<?php namespace Kloos\Saas\Classes\Extend;

use Event;
use Backend\Models\User;
use Backend\Widgets\Form;
use Kloos\Saas\Models\Tenant;
use Backend\Controllers\Users;
use Backend\Classes\Controller;

class ExtendBackendUser
{
    protected $model;

    public function subscribe()
    {
        User::extend(function (User $model) {
            $this->model = $model;

            $this->addMethods();
            $this->addRelations();
            $this->addImplements();
        });

        Users::extend(function (Controller $controller) {
            $controller->implement[] = 'Backend\Behaviors\RelationController';
            $controller->addDynamicProperty('relationConfig', '$/kloos/saas/classes/extend/backend_user_relations.yaml');
        });
    }

    protected function addImplements()
    {
        $model = $this->model;

        $model->implement[] = 'Kloos.Saas.Behaviors.AttachedToTenant';
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

    protected function addMethods()
    {
        $model = $this->model;

        $model->addDynamicMethod('hasAccessToTenant', function ($tenant) use ($model) {
            if (!$tenant && !$model->isSuperUser()) {
                return false;
            }

            if (!$tenant && $model->isSiperUser()) {
                return true;
            }

            return $tenant->backend_users->contains($model);
        });
    }
}