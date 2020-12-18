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
        $this->tenantModels[] = $model;
    }

    public function getModels()
    {
        return $this->tenantModels;
    }
}