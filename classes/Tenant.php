<?php namespace Kloos\Saas\Classes;

use DB;
use Session;
use October\Rain\Support\Traits\Singleton;
use Kloos\Saas\Models\Tenant as TenantModel;

class Tenant
{
    use Singleton;

    protected $tenantModels = [];

    protected $activeTenant = null;

    public function init()
    {
    }

    public function switch($tenant)
    {
        if (!$tenant) {
            return;
        }

        Session::put('active_tenant_slug', $tenant->slug);
        $this->activeTenant = $tenant;
    }

    public function active()
    {
        return $this->activeTenant;
    }

    public function forget()
    {
        Session::forget('active_tenant_slug');
    }

    public function registerModel($model)
    {
        if (in_array($model, $this->tenantModels)) {
            return;
        }

        $this->tenantModels[] = $model;
    }

    public function getModels()
    {
        return $this->tenantModels;
    }

    public function getControllerConfig()
    {
        $config = [
            'backend_users' => [
                'label' => 'User',
                'manage' => [
                    'form' => '$/kloos/saas/controllers/tenants/backend_user_fields.yaml',
                ],
                'view' => [
                    'toolbarButtons' => [
                        'link',
                        'unlink',
                    ],
                    'list' => '~/modules/backend/models/user/columns.yaml',
                ],
            ],
        ];

        foreach ($this->getModels() as $model) {
            $explodedModelName = explode('\\', $model);

            // Add the model to the config
            $modelConfig = [
                snake_case($model) => [
                    'label' => strtolower($explodedModelName[count($explodedModelName)[-1]])
                ],
            ];

            $config = array_merge($config, $modelConfig);
        }

        return $config;
    }

    public function disableScopes()
    {
        return str_contains(request()->url(), 'backend/auth');
    }
}