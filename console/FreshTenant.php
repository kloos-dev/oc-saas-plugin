<?php namespace Kloos\Saas\Console;

use DB;
use Config;
use Artisan;
use Kloos\Saas\Classes\Tenant;
use Illuminate\Console\Command;
use Kloos\Saas\Models\Tenant as TenantModel;
use Symfony\Component\Console\Input\InputArgument;

class FreshTenant extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'tenant:fresh';

    /**
     * @var string The console command description.
     */
    protected $description = 'Provides the tenant with a fresh DB. Deletes all data so be carefull.';

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
            $this->freshTenant($tenant);
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

    public function freshTenant($tenant)
    {
        $this->output->writeln('Start migration for tenant ' . $tenant->name);
        Tenant::instance()->switch($tenant);

        Config::set('database.default', 'tenant');

        // Delete database
        $schemaName = Tenant::instance()->getDatabaseName();
        $query = "DROP DATABASE $schemaName;";
        DB::statement($query);

        // Cleanup
        Tenant::instance()->forget();

        //
        $this->output->writeln('Database deleted');

        Artisan::call('tenant:migrate', ['tenantId' => $tenant->id]);

        $this->output->writeln('Migration ran successfully');

        Tenant::instance()->forget();
    }
}
