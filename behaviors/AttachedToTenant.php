<?php namespace Kloos\Saas\Behaviors;

use Model;
use Form as FormHelper;
use Kloos\Saas\Classes\Tenant;
use Kloos\Saas\Classes\TenantScope;
use October\Rain\Extension\ExtensionBase;
use Kloos\Saas\Models\Tenant as TenantModel;

class AttachedToTenant extends ExtensionBase
{
    protected $parent;

    public function __construct($parent)
    {
        $this->parent = $parent;
        $this->attachModelToTenantModel();
        $model = $this->parent;

        Tenant::instance()
            ->registerModel(get_class($this->parent));

        $this->parent->bindEvent('model.beforeCreate', function () use ($model) {
            $active = Tenant::instance()->active();
            $sessionKey = FormHelper::getSessionKey();

            if ($active && !$model->tenants->contains($active)) {
                $model->tenants()->add($active, $sessionKey);
            }
        }, 1);

        $tenant = Tenant::instance()->active();

        if (!$this->parent->scopeBlacklist && $tenant && !$tenant->is_landlord) {
            $this->registerGlobalScope();
        }
    }

    protected function registerGlobalScope()
    {
        $this->parent->addGlobalScope(new TenantScope);
    }

    protected function attachModelToTenantModel()
    {
        $this->parent->morphToMany['tenants'] = [
            TenantModel::class,
            'name' => 'tenant_relation',
            'table' => 'kloos_saas_tenants_relations',
        ];
    }
}