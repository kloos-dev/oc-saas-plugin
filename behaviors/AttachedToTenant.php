<?php namespace Kloos\Saas\Behaviors;

use Model;
use Form as FormHelper;
use Kloos\Saas\Models\Tenant;
use Kloos\Saas\Classes\TenantScope;
use October\Rain\Extension\ExtensionBase;

class AttachedToTenant extends ExtensionBase
{
    protected $parent;

    public function __construct(Model $parent)
    {
        $this->parent = $parent;
        $this->attachModelToTenantModel();

        $model = $this->parent;
        $this->parent->bindEvent('model.beforeCreate', function () use ($model) {
            $active = \Kloos\Saas\Classes\Tenant::instance()->active();
            $sessionKey = FormHelper::getSessionKey();

            if ($active) {
                $model->tenants()->add($active, $sessionKey);
            }
        });

        \Kloos\Saas\Classes\Tenant::instance()->registerModel(get_class($this->parent));

        $this->registerGlobalScope();
    }

    protected function registerGlobalScope()
    {
        $this->parent->addGlobalScope(new TenantScope);
    }

    protected function attachModelToTenantModel()
    {
        $this->parent->morphToMany['tenants'] = [
            Tenant::class,
            'name' => 'tenant_relation',
            'table' => 'kloos_saas_tenants_relations',
        ];
    }
}