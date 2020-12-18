<?php namespace Kloos\Saas;

use Event;
use Backend;
use BackendMenu;
use BackendAuth;
use System\Classes\PluginBase;
use Kloos\Saas\Console\FreshTenant;
use Kloos\Saas\Console\MigrateTenant;
use Kloos\Saas\Classes\Extend\ExtendTenant;
use Kloos\Saas\Classes\Extend\ExtendBackendUser;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'          => 'kloos.saas::lang.plugin.name',
            'description'   => 'kloos.saas::lang.plugin.description',
            'author'        => 'kloos.saas::lang.plugin.author',
        ];
    }

    public function boot()
    {
        $this->app['Illuminate\Contracts\Http\Kernel']
            ->pushMiddleware('Kloos\Saas\Classes\ResolveTenantByDomainMiddleware');

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
        });

        $this->registerEvents();
    }

    public function registerEvents()
    {
        Event::subscribe(ExtendTenant::class);
        Event::subscribe(ExtendBackendUser::class);
    }

    public function registerPermissions()
    {
        return [
            'kloos.saas.manage_tenants' => [
                'tab' => 'Tenants',
                'label' => 'Manage tenants'
            ],
        ];
    }

    public function registerFormWidgets()
    {
    }

    public function registerSettings()
    {
        return [
            'tenants' => [
                'label'       => 'Tenants',
                'description' => 'Manage tenants',
                'category'    => 'Tenants',
                'icon'        => 'icon-building',
                'url'         => Backend::url('kloos/saas/tenants'),
                'order'       => 500,
                'keywords'    => 'tenants multi tenancy saas organisation',
            ]
        ];
    }
}