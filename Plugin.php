<?php namespace Kloos\Saas;

use Event;
use Backend;
use BackendMenu;
use BackendAuth;
use System\Classes\PluginBase;
use Kloos\Saas\Classes\Tenant;
use Kloos\Saas\Console\FreshTenant;
use Kloos\Saas\Console\MigrateTenant;
use Kloos\Saas\Classes\Extend\CmsPage;
use Kloos\Saas\Classes\Extend\ExtendTenant;
use Kloos\Saas\Classes\Extend\RelatedModel;
use Kloos\Saas\Classes\Extend\ExtendBackendUser;
use Kloos\Saas\Classes\Extend\ExtendRainLabUser;

class Plugin extends PluginBase
{
    public $elevated = true;

    public function pluginDetails()
    {
        return [
            'name'          => 'kloos.saas::lang.plugin.name',
            'description'   => 'kloos.saas::lang.plugin.description',
            'author'        => 'kloos.saas::lang.plugin.author',
        ];
    }

    public function register()
    {
        $this->app['Illuminate\Contracts\Http\Kernel']
            ->pushMiddleware('Kloos\Saas\Classes\ResolveTenantByDomainMiddleware');
    }

    public function boot()
    {
        BackendMenu::registerCallback(function (Backend\Classes\NavigationManager $manager) {
            $user = BackendAuth::getUser();

            if ($user->isSuperUser()) {
                $manager->registerQuickActions('Kloos.Saas', [
                    'tenants' => [
                        'label' => 'Manage tenants',
                        'icon' => 'icon-building',
                        'url' => Backend::url('kloos/saas/tenants'),
                    ],
                ]);
            }

            if ($user->hasPermission('kloos.saas.manage_own_tenant') && !$user->isSuperUser()) {
                $active = Tenant::instance()
                    ->active();

                $manager->addMainMenuItem('Kloos.Saas', 'own-tenant', [
                    'label' => 'kloos.saas::lang.menu.own_tenant',
                    'icon' => 'icon-building',
                    'url' => Backend::url('kloos/saas/tenants/update/' . $active->id)
                ]);
            }
        });

        $this->registerEvents();
    }

    public function registerEvents()
    {
        Event::subscribe(CmsPage::class);
        Event::subscribe(ExtendTenant::class);
        Event::subscribe(RelatedModel::class);
        Event::subscribe(ExtendBackendUser::class);
        Event::subscribe(ExtendRainLabUser::class);
    }

    public function registerPermissions()
    {
        return [
            'kloos.saas.manage_tenants' => [
                'tab' => 'SaaS',
                'label' => 'Manage tenants'
            ],
            'kloos.saas.manage_own_tenant' => [
                'tab' => 'SaaS',
                'label' => 'Manage own tenant',
            ],
        ];
    }

    public function registerFormWidgets()
    {
    }

    public function registerSettings()
    {
        $active = Tenant::instance()
            ->active();

        return [
            'tenants' => [
                'label'       => 'Tenants',
                'description' => 'Manage tenants',
                'category'    => 'Tenants',
                'icon'        => 'icon-building',
                'url'         => Backend::url('kloos/saas/tenants'),
                'order'       => 500,
                'keywords'    => 'tenants multi tenancy saas organisation',
                'permissions' => ['kloos.saas.manage_tenants'],
            ],
            'my-tenant' => [
                'label'       => 'kloos.saas::lang.menu.own_tenant',
                'description' => 'kloos.saas::lang.menu.own_tenant',
                'category'    => 'Tenants',
                'icon'        => 'icon-building',
                'url'         => Backend::url('kloos/saas/tenants/update/' . ($active ? $active->id : '')),
                'order'       => 500,
                'keywords'    => 'tenants multi tenancy saas organisation',
                'permissions' => ['kloos.saas.manage_own_tenant'],
            ],
            'tenant_settings' => [
                'label'         => 'Tenant settings',
                'description'   => 'Manage tenant settings',
                'category'      => 'Tenants',
                'icon'          => 'icon-cog',
                'class'         => 'Kloos\Saas\Models\Settings',
                'order'         => 500,
                'keywords'      => 'tenants settings multi tenant tenancy saas organisation',
                'permissions'   => ['kloos.saas.manage_tenants'],
            ],
        ];
    }
}