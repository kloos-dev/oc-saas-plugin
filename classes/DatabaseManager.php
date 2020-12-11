<?php namespace Kloos\Saas\Classes;

use DB;
use Config;

class DatabaseManager
{
    public $databaseName;

    public function switch($databaseName)
    {
        $this->databaseName = $databaseName;
        $this->getDatabaseName();
        $this->updateConnectionConfig();
        $this->checkDatabase();
        DB::purge('tenant');
    }

    public function getDatabaseName()
    {
        if (!$this->databaseName) {
            return null;
        }

        $prefix = config('kloos.saas::config.tenantDatabasePrefix', 'tenant_');
        $this->databaseName = $prefix . $this->databaseName;
        return $this->databaseName;
    }

    public function updateConnectionConfig()
    {
        Config::set('database.connections.tenant.database', $this->databaseName);
    }

    public function reset()
    {
        $this->databaseName = null;
        $this->updateConnectionConfig();
        DB::purge('tenant');
        Config::set('database.default', 'mysql');
    }

    public function checkDatabase()
    {
        if (!$this->databaseName) {
            return;
        }

        $schemaName = $this->databaseName;
        $charset = config("database.connections.tenant.charset", 'utf8mb4');
        $collation = config("database.connections.tenant.collation", 'utf8mb4_unicode_ci');

        // Test database connection
        try {
            DB::connection('tenant')->getPdo();
            return true;
        } catch (\Exception $e) {
            // Create new database
            $query = "CREATE DATABASE IF NOT EXISTS $schemaName CHARACTER SET $charset COLLATE $collation;";
            DB::statement($query);
        }
    }
}