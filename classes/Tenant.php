<?php namespace Kloos\Saas\Classes;

use DB;
use Session;
use October\Rain\Support\Traits\Singleton;
use Kloos\Saas\Models\Tenant as TenantModel;

class Tenant
{
    use Singleton;


    protected $tenantModels = [];

    public function init()
    {
    }

    public function switch(TenantModel $tenant)
    {
        Session::put('active_tenant_slug', $tenant->slug);
    }

    public function active()
    {
        if (Session::has('active_tenant_slug')) {
            $slug = Session::get('active_tenant_slug');
            return TenantModel::bySlug($slug);
        } else {
            // TODO: Resolve active tenant...
        }
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
                        'create',
                        'delete',
                        'link',
                        'unlink',
                    ],
                    'list' => '~/modules/backend/models/user/columns.yaml',
                ],
            ],
        ];

        foreach ($this->getModels() as $model) {
            $explodedModelName = explode('\\', $model);
            $modelName = 'Test';

            // Add the model to the config
            $modelConfig = [
                snake_case($model) => [
                    'label' => strtolower($explodedModelName[count($explodedModelName)[-1]])
                ],
            ];

            $config = array_merge($config, $modelConfig);
        }

        dd($config);

        return $config;
    }
}