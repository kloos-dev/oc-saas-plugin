<?php namespace Kloos\Saas\Classes;

use Session;
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
		Session::put('active_tenant', $tenant);
		$this->databaseManager->switch($tenant->slug);
	}
	
	public function active()
	{
		if (Session::has('active_tenant')) {
			return Session::get('active_tenant');
		} else {
			// TODO: Resolve active tenant...
		}
	}
}