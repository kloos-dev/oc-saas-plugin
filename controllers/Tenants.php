<?php namespace Kloos\Saas\Controllers;

use Flash;
use Artisan;
use BackendMenu;
use Backend\Models\User;
use Kloos\Saas\Models\Tenant;
use Backend\Classes\Controller;
use System\Classes\SettingsManager;
use Kloos\Saas\Classes\DatabaseManager;

/**
 * Tenants Back-end Controller
 */
class Tenants extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
    ];

    /**
     * @var string Configuration file for the `FormController` behavior.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';

    /**
     * @var string Configuration file for the `RelationController` behavior.
     */
    public $relationConfig = 'config_relations.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('Kloos.Saas', 'tenants');
    }

    public function onRefreshDatabase($id)
    {
        Artisan::call('tenant:fresh', ['tenantId' => $id]);
        Flash::success('Successfully refreshed the database!');
    }

    public function onUpdateDatabase($id = null)
    {
        if ($id === null) {
            Artisan::call('tenant:migrate');
            Flash::success('Successfully migrated all databases!');
        } else {
            Artisan::call('tenant:migrate', ['tenantId' => $id]);
            Flash::success('Successfully migrated the database!');
        }
    }

    public function create()
    {
        $this->bodyClass = 'compact-container';
        $this->asExtension('FormController')->create();
    }

    public function update($id)
    {
        $this->bodyClass = 'compact-container';
        $this->asExtension('FormController')->update($id);
    }
}
