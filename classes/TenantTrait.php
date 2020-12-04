<?php namespace Kloos\Saas\Classes;

class TenantTrait extends ExtensionBase
{
	public function __construct($model)
	{
	}
	
	public function getConnectionName()
	{	
		$tenant = Tenant::active();
		$dm = new DatabaseManager();
		$dm->switch($tenant);
	}
}