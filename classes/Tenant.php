<?php namespace Kloos\Saas\Classes;

use DB;
use Session;
use October\Rain\Support\Traits\Singleton;
use Kloos\Saas\Models\Tenant as TenantModel;

class Tenant
{
    use Singleton;

    protected $databaseManager;

    public function init()
    {
        $this->databaseManager = new DatabaseManager;
    }

    public function switch(TenantModel $tenant)
    {
        Session::put('active_tenant_slug', $tenant->slug);
        $this->databaseManager->switch($tenant->slug);
    }

    public function getDatabaseName()
    {
        return $this->databaseManager->databaseName;
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
        $this->databaseManager->reset();
        Session::forget('active_tenant_slug');
    }
}