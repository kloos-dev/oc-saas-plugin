<?php namespace Kloos\Saas\Classes;

use Config;

class DatabaseManager
{
	public function __construct()
	{
	}
	
	public function switch($databaseName)
	{
		$this->databaseName = $databaseName;
		$this->getDatabaseName();
	}
	
	public function getDatabaseName()
	{
		$prefix = config('kloos.saas::config.tenantDatabasePrefix', 'tenant_');
		$this->databaseName = $prefix . $databaseName;
		return $this->databaseName;
	}
	
	public function updateConnectionConfig()
	{
		Config::set('database.connections.tenant.database', $this->databaseName);
		DB::purge('tenant');
	}
}