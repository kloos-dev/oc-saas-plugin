<?php namespace Kloos\Saas\Controllers;

use App;
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
    public $requiredPermissions = [
        'kloos.saas.manage_tenants',
        'kloos.saas.manage_own_tenant',
    ];

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

        if ($this->user->hasPermission('kloos.saas.manage_own_tenant') && !$this->user->isSuperUser()) {
            SettingsManager::setContext('Kloos.Saas', 'my-tenant');
        } else {
            SettingsManager::setContext('Kloos.Saas', 'tenants');
        }
    }

    public function index()
    {
        if (!$this->user->hasAccess('kloos.saas.manage_tenants')) {
            return App::abort(403, 'No access');
        }

        $this->asExtension('ListController')->index();
    }

    public function create()
    {
        if (!$this->user->hasAccess('kloos.saas.manage_tenants')) {
            return App::abort(403, 'No access');
        }

        $this->bodyClass = 'compact-container';
        $this->asExtension('FormController')->create();
    }

    public function update($id)
    {
        $tenant = Tenant::find($id);

        if (!$this->user->tenants->contains($tenant)) {
            if (!$this->user->isSuperUser()) {
                return App::abort(403, 'No access');
            }
        }

        $this->bodyClass = 'compact-container';
        $this->asExtension('FormController')->update($id);
    }
}
