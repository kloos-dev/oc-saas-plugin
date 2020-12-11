<?php namespace Kloos\Saas\Console;

use DB;
use Config;
use Artisan;
use Kloos\Saas\Classes\Tenant;
use Illuminate\Console\Command;
use Kloos\Saas\Models\Tenant as TenantModel;
use Symfony\Component\Console\Input\InputArgument;

class MigrateTenant extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'tenant:migrate';

    /**
     * @var string The console command description.
     */
    protected $description = 'Migrates tenants and creates databases';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $tenantId = $this->argument('tenantId');

        if ($tenantId) {
            $tenants = collect([TenantModel::find($tenantId)]);
        } else {
            $tenants = TenantModel::all();
        }

        foreach ($tenants as $tenant) {
            $this->migrateTenant($tenant);
        }
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['tenantId', InputArgument::OPTIONAL, 'The tenant to run the migration for']
        ];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

    public function migrateTenant($tenant)
    {
        $this->output->writeln('Start migration for tenant ' . $tenant->name);
        Tenant::instance()->switch($tenant);

        // Set default connection to tenant
        Config::set('database.default', 'tenant');

        // Start the migration
        Artisan::call('october:up');

        //
        $this->output->writeln('Migration ran successfully');

        Tenant::instance()->forget();
    }
}
